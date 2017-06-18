<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

@include('layouts.partials._head')
<body>
@include('layouts.partials._nav')

<div class="container">

  @if(!empty($survey->instructions))
    <div class="panel panel-default">
      <div class="panel-heading">
        <h4 class="section-head">Special Instructions</h4>
      </div>
      <div class="panel-body">
        <pre>{{ $survey->instructions }}</pre>
      </div>
    </div>
  @endif

  <div class="panel panel-default">
    <div class="panel-heading">
      <h4 class="section-head">Survey Extra Credit</h4>
      <p>Please select the instructor offering extra credit for your participation.</p>
    </div>
    <div class="panel-body">
      <form id='mainForm' class="form-group mainForm" method="post" action="savename"
        @if(Session::has('maunalError'))
          style="display: none;"
        @else
          style="display: block;"
        @endif
      >
        <label for="instructor">Your Instructor's Name</label>
        <select id="instructor" class="instructorList form-control input-sm">
          <option disabled="true" selected=""true>Select Your University Affiliation</option>
          <option DISABLED="true">─────────────────────────</option>
          @foreach($survey->universities as $university)
            <?php
              $validInstructors = false;
              foreach($university->instructors as $instructor) {
                if($instructor->student_added == false) {
                  $validInstructors = true;
                }
              }
            ?>
            @if($validInstructors)
              <option disabled="true">{{ $university->name }}</option>
              @foreach($university->instructors as $instructor)
                <option value="{{ $instructor->id }}">
                  &nbsp;&nbsp;&nbsp;&nbsp;
                  {{ $instructor->first_name }} {{ $instructor->last_name }}
                </option>
              @endforeach
              </option>
            @endif
          @endforeach
        </select>
        <hr>
        <label for="studentfirst">Your First Name</label>
        <input class='form-control input-sm' type="text" id='studentfirst' name="studentfirst">
        <label for="studentfirst">Your Last Name</label>
        <input class='form-control input-sm' type="text" id='studentfirst' name="studentlast">
        <label for="studentclass">Class You're Getting Extra Credit In</label>
        <input class='form-control input-sm' type="text" id='studentclass' name="studentclass">
        @if(!empty(Session::has('studentError')))
          <p style="color: red;">{{ Session::get('studentError') }}</p>
        @endif
        {{ csrf_field() }}
        <br>
        <button class="col-md-2 btn btn-sm btn-warning notListed">Instructor Not Listed</button>
        <input type="submit" class="col-md-2 col-md-offset-8 btn btn-sm btn-primary" value="Submit">
      </form>

      <br>

      <form id='altForm' class="altForm form-group" method="post" action="savealtname"
        @if(Session::has('maunalError'))
          style="display: block;"
        @else
            style="display: none;"
        @endif
      >
        <p>Since your instructor was not listed, please select your university from the list and enter the
          instructor's name. If your university is not listed, select NOT LISTED and enter the university
          name manually.
        </p>
        <label for="universityList">Your University Affiliation</label>
        <select id="universityList" class="instructorList form-control input-sm">
          @foreach($survey->universities as $university)
            <option value="{{ $university->id }}">{{ $university->name }}</option>
          @endforeach
            <option DISABLED="true">─────────────────────────</option>
            <option value="notlisted">UNIVERSITY NOT LISTED</option>
        </select>
        <div class="manualUniversityBox">
          <hr>
          <label for="manualUniversity">Enter Your University Name</label>
          <input class='form-control input-sm' type="text" id='manualUniversity' name="manualUniversity">
          @if(!empty(Session::has('manualUniversityError')))
            <p style="color: red;">{{ Session::get('manualUniversityError') }}</p>
          @endif
        </div>
          <hr>
          <h3>Instructor Information</h3>
          <label for="instructorfirst">Instructor First Name</label>
          <input class='form-control input-sm' type="text" id='instructorfirst' name="instructorfirst">
          <label for="instructorlast">Instructor Last Name</label>
          <input class='form-control input-sm' type="text" id='instructorlast' name="instructorlast" required>
          @if(Session::has('manualInstructorError'))
            <p style="color: red;">{{ Session::get('manualInstructorError') }}</p>
          @endif
          <p>
            Please don't enter names like "Don't Know" or "I Forgot". We cannot track down
            instructors.
          </p>
          <hr>
        <h3>Your Information</h3>
        <label for="studentfirst">Your First Name</label>
        <input class='form-control input-sm' type="text" id='studentfirst' name="studentfirst" required>
        <label for="studentlast">Your Last Name</label>
        <input class='form-control input-sm' type="text" id='studentlast' name="studentlast" required>
        <label for="studentclass">Class You're Getting Extra Credit In</label>
        <input class='form-control input-sm' type="text" id='studentclass' name="studentclass" required>
        @if(!empty(Session::has('manualStudentError')))
          <p style="color: red;">{{ Session::get('manualStudentError') }}</p>
        @endif
        {{ csrf_field() }}
        <br>
        <button class="col-md-2 btn btn-sm btn-info backButton">Back</button>
        <input type="submit" class="col-md-2 col-md-offset-8 btn btn-sm btn-primary" value="Submit">
      </form>
    </div>
  </div>
</div>

<script src="{{ mix('js/participant.js') }}"></script>
</body>


</html>

