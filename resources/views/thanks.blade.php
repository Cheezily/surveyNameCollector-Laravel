<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

@include('layouts.partials._head')
<body>
@include('layouts.partials._nav')

  <div class="container">
    <div class="panel panel-default">
      <div class="panel-heading">
        <h4 class="section-head">Survey Extra Credit</h4>
      </div>
      <div class="panel-body">
        <h4>{{ $output }}</h4>
      </div>
    </div>
  </div>

</body>

</html>

