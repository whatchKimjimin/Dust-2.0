@extends('master')

@push('css')
    <link rel="stylesheet" href="./css/main.css">
@endpush
@push('js')
    <script src="./js/main.js"></script>
    <script>
        window.onload = function(){
            var Main = MainApps();
            Main.start();
        }
    </script>
@endpush


@section('content')
<div class="row" id="mainSection">

    <div class="col-md-6" id="map">

        <?=file_get_contents('./images/Map/korea.svg')?>
    </div>
    <div class="col-md-6" id="dustList">
        <span class="label label-default">최근 관측일 : {{ $date }}</span>

        <table class="table table-hover" id="DustTable">
            <thead>
            <tr>
                <th>관측장소</th>
                <th>상태</th>
                <th>농도</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            <tr class="information">
                <td>좋음: 0 ~ 30</td>
                <td>보통: 30 ~ 80</td>
                <td>나쁨: 81 ~ 150</td>
                <td>매우나쁨: 151 ~</td>
            </tr>
            @foreach( $dustDatas as $data )
                <tr class="{{ $data->Color }}">
                    <td>{{ $data->Name }}</td>
                    <td>{{ $data->FinalValue }}</td>
                    <td>{{ $data->Grade }}</td>
                    <td></td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection