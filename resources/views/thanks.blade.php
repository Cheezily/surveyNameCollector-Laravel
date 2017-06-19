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

  <script>
    (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
          (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
        m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
    })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

    ga('create', 'UA-92837500-2', 'auto');
    ga('send', 'pageview');

  </script>
</body>

</html>

