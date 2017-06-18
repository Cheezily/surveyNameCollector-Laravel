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

      $instructor->delete();
      return redirect()->back();
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
}
