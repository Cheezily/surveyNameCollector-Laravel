<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

@include('layouts.partials._head')
<body>
@include('layouts.partials._nav')

<div class="container">
  <div class="panel panel-default">
    <div class="panel-heading">
      <h4 class="section-head">Survey Extra Credit</h4>
      <p>Please select the instructor offering extra credit for your participation.</p>
    </div>
    <div class="panel-body">
      <form id='mainForm' class="form-group" method="post" action="savename">
        <label for="instructor">Your Instructor's Name</label>
        <select id="instructor" class="instructorList form-control">
          @foreach($survey->universities as $university)
            @if(count($university->instructors) > 0)
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
        <label for="studentfirst">Your First Name</label>
        <input class='form-control' type="text" id='studentfirst' name="studentfirst">
        <label for="studentfirst">Your Last Name</label>
        <input class='form-control' type="text" id='studentfirst' name="studentlast">
        {{ csrf_field() }}
      </form>

      <form id='altForm' class="form-group" method="post" action="savealtname">
        <p>Since your instructor was not listed, please select your university from the list and enter the
          instructor's name. If your university is not listed, select NOT LISTED and enter the university
          name manually.
        </p>
        <label for="universityList">Your University Affiliation</label>
        <select id="universityList" class="instructorList form-control">
          @foreach($survey->universities as $university)
            <option value="{{ $university->id }}">{{ $university->name }}</option>
          @endforeach
            <option DISABLED="true">─────────────────────────</option>
            <option value="notlisted">UNIVERSITY NOT LISTED</option>
        </select>
        <label for="studentfirst">Your First Name</label>
        <input class='form-control' type="text" id='studentfirst' name="studentfirst">
        <label for="studentfirst">Your Last Name</label>
        <input class='form-control' type="text" id='studentfirst' name="studentlast">
        {{ csrf_field() }}
      </form>
    </div>
  </div>
</div>

<script src="{{ mix('js/participant.js') }}"></script>
</body>


</html>

