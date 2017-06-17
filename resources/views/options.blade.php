@extends('layouts.app')

@section('content')
  <div class="container">

    @if(Session::has('change_success'))
      <div class="alert alert-success">{{ Session::get('change_success') }}</div>
    @endif
    @if(Session::has('change_fail'))
      <div class="alert alert-danger">{{ Session::get('change_fail') }}</div>
    @endif

    <div class="panel panel-default">
      <div class="panel-heading">
        <h4><b>Survey Name: </b>{{ $survey->name }}</h4>
        <p><b>Name Collection URL:</b> {{url('/', [$survey->slug])}}</p>
        <p><b>Created:</b> {{ date('D - M j, Y g:i a T', strtotime($survey->created_at)) }}</p>
      </div>
    </div>

    <div class="panel panel-default">
      <div class="panel-heading">
        <h4>Other Instructors Offering Extra Credit</h4>
      </div>
      <div class="panel-body">
        <p><i>Add the university affiliation first then add instructors to their appropriate university.</i></p>
        <div class="row">
          <div class="addUniversity col-md-10">
            <form class='form-inline' method="post" action="adduniversity">
              {{ csrf_field() }}
              <input type="text" placeholder="Add New University Affiliation Here..." class="form-control input-sm addUniversityInput">
              <input class='btn btn-sm btn-primary' type="submit" value="Add University">
            </form>
          </div>
          @foreach ($survey->universities as $university)
            <div class="col-md-10 col-md-offset-1">
              <h4>{{ $university->name }}</h4>
              @foreach ($university->instructors as $instructor)
                {{ $instructor->name }}
              @endforeach
            </div>
          @endforeach
        </div>
      </div>
    </div>

    <div class="panel panel-default">
      <div class="panel-heading">
        <h4>Start & End Dates For Name Collection</h4>
      </div>
      <div class="panel-body">
        @if(is_null($survey->start))
          <h4><b>Open From:</b> <span class="optionInfo"> {{ date('D - M j, Y g:i a T', strtotime($survey->created_at)) }}</span></h4>
        @else
          <h4><b>Open From:</b> <span class="optionInfo"> {{ date('D - M j, Y g:i a T', strtotime($survey->start)) }}</span></h4>
        @endif
        <form class="form-inline" method="post" action="{{ url('/', ['admin', $survey->id, 'changestart']) }}">
          <label for="newstart">New Start Time & Date</label>
          <input class='form-control input-sm' type="datetime-local" name="newstart">
          {{ csrf_field() }}
          <input type='submit' class="btn btn-sm btn-primary" value="Change Start Date">
          <span><i> If clicked while the date & time are blank, it will move the start back to the creation date.</i></span>
        </form>
        <hr>

        @if(is_null($survey->end))
            <h4><b>Open Until: </b><span class="optionInfo">No Closing Date Set</span></h4>
        @else
            <h4><b>Open Until: </b><span class="optionInfo"> {{ date('D - M j, Y g:i a T', strtotime($survey->end)) }}</span></h4>
        @endif
        <form class="form-inline" method="post" action="{{ url('/', ['admin', $survey->id, 'changeend']) }}">
          <label for="newstart">New End Time & Date</label>
          <input class='form-control input-sm' type="datetime-local" name="newend">
          {{ csrf_field() }}
          <input type='submit' class="btn btn-sm btn-primary" value="Change End Date">
          <span><i> If clicked while the date & time are blank, it will remove the end date.</i></span>
        </form>
      </div>
    </div>


  </div>

@endsection