@extends('layouts.app')

@section('content')

    <div class="row">
        <div class="col-md-3 col-md-offset-1">

            @if (Session::has('createsuccess'))
                <div class="alert alert-success">
                    <h4>{{ Session::get('createsuccess') }}</h4>
                </div>
            @endif

            @if (Session::has('createfail'))
                    <div class="alert alert-danger">
                        <h4>{{ Session::get('createfail') }}</h4>
                    </div>
            @endif

            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="section-head">Create New Survey Name Collector</h3>
                </div>
                <div class="panel-body">
                    <div class="form-group">
                        <form method="post" action="/create">
                            <label for="newsurveyname">Survey Name</label>
                            <input value="{{ old('newsurveyname') }}" class='form-control input-sm'
                                   type="text" id="newsurveyname" name="newsurveyname">
                            @if (Session::has('name_error'))
                                <p style="color: red;">{{ Session::get('name_error') }}</p>
                            @endif
                            <br>
                            <label for="newsurveystart">Start Date</label>
                            <input class='form-control input-sm' type="datetime-local" id="newsurveystart" name="newsurveystart">
                            <p><i>Default = Now</i></p>
                            <label for="newsurveyend">End Date</label>
                            <input class='form-control input-sm' type="datetime-local" id="newsurveyend" name="newsurveyend">
                            <p><i>If you leave this blank, it will accept names forever. This can be changed later.</i></p>
                            <input class='btn btn-sm btn-primary' type="submit" value="Create">
                            {{ csrf_field() }}
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            @if (count($surveys) > 0 )
                @foreach($surveys as $survey)
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="section-head">{{ $survey->name }} -
                                Created: {{ date('D - M j, Y g:i a T', strtotime($survey->created_at)) }}</h4>
                        </div>
                        <div class="panel-body">
                            <p>
                                <b>Name Collection URL:</b>
                                <a href="{{url('/', ['survey', $survey->slug])}}">
                                {{url('/', ['survey', $survey->slug])}}
                                </a>
                                <span class="glyphicon glyphicon-copy copyAddressHome" survey="{{ $survey->id }}"></span>
                            </p>
                            <p>
                                <i>(Include this link address at the end of your survey)
                                    <textarea class="hiddenLink" id="hiddenLink-{{$survey->id}}">
                                        {{url('/', ['survey', $survey->slug])}}
                                    </textarea>
                                </i>
                            </p>
                            <hr>
                            @if(is_null($survey->start))
                                <p><b>Open From:</b> {{ date('D - M j, Y g:i a T', strtotime($survey->created_at)) }}</p>
                            @else
                                <p><b>Open From:</b> {{ date('D - M j, Y g:i a T', strtotime($survey->start)) }}</p>
                            @endif

                            @if(is_null($survey->end))
                                <p><b>Open Until:</b> No Closing Date Set</p>
                            @else
                                <p><b>Open Until:</b> {{ date('D - M j, Y g:i a T', strtotime($survey->end)) }}</p>
                            @endif
                            <hr>
                            <div class="row">
                                <div class="col-md-8">
                                    <p><b>Universities Participating:</b> {{ count($survey->universities) }}</p>
                                    <p><b>Instructors Participating:</b> {{ count($survey->instructors) }}</p>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-md-6">
                                    <h4><b>Names Collected:</b> {{ count($survey->participants) }}</h4>
                                </div>
                                <div class="col-md-6">
                                    <div class="btn-toolbar">
                                        <a class="btn btn-primary" href="{{ url('/', ['admin', $survey->id, 'options']) }}">
                                            Set Options
                                        </a>
                                        <a class="btn btn-success" href="{{ url('/', ['admin', $survey->id, 'download']) }}">
                                            Download Names
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <h3 class="section-head">No Surveys To List. Create One!</h3>
            @endif
        </div>
    </div>


@endsection
