<html>
    <head>
        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" rel="stylesheet">
        <title>How to check ram and cpu in laravel</title>
    </head>
<body>
    <div class="col-md-3">
        <h2 class="no-margin text-semibold">RAM Usage(Current)</h2>
        <div class="progress progress-micro mb-10">
            <div class="progress-bar bg-indigo-400" style="width:{{$memory}}">
                <span class="sr-only">{{$memory}}</span>
            </div>
        </div>
        <span class="pull-right">{{$used_memory_in_gb}} / {{$total_ram}} ({{$memory}})</span>
    </div>
    <div class="col-md-3">
        <h2 class="no-margin text-semibold">CPU Usage(Current)</h2>
        <div class="progress progress-micro mb-10">
            <div class="progress-bar bg-indigo-400" style="width:{{$load_width}}">
                <span class="sr-only">{{$load}}</span>
            </div>
        </div>
        <span class="pull-right">{{$load}}</span>
    </div>
</body>
</html>