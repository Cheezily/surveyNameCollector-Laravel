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

    //dd($survey);

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


  public function saveName(Request $request, $slug) {

    $survey = Survey::with(['universities', 'universities.instructors'])
      ->where('slug', $slug)->first();

    if(is_null($survey)) {
      return redirect()->back();
    }

    if(is_null($request->instructor)) {
      Session::flash('studentError', 'Please select the instructor who is offering extra credit.');
      return redirect()->back();
    }

    if(is_null($request->studentfirst) || is_null($request->studentlast)) {
      Session::flash('studentError', 'Please enter both your first and last name.');
      return redirect()->back();
    }

    if(is_null($request->studentclass)) {
      Session::flash('studentError', 'Please enter the name of the class you are getting extra credit for.');
      return redirect()->back();
    }

    $participant = new Participant;
    $participant->instructor_id = $request->instructor;
    $participant->first_name = ucfirst($request->studentfirst);
    $participant->last_name = ucfirst($request->studentlast);
    $participant->class = $request->studentclass;
    if($participant->save()) {
      return view('thanks', [
          'survey' => $survey,
          'participant' => true,
          'output' => 'Thanks!  Your participation has been recorded.  Your instructor will be notified soon.',
      ]);
    }

    Session::flash('studentError', 'There was an error recording your name. Please try again.');
    return redirect()->back();
  }


  public function saveNames(Request $request, $slug) {

    $status = 'success';
    $errors = [];

    $survey = Survey::with(['universities', 'universities.instructors'])
      ->where('slug', $slug)->first();

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
        //return response()->json(['errors' => $instructor]);
      }
    }

    if($errors) {
      return response()->json(['errors' => $errors]);
    }
/*
    foreach($request->instructors as $instructor) {
      $instructor = new Instructor;
      $instructor->first_name = $instructorFirstName;
      $instructor->last_name = ucfirst($request->instructorlast);
      $instructor->survey_id = $survey->id;
      $instructor->university_id = $university->id;
      $instructor->student_added = true;
      $instructor->save();
    }
*/

    return response()->json(['status' => 'success']);

  }


  public function saveAltName(Request $request, $slug) {

    Session::flash('maunalPage', true);

    $survey = Survey::with(['universities', 'universities.instructors'])
      ->where('slug', $slug)->first();

    if(is_null($survey)) {
      return redirect()->back();
    }

    if(is_null($request->university)) {
      Session::flash('manualUniversityError', 'Please select the name of the university.');
      return redirect()->back();
    }

    if($request->university === 'notlisted' && is_null($request->manualUniversity)) {
      Session::flash('manualUniversityError', 'Please enter the name of the university if UNIVERSITY NOT LISTED is selected.');
      return redirect()->back();
    }

    if(is_null($request->instructorlast)) {
      Session::flash('manualInstructorError', 'Please enter at least the last name of your instructor.');
      return redirect()->back();
    }

    if(is_null($request->studentfirst) || is_null($request->studentlast)) {
      Session::flash('manualStudentError', 'Please enter both your first and last name.');
      return redirect()->back();
    }

    if(is_null($request->studentclass)) {
      Session::flash('manualStudentError', 'Please enter the name of the class you are getting extra credit for.');
      return redirect()->back();
    }

    //Save a new university or load it if it exists. These dupe
    if($request->university === 'notlisted') {
      $universityDuplicateTest = University::where('survey_id', $survey->id)
          ->where('name', ucwords($request->manualUniversity))->first();

      if(is_null($universityDuplicateTest)) {
        $university = new University;
        $university->survey_id = $survey->id;
        $university->name = ucwords($request->manualUniversity);
        $university->student_added = true;
        $university->save();
      } else {
        $university = $universityDuplicateTest;
      }

    } else {
      $university = University::where('id', $request->university)->first();
    }

    //figure out the first name before testing to see if it's a duplicate
    if(is_null($request->instructorfirst)) {
      $instructorFirstName = '---';
    } else {
      $instructorFirstName = ucfirst($request->instructorfirst);
    }

    $instructorDuplicateTest = Instructor::where('first_name', $instructorFirstName)
        ->where('university_id', $university->id)
        ->where('last_name', ucfirst($request->instructorlast))
        ->where('survey_id', $survey->id)->first();

    if(is_null($instructorDuplicateTest)) {
      $instructor = new Instructor;
      $instructor->first_name = $instructorFirstName;
      $instructor->last_name = ucfirst($request->instructorlast);
      $instructor->survey_id = $survey->id;
      $instructor->university_id = $university->id;
      $instructor->student_added = true;
      $instructor->save();
    } else {
      $instructor = $instructorDuplicateTest;
    }

    $participantDuplicateTest = Participant::where('first_name', ucfirst($request->studentfirst))
        ->where('last_name', ucfirst($request->studentlast))
        ->where('instructor_id', $instructor->id)
        ->where('class', ucfirst($request->studentclass))->first();

    if(is_null($participantDuplicateTest)) {
      $participant = new Participant;
      $participant->instructor_id = $instructor->id;
      $participant->first_name = ucfirst($request->studentfirst);
      $participant->last_name = ucfirst($request->studentlast);
      $participant->class = ucfirst($request->studentclass);

      if($participant->save()) {
        $output = 'Thanks!  Your participation has been recorded.  Your instructor will be notified soon.';
      } else {
        $output = 'Your name has already been recorded for this survey. Thank you for your participation.';
      }

      return view('thanks', [
          'survey' => $survey,
          'participant' => true,
          'output' => $output,
      ]);
    }

    Session::flash('manualStudentError', 'There was an error recording your name. Please try again.');
    return redirect()->back();
  }
}
