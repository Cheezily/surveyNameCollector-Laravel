<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Survey;

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
}
