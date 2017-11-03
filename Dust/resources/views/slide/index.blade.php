@extends('master')

@push('css')
    <link rel="stylesheet" href="./css/slide.css">
@endpush
@push('js')
    <script src="./js/slide.js"></script>
    <script>
    window.onload = function(){
        $('[data-toggle="tooltip"]').tooltip();
        var app = SlideApps();
        app.start();
    }
    </script>
@endpush
@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">
            <b>Dust Slide</b>
        </div>
        <div class="panel-body">
            <div class="row">

                <div class="col-md-4">
                    <?=file_get_contents('./images/Map/korea.svg')?>
                </div>
                <div class="col-md-7 pull-right" id="slideDateSection">

                    <div class="row">
                        <div class="col-md-12">
                            <form id="datePick">
                                <div class="col-md-10 form-group">
                                    <label for="startDate">시작일:</label>
                                    <input type="date" class="form-control" id="startDate" max="{{ $date }}" min="2017-07-01">
                                </div>

                                <div class="col-md-10 form-group">
                                    <label for="endDate">끝나는일:</label>
                                    <input type="date" class="form-control" id="endDate" max="{{ $date }}" >
                                </div>
                                <button type="button" class="col-md-2 btn btn-default" disabled="disabled">시작</button>

                            </form>
                        </div>
                    </div>


                </div>
                <div class="col-md-7 pull-right" id="slideBar">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="progress">
                                <div class="progress-bar" role="progressbar" aria-valuenow="70"
                                     aria-valuemin="0" aria-valuemax="100" style="width:0" id="slideProgressBar">
                                    <span class="sr-only">70% Complete</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col col-md-1 text-center">
                            <button class="btn btn-default" id="slidePlayBtn" data-toggle="tooltip" data-placement="bottom" title="시작" disabled="disabled">
                                <span class="glyphicon glyphicon-play" aria-hidden="true"></span>
                            </button>
                        </div>
                        <div class="col col-md-1 text-center">
                            <button class="btn btn-default" id="slideStopBtn" data-toggle="tooltip" data-placement="bottom" title="멈춤" disabled="disabled">
                                <span class="glyphicon glyphicon-pause" aria-hidden="true"></span>
                            </button>
                        </div>
                        <div class="col col-md-1 text-center">
                            <button class="btn btn-default" id="slideRestartBtn" data-toggle="tooltip" data-placement="bottom" title="처음" disabled="disabled">
                                <span class="glyphicon glyphicon-stop" aria-hidden="true"></span>
                            </button>
                        </div>
                        {{--<div class="col col-md-1 text-center">--}}
                            {{--<h4>--}}
                                {{--<span class="label label-default">2:33</span>--}}
                            {{--</h4>--}}
                        {{--</div>--}}
                    </div>
                </div>
            </div>

        </div>
    </div>

@endsection