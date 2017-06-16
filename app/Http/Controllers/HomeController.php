<?php

namespace App\Http\Controllers;

use App\Survey;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $surveys = Survey::where('user_id', Auth::user()->id)
            ->orderBy('created_at', 'DESC')->get();

        return view('home',
            [
                'surveys' => $surveys,
            ]);
    }


    public function create(Request $request)
    {
        if (!$request->newsurveyname) {
          Session::flash('name_error', 'Survey Name is Required');
          return redirect()->back();
        }

        $survey = new Survey;
        $survey->name = trim(ucwords($request->newsurveyname));

        if (is_null($request->newsurveystart)) {
          $survey->start = null;
        } else {
          $survey->start = date("Y-m-d H:i:s", strtotime($request->newsurveystart));
        }


        if (is_null($request->newsurveyend)) {
          $survey->end = null;
        } else {
          $survey->end = date("Y-m-d H:i:s", strtotime($request->newsurveyend));
        }

        $slug = substr(md5(rand(1,999999)), 0, 10);
        while (Survey::where('slug', $slug)->first()) {
          $slug = substr(md5(rand(1,999999)), 0, 10);
        }
        $survey->slug = $slug;

        $survey->user_id = Auth::user()->id;

        $survey->save();

        if (Survey::where('slug', $slug)->get()) {
          Session::flash('createsuccess', "Survey Name Collector Created Successfully!");
          return redirect()->back();
        }

        Session::flash('createfail', "There was an error creating the Survey Name Collector. Please try again.");
        return redirect()->back();
    }
}
