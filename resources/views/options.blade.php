@extends('layouts.app')

@section('content')

    @if(Session::has('change_success'))
      <div class="col-md-6 col-md-offset-3 alert alert-success optionSuccess">
        <div class="col-md-11">
          {{ Session::get('change_success') }}
        </div>
        <div class="col-md-1 text-right closeOptionSuccess">
          <span class="glyphicon glyphicon-remove"></span>
        </div>
      </div>
    @endif
    @if(Session::has('change_fail'))
      <div class="col-md-10 col-md-offset-1 alert alert-danger">{{ Session::get('change_fail') }}</div>
    @endif


      <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-default">
          <div class="panel-heading">
            <div class="row">
              <div class="col-md-6 col-sm-12">
                <h4><b class="section-head">Survey Name: </b>{{ $survey->name }}</h4>
              </div>
              <div class="col-md-6 col-sm-12 text-right">
                <h4 class="section-head"><b>URL:</b>
                <a href="{{url('/', ['survey', $survey->slug])}}">
                  {{url('/', ['survey', $survey->slug])}}</a>
                  <span class="glyphicon glyphicon-copy copyAddressOptions"></span>
                </h4>
              </div>
            </div>
          </div>
        </div>
      </div>

    <textarea style="display: block;" class="hiddenLink">{{url('/', ['survey', $survey->slug])}}</textarea>

    <div class="row">

      <div class="col-md-3 col-md-offset-1">
        <div class="row">
          <div class="panel panel-default">
            <div class="panel-heading">
              <h4 class="section-head">Start & End Dates For Name Collection</h4>
            </div>
            <div class="panel-body">
              @if(is_null($survey->start))
                <h4><b>Opens:</b> <span class="optionInfo"> {{ date('D - M j, Y g:i a T', strtotime($survey->created_at)) }}</span></h4>
              @else
                <h4><b>Opens:</b> <span class="optionInfo"> {{ date('D - M j, Y g:i a T', strtotime($survey->start)) }}</span></h4>
              @endif
              <form class="form-inline" method="post" action="{{ url('/', ['admin', $survey->id, 'changestart']) }}">
                <label for="newstart">New Start Date & Time</label><br>
                <input class='form-control input-sm' type="datetime-local" name="newstart">
                {{ csrf_field() }}
                <input type='submit' class="btn btn-sm btn-primary" value="Change Start">
                <p><i> If clicked while the date & time are blank, it will move the start back to the creation date.</i></p>
              </form>
              <hr>

              @if(is_null($survey->end))
                <h4><b>Closes: </b><span class="optionInfo">No Closing Date Set</span></h4>
              @else
                <h4><b>Closes: </b><span class="optionInfo"> {{ date('D - M j, Y g:i a T', strtotime($survey->end)) }}</span></h4>
              @endif
              <form class="form-inline" method="post" action="{{ url('/', ['admin', $survey->id, 'changeend']) }}">
                <label for="newstart">New End Date & Time</label><br>
                <input class='form-control input-sm' type="datetime-local" name="newend">
                {{ csrf_field() }}
                <input type='submit' class="btn btn-sm btn-primary" value="Change End">
                <p><i> If clicked while the date & time are blank, it will remove the end date.</i></p>
              </form>
            </div>
          </div>

          <div class="panel panel-default">
            <div class="panel-heading">
              <h4 class="section-head">Special Instructions For Participants (Optional)</h4>
            </div>
            <div class="panel-body">
              <p><i>These will be displayed to the survey participant when they land on the page.</i></p>
              <form method="post" action="addinstructions">
                <textarea name="instructions" rows="7" style="width: 100%;">{{ trim($survey->instructions) }}</textarea>
                {{ csrf_field() }}
                <input class='btn btn-sm btn-primary' type="submit" value="Submit">
              </form>
            </div>
          </div>
        </div>
      </div>

      <div class="col-md-7">
        <div class="panel panel-default">
          <div class="panel-heading">
            <h4 class="section-head">Other Instructors Offering Extra Credit</h4>
          </div>
          <div class="panel-body">
            <div class="panel-heading">
              <div class="addUniversity col-md-12 text-right">
                <form class='form-inline' method="post" action="adduniversity">
                  {{ csrf_field() }}
                  <i class="addUniversityLabel">Add the instructor's university affiliation first then add names to their appropriate university.</i>
                  <input type="text" placeholder="Add New University Affiliation Here..." name="adduniversity"
                         class="form-control input-sm addUniversityInput">
                  <input class='btn btn-sm btn-primary' type="submit" value="Add University">
                  <hr>
                  @if(Session::has('university_error'))
                    <p style="color: red;">{{ Session::get('university_error') }}</p>
                  @endif
                </form>
              </div>
              <br>
              <div class="row">
                @foreach ($survey->universities as $university)
                  <div class="col-md-11 col-md-offset-1 panel panel-default">
                    <div class="panel-heading">
                      <div class="row">
                        <div class="col-md-9 universityTitle">
                          {{ $university->name }}
                          @if($university->student_added)
                            <span class="label label-info instructorRespondentCount">Added By Student</span>
                          @endif
                        </div>
                        <div class="col-md-3 text-right">
                          <button class="btn btn-xs btn-danger deleteUniversityButton"
                            university="{{ $university->id }}">Delete University</button>
                        </div>
                      </div>
                    </div>
                      <div class="panel-heading text-right">
                        <form class="form-inline" method="post" action="addinstructor">
                          <div class="col-md-9">
                            <div class="col-md-4 text-right">
                              <input class='form-control input-sm newInstructorField' type="text"
                                     name="first_name" placeholder="First Name..." >
                            </div>
                            <div class="col-md-4 text-center">
                              <input class='form-control input-sm newInstructorField' type="text"
                                     name="last_name" placeholder="Last Name..." >
                            </div>
                            <div class="col-md-4 text-left">
                              <input class='form-control input-sm newInstructorField' type="email"
                                     name="email" placeholder="Email (optional)...">
                            </div>
                          <input type="hidden" name="university_id" value="{{ $university->id }}">
                          </div>
                          {{ csrf_field() }}
                          <input type="submit" class="btn btn-sm btn-primary" value="Add Instructor">
                          @if(Session::has('instructorError'.$university->id))
                            <p style="color: red;">{{ Session::get('instructorError'.$university->id) }}</p>
                          @endif
                        </form>
                      </div>

                    <div class="panel-body">
                      @foreach ($university->instructors as $instructor)
                        <div class="row instructorOptionList">
                          <div class="col-md-9 col-sm-9">
                            <span class="label label-default instructorRespondentCount">Respondents: {{ count($instructor->participants) }}</span>
                            @if($instructor->student_added)
                              <span class="label label-info instructorRespondentCount">Added By Student</span>
                            @endif
                            {{ $instructor->first_name }} {{ $instructor->last_name }}
                            @if ($instructor->email)
                              - {{ $instructor->email }}
                            @endif
                          </div>
                          <div class="col-md-3 text-right">
                            <button class="btn btn-xs btn-danger deleteInstructorButton"
                                    instructor="{{ $instructor->id }}">Delete Instructor</button>
                          </div>
                        </div>
                      @endforeach
                    </div>
                  </div>
                @endforeach
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

      <div class="confirmationWrapper">
        <div class="panel panel-default col-md-4 col-md-offset-4 deleteUniversityDialog">
          <div class="panel-heading">
            <h4 class="section-head">Confirm University Deletion</h4>
          </div>
          <div class="panel-body">
            <h5>Please confirm that you want to delete this university. This will delete any instructors and
              student names attached to it.  This cannot be undone.</h5>
            <button class="col-md-3 btn btn-sm btn-primary cancelDeleteUniversity">Cancel</button>
            <form class="form-inline" method="post" action="deleteuniversity">
              {{ csrf_field() }}
              <input type='hidden' name="university_id" id="deleteUniversityId">
              <input class='col-md-3 col-md-offset-6 btn btn-sm btn-danger deleteUniversity' type="submit" value="Delete University">
            </form>
          </div>
        </div>
      </div>

      <div class="panel panel-default col-md-4 col-md-offset-4 deleteInstructorDialog">
        <div class="panel-heading">
          <h4 class="section-head">Confirm Instructor Deletion</h4>
        </div>
        <div class="panel-body">
          <h5>Please confirm that you want to delete this instructor. This will delete student names attached to it.
            This cannot be undone.</h5>
          <button class="col-md-3 btn btn-sm btn-primary cancelDeleteInstructor">Cancel</button>
          <form class="form-inline" method="post" action="deleteinstructor">
            {{ csrf_field() }}
            <input type='hidden' name="instructor_id" id="deleteInstructorId">
            <input class='col-md-3 col-md-offset-6 btn btn-sm btn-danger deleteUniversity' type="submit" value="Delete Instructor">
          </form>
        </div>
      </div>
    </div>
    
@endsection