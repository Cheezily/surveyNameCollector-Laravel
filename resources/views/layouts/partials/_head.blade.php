<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="Separate academic survey results from the collection of names for extra credit.
    Add participating instructors and export the participant name list to Excel.">

  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>{{ config('app.name', 'Laravel') }} | Anonymize Academic Survey Results Answers</title>

  <!-- Styles -->
  <link href="{{ mix('css/app.css') }}" rel="stylesheet">

  <!-- Jquery -->
  <script src="{{ asset('js/jquery-3.2.1.slim.min.js') }}" type="text/javascript"></script>

  <?php $analytics = App\Option::find(1)->google_analytics_key; ?>

  @if(!empty($analytics))
  <script>
    (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
          (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
        m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
    })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

    ga('create', '{{ $analytics }}', 'auto');
    ga('send', 'pageview');

  </script>
  @endif

</head>