<!doctype html>
<html lang="{{ config('app.locale') }}">
@include('layouts.partials._head')
    <body>
      <div class="mainBanner">
        <div class="mainWrapper">
          <div class="infoWrapper">
            <h1 class="mainTitle">
              <i>EXTRACREDIT.INFO</i>
            </h1>
            <hr>
            <div class="mainDescription">
              <p>
                This site was created for academics as a tool to separate survey responses from extra credit name
                collection. Since no connection is made to your survey site, participant survey responses remain
                anonymous.
              </p>
            </div>
          </div>
          <div class="homeButtonWrapper">
            @if (Auth::check())
              <a class='homeButton' href="{{ url('/home') }}">HOME</a>
            @else
              <a class='registerButton' href="{{ url('/register') }}">REGISTER</a>
              <a class='loginButton' href="{{ url('/login') }}">LOGIN</a>
            @endif
          </div>
        </div>
      </div>
      <div class="featureList">
        <h2>This Site Lets You</h2>
        <ul>
          <li>Add & Remove Instructors Offering Extra Credit (Grouped by University)</li>
          <li>Allow Participants Themselves To Add Universities And Instructors If They Are Not Listed</li>
          <li>Output The Participant List To An Excel-Readable .CSV File To Provide To Instructors</li>
          <li>Provide A Unique Link To Each Name Collector You Have On File At The End Of Your Survey</li>
        </ul>
      </div>
      <div class="footer">
        <p class="myname">
          &copy;<?php echo(date('Y', strtotime('now'))); ?>
          {{--  <span id="name1">AcademyBit</span>  --}}
          <a href="http://academybit.com" target="_blank">AcademyBit</span>
          {{--  <span id="name2">Dr. Kerri Milita</span>  --}}
        </p>
        <p class="github">
          <a href="https://github.com/Cheezily/surveyNameCollector-Laravel">
            Github
          </a>
        </p>
      </div>
    </body>

  <script type="text/javascript">
    var name1Output = document.getElementById('name1');
    name1Output.innerHTML = "<a href='mailto:contact@" + "academybit.com?Subject=Question Regarding ExtraCredit.Info'>"
        + "AcademyBit" + "</a>";
  </script>
  {{--  <script type="text/javascript">
    var name1Output = document.getElementById('name1');
    name1Output.innerHTML = "<a href='mailto:philip." + "michaels@" + "gmail.com?Subject=Question Regarding ExtraCredit.Info'>"
        + "Philip" + " " +  "Michaels" + "</a>";
    var name2Output = document.getElementById('name2');
    name2Output.innerHTML = " & <a href='mailto:kerri" + "milita@" + "gmail.com?Subject=Question Regarding ExtraCredit.Info'>"
        + "Dr. Kerri" + " " +  "Milita" + "</a>";
  </script>  --}}
</html>
