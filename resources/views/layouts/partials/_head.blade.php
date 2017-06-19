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
</head>