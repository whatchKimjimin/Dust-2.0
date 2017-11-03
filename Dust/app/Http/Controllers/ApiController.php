<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ApiController extends Controller
{
    public function getSlideData(Request $request){

        // 시작 날짜
        $startDate = $request->input('startDate');
        // 끝날짜
        $endDate = $request->input('endDate');

        /*

        @ 선택된 날짜 미세먼지 데이터 쿼리
           - SELECT
             date , si  , sum(value) as \'AllValue\' , count(id) as \'SiCount\' , sum(value) / count(id) as \'FinalValue\' ,
             case
             when sum(value) / count(id) >= 151 then "매우 나쁨"
             when sum(value) / count(id) >= 81 then "나쁨"
             when sum(value) / count(id) >= 30 then "좋음"
             else "매우 좋음"
             end as \'Grade\'
             FROM dustdatas
             WHERE date BETWEEN { START_DATE } and { END_DATE }
             GROUP BY date,si

        @ Column Information
              SiCount : 행정구역안의 시,도,군 계수
              AllValue : 행정구역안의 시,도,군 미세먼지 합
              FinalValue : 행정구역의 미세먼지 평균
              Grade : 행정구역의 미세먼지 상태
              Name : 행정구역 명
              Date : 미세먼지가 수집된 시간

        @ Variable Information
            $startDate: (Date) 시작 날짜
            $endDate: (Date) 끝 날짜
         * */
        // StartDate Parameter
        $startDate = urldecode($request->input('startDate'));
        // EndDate Parameter
        $endDate = urldecode($request->input('endDate'));


//        $dustDatas = DB::select('SELECT
//                                 date as \'Date\' , si as \'Name\'  , sum(value) as \'AllValue\' , count(id) as \'SiCount\' , sum(value) / count(id) as \'FinalValue\' ,
//                                 case
//	                             when sum(value) / count(id) >= 151 then "매우 나쁨"
//	                             when sum(value) / count(id) >= 81 then "나쁨"
//	                             when sum(value) / count(id) >= 30 then "좋음"
//	                             else "매우 좋음"
//	                             end as \'Grade\'
//                                 FROM dustdatas
//                                 WHERE date BETWEEN ? and ?
//                                 GROUP BY date,si',[$startDate,$endDate]);
        $dustDatas = DB::select('SELECT * FROM dustdays WHERE date BETWEEN ? AND ?',[$startDate , $endDate]);


        return response()->json($dustDatas);
    }
}
