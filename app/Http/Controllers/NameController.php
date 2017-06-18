<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Survey;
use App\Participant;
use App\University;
use App\Instructor;

class NameController extends Controller
{

  public function showList($slug) {

    $survey = Survey::where('slug', $slug)->first();

    return view('showList', [
        'survey' => $survey,
        'participant' => true,
    ]);
  }


  public function saveName(Request $request, $slug) {

    $survey = Survey::where('slug', $slug)->first();

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
      ]);
    }

    Session::flash('studentError', 'There was an error recording your name. Please try again.');
    return redirect()->back();
  }


  public function saveAltName(Request $request, $slug) {

    Session::flash('maunalPage', true);

    $survey = Survey::where('slug', $slug)->first();

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

    if($request->university === 'notlisted') {
      $university = new University;
      $university->survey_id = $survey->id;
      $university->name = ucwords($request->manualUniversity);
      $university->save();
    } else {
      $university = University::where('id', $request->university)->first();
    }

    $instructor = new Instructor;
    if(is_null($request->instructorfirst)) {
      $instructor->first_name = '---';
    } else {
      $instructor->first_name = ucfirst($request->instructorfirst);
    }
    $instructor->last_name = ucfirst($request->instructorlast);
    $instructor->survey_id = $survey->id;
    $instructor->university_id = $university->id;
    $instructor->student_added = true;
    $instructor->save();

    $participant = new Participant;
    $participant->instructor_id = $instructor->id;
    $participant->first_name = ucfirst($request->studentfirst);
    $participant->last_name = ucfirst($request->studentlast);
    $participant->class = ucfirst($request->studentclass);
    if($participant->save()) {
      return view('thanks', [
          'survey' => $survey,
          'participant' => true,
      ]);
    }

    Session::flash('manualStudentError', 'There was an error recording your name. Please try again.');
    return redirect()->back();
  }
}
