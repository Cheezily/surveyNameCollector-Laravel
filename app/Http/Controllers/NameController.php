<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Survey;
use App\Participant;
use App\University;
use App\Instructor;
use Illuminate\Validation\Rules\In;

class NameController extends Controller
{

  public function showList($slug) {

    $survey = Survey::with(['universities', 'universities.instructors'])
      ->where('slug', $slug)->first();

    if(is_null($survey)) {
      return view('invalidLink');
    }

    $surveyStart = date(strtotime($survey->start));
    $surveyEnd = date(strtotime($survey->end));
    $now = date(strtotime('now'));

    if($surveyEnd < $now && !is_null($survey->end)) {
      $tooLate = true;
      $tooEarly = false;
    } elseif ($surveyStart > $now && !is_null($survey->start)) {
      $tooLate = false;
      $tooEarly = true;
    } else {
      $tooLate = false;
      $tooEarly = false;
    }

    return view('showList', [
        'survey' => $survey,
        'participant' => true,
        'tooEarly' => $tooEarly,
        'tooLate' => $tooLate,
        'survey_json' => $survey->toarray()
    ]);
  }


  public function saveNames(Request $request, $slug) {

    $status = 'success';
    $errors = [];

    $survey = Survey::with(['universities', 'universities.instructors'])
      ->where('slug', $slug)->first();

    if (empty($survey)) {
      return response()->json(['status' => 'error']);
    }

    if(empty($request->participant_firstname) 
      || empty($request->participant_lastname)) {
      $errors[] = 'yourName';
    }

    if(empty($request->instructors)) {
      $errors[] = 'noInstructors';
    }
    
    foreach($request->instructors as $instructor) {
      if(empty($instructor['course'])) {
        $errors[] = 'courseWarning';
      }
      if(empty($instructor['university_name'])) {
        $errors[] = 'universityWarning';
      }
    }

    if($errors) {
      return response()->json(['errors' => $errors]);
    }

    foreach($request->instructors as $selected_instructor) {
      //Check if the participant added the instructor manually
      if ($selected_instructor['student_added'] === 1 
        && $selected_instructor['id'] < 0) {

        //Participant selected an existing university
        if($selected_instructor['university_id'] > 0) {
          $university = University::find($selected_instructor['university_id']);
          if (is_null($university)) {
            return response()->json(['errors' => ['universityWarning']]);
          }
        }
        
        //Participant provided a new university
        if (empty($university) || $selected_instructor['university_id'] < 0) {
          $university = new University;
          $university->name = ucfirst(trim($selected_instructor['university_name']));
          $university->student_added = 1;
          $university->survey_id = $survey->id;
          $university->save();
        }

        $instructor = new Instructor;
        if (!is_null($selected_instructor['first_name'])) {
          $instructor->first_name = ucfirst(trim($selected_instructor['first_name']));
        }
        $instructor->last_name = ucfirst(trim($selected_instructor['last_name']));
        $instructor->student_added = true;
        $instructor->university_id = $university->id;
        $instructor->save();  
      } else {
        $university = University::where('id', $selected_instructor['university_id'])
        ->where('survey_id', $survey->id)->first();
        $instructor = Instructor::where('id', $selected_instructor['id'])
          ->where('university_id', $university->id)->first();

        if (is_null($instructor) || is_null($university)) {
          return response()->json(['status' => ['error']]);
        }
      }

      $participant = new Participant;
      $participant->first_name = ucfirst(trim($request->participant_firstname));
      $participant->last_name = ucfirst(trim($request->participant_lastname));
      $participant->class = $selected_instructor['course'];
      $participant->instructor_id = $instructor->id;
      $participant->save();
    }

    return response()->json(['status' => 'success']);
  }
}
