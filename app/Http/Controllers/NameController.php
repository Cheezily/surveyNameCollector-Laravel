<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Survey;

class NameController extends Controller
{

  public function showList($slug) {

    $survey = Survey::where('slug', $slug)->first();

    return view('showList', [
        'survey' => $survey,
        'participant' => true,
    ]);
  }
}
