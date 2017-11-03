<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DustController extends Controller
{
    public function index(Request $request){


        /*

           @ get new date Query
              - SELECT * FROM dustdatas ORDER BY date DESC LIMIT 0,1

           @ Final dustValue Query
              -  SELECT
                 count(id) as 'SiCount' , sum(value) as 'AllValue' , si , sum(value) / count(id) as FinalValue ,
                 case
	             when sum(value) / count(id) >= 151 then "매우 나쁨"
	             when sum(value) / count(id) >= 81 then "나쁨"
	             when sum(value) / count(id) >= 30 then "좋음"
	             else "매우 좋음"
	             end as 'Grade'
                 FROM dustdatas
                 WHERE date = (select date from dustdatas order by date desc limit 0,1)
                 GROUP BY si
           @ Column Information
               SiCount : 행정구역안의 시,도,군 계수
               AllValue : 행정구역안의 시,도,군 미세먼지 합
               FinalValue : 행정구역의 미세먼지 평균
               Grade : 행정구역의 미세먼지 상태
               Name : 행정구역 명
         */


        // DustDatas
        $dustDatas = DB::select('SELECT
                                count(id) as \'SiCount\' , sum(value) as \'AllValue\' , si as \'Name\', FLOOR( sum(value) / count(id) ) as FinalValue , 
                                case 
	                            when sum(value) / count(id) >= 151 then "매우 나쁨"
	                            when sum(value) / count(id) >= 81 then "나쁨"
	                            when sum(value) / count(id) >= 30 then "좋음"
	                            else "매우 좋음" 
	                            end as \'Grade\' , 
	                            case 
	                            when sum(value) / count(id) >= 151 then "red"
	                            when sum(value) / count(id) >= 81 then "orange"
	                            when sum(value) / count(id) >= 30 then "green"
	                            else "blue" 
	                            end as \'Color\'
                                FROM dustdatas 
                                WHERE date = (select date from dustdatas order by date desc limit 0,1)
                                GROUP BY si
                              ');



        return view('dust/index',['dustDatas' => $dustDatas,'date' => date('Y-m-d H:00:00')]);
    }

    public function getLiveDust(Request $request){
        /*

          @ get new date Query
             - SELECT * FROM dustdatas ORDER BY date DESC LIMIT 0,1

          @ Final dustValue Query
             -  SELECT
                count(id) as 'SiCount' , sum(value) as 'AllValue' , si , sum(value) / count(id) as FinalValue ,
                case
                when sum(value) / count(id) >= 151 then "매우 나쁨"
                when sum(value) / count(id) >= 81 then "나쁨"
                when sum(value) / count(id) >= 30 then "좋음"
                else "매우 좋음"
                end as 'Grade'
                FROM dustdatas
                WHERE date = (select date from dustdatas order by date desc limit 0,1)
                GROUP BY si
          @ Column Information
              SiCount : 행정구역안의 시,도,군 계수
              AllValue : 행정구역안의 시,도,군 미세먼지 합
              FinalValue : 행정구역의 미세먼지 평균
              Grade : 행정구역의 미세먼지 상태
              Name : 행정구역 명
        */


        // DustDatas
        $dustDatas = DB::select('SELECT
                                count(id) as \'SiCount\' , sum(value) as \'AllValue\' , si as \'Name\', FLOOR( sum(value) / count(id) ) as FinalValue , 
                                case 
	                            when sum(value) / count(id) >= 151 then "매우 나쁨"
	                            when sum(value) / count(id) >= 81 then "나쁨"
	                            when sum(value) / count(id) >= 30 then "좋음"
	                            else "매우 좋음" 
	                            end as \'Grade\'
                                FROM dustdatas 
                                WHERE date = (select date from dustdatas order by date desc limit 0,1)
                                GROUP BY si
                              ');

        return response()->json($dustDatas);
    }




}
