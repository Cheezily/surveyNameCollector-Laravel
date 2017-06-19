<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Survey;
use App\University;
use App\Instructor;

class SurveyAdminController extends Controller
{

    public function __construct()
    {
      $this->middleware('auth');
    }


    public function showOptions($survey_id)
    {
      $survey = Survey::where('id', $survey_id)
          ->where('user_id', Auth::user()->id)->first();

      if(is_null($survey)) {
        return redirect()->back();
      }

      return view('options', [
         'survey' => $survey,
          'option_page' => true,
      ]);
    }


    public function changeStart(Request $request, $survey_id)
    {
      $survey = Survey::where('id', $survey_id)
          ->where('user_id', Auth::user()->id)->first();

      if(is_null($survey)) {
        return redirect()->back();
      }

      if(is_null($request->newstart)) {
        $survey->start = $survey->created_at;
      } else {
        $survey->start = date("Y-m-d H:i:s", strtotime($request->newstart));
      }

      if($survey->save()) {
        Session::flash('change_success', 'Start Date Changed Successfully!');
        return redirect()->back();
      }

      Session::flash('change_fail', 'Start Date Not Changed. Please Try Again.');
      return redirect()->back();
    }


    public function changeEnd(Request $request, $survey_id)
    {
      $survey = Survey::where('id', $survey_id)
          ->where('user_id', Auth::user()->id)->first();

      if(is_null($survey)) {
        return redirect()->back();
      }

      if(is_null($request->newend)) {
        $survey->end = $survey->null;
      } else {
        $survey->end = date("Y-m-d H:i:s", strtotime($request->newend));
      }

      if($survey->save()) {
        Session::flash('change_success', 'End Date Changed Successfully!');
        return redirect()->back();
      }

      Session::flash('change_fail', 'End Date Not Changed. Please Try Again.');
      return redirect()->back();
    }


    public function addUniversity(Request $request, $survey_id)
    {
      $survey = Survey::where('id', $survey_id)
          ->where('user_id', Auth::user()->id)->first();

      if(is_null($survey)) {
        return redirect()->back();
      }

      if(is_null($request->adduniversity)) {
        Session::flash('university_error', 'Please enter a university name');
        return redirect()->back();
      }

      $university = new University;
      $university->name = $request->adduniversity;
      $university->survey_id = $survey_id;
      if($university->save()) {
        return redirect()->back();
      }

      Session::flash('university_error', 'Error saving university name. Please try again.');
      return redirect()->back();
    }


    public function deleteUniversity(Request $request, $survey_id)
    {
      $survey = Survey::where('id', $survey_id)
          ->where('user_id', Auth::user()->id)->first();

      if(is_null($survey)) {
        return redirect()->back();
      }

      if(is_null($request->university_id)) {
        return redirect()->back();
      }

      $university = University::where('survey_id', $survey->id)
        ->where('id', $request->university_id)->first();

      if($university) {
        foreach($university->instructors as $instructor) {
          foreach($instructor->participants as $participant) {
            $participant->delete();
          }
          $instructor->delete();
        }
      }

      if($university->delete()) {
        return redirect()->back();
      }

      Session::flash('university_error', 'Error deleting university. Please try again.');
      return redirect()->back();
    }


    public function addInstructor(Request $request, $survey_id)
    {
      $survey = Survey::where('id', $survey_id)
          ->where('user_id', Auth::user()->id)->first();

      if(is_null($survey)) {
        return redirect()->back();
      }

      if(is_null($request->first_name) || is_null($request->last_name)) {
        Session::flash('instructorError'.$request->university_id, 'First and Last Name are Required. Please try again.');
        return redirect()->back();
      }

      $instructor = new Instructor;
      $instructor->first_name = ucwords($request->first_name);
      $instructor->last_name = ucwords($request->last_name);
      $instructor->email = $request->email;
      $instructor->university_id = $request->university_id;
      $instructor->survey_id = $survey_id;
      $instructor->save();
      return redirect()->back();
    }


    public function deleteInstructor(Request $request, $survey_id)
    {
      $survey = Survey::where('id', $survey_id)
          ->where('user_id', Auth::user()->id)->first();

      if(is_null($survey)) {
        return redirect()->back();
      }

      $instructor = Instructor::where('id', $request->instructor_id)
          ->where('survey_id', $survey->id)->first();

      if(is_null($instructor)) {
        return redirect()->back();
      }

      if($instructor) {
        foreach($instructor->participants as $participant) {
          $participant->delete();
        }
      }

      if($instructor->delete()) {
        return redirect()->back();
      }
    }


    public function addInstructions(Request $request, $survey_id)
    {
      $survey = Survey::where('id', $survey_id)
          ->where('user_id', Auth::user()->id)->first();

      if(is_null($survey)) {
        return redirect()->back();
      }

      $survey->instructions = trim($request->instructions);
      if($survey->save()) {
        Session::flash('change_success', 'Instructions updated!');
        return redirect()->back();
      }

      Session::flash('change_fail', 'Instructions not updated. Please try again.');
      return redirect()->back();
    }


    public function download($survey_id) {

      $survey = Survey::where('id', $survey_id)
          ->where('user_id', Auth::user()->id)->first();

      if(is_null($survey)) {
        exit;
      }

      $out = "Student First Name, Student Last Name, University, ".
          "Instructor First Name, Instructor Last Name, Instructor Email, Class, Time \n";

      $results = [];
      $universities = University::where('survey_id', $survey->id)->get();
      foreach($universities as $university) {
        foreach($university->instructors as $instructor) {
          foreach($instructor->participants as $participant) {
            $results[] = [
                'student_first' => $participant->first_name,
                'student_last' => $participant->last_name,
                'university' => $university->name,
                'instructor_first' => $instructor->first_name,
                'instructor_last' => $instructor->last_name,
                'instructor_email' => $instructor->email,
                'class' => $participant->class,
                'submitted' => $participant->created_at,
            ];
          }
        }
      }

      forEach($results as $line) {
        $out .= $line['student_first'].',';
        $out .= $line['student_last'].',';
        $out .= $line['university'].',';
        $out .= $line['instructor_first'].',';
        $out .= $line['instructor_last'].',';
        $out .= $line['instructor_email'].',';
        $out .= $line['class'].',';
        $out .= date("M j Y g:i:s A", strtotime($line['submitted']))." CST \n";
      }
      header("Content-type: application/octet-stream");
      header("Content-Disposition: attachment; filename=output.csv");
      header("Pragma: no-cache");
      header("Expires: 0");
      print $out;
    }
}
