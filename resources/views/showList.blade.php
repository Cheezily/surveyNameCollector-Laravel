<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

@include('layouts.partials._head')
<body>
@include('layouts.partials._nav')

  <div class="container" id="app">

    @if($tooEarly)
      <div class="panel panel-default">
        <div class="panel-heading">
          <h4 class="section-head">Name Collection Not Open</h4>
        </div>
        <div class="panel-body">
          <h4>
            Name collection for this survey is not open yet. The name collection is set to begin on
            {{ date('D - M j, Y g:i a T', strtotime($survey->start)) }}.
          </h4>
        </div>
      </div>
    @endif

    @if($tooLate)
      <div class="panel panel-default">
        <div class="panel-heading">
          <h4 class="section-head">Name Collection Not Open</h4>
        </div>
        <div class="panel-body">
          <h4>
            Name collection for this survey has closed. The name collection ended on
            {{ date('D - M j, Y g:i a T', strtotime($survey->end)) }}.
          </h4>
        </div>
      </div>
    @endif

    @if(!empty($survey->instructions))
      <h4 class="section-head">Special Instructions</h4>
      <pre>{{ $survey->instructions }}</pre>
      <hr>
    @endif

    @if(!$tooEarly && !$tooLate)
      <instructor-list 
        url="{{ Request::fullUrl() }}"
        survey="{{ $survey }}"></instructor-list>
    @endif

  </div>

  <script src="{{ mix('js/participant.js') }}"></script>

</body>


</html>

