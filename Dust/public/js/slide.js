var SlideApps = function() {
    'use strict';

    var app = {
        DATA: {
            SLIDEACTION:                    false, // 미세먼지 데이터 가져올수있는지 여부
            startDate:                      null, // 시작날짜
            endDate:                        null, // 끝날짜
            DustData:                       [], // 미세먼지 데이터
            slideSpeed:                     500, // 슬라이드 속도
            slideInterval:                  null, // 슬라이드 인터벌
            slideDayCount:                  0, // 현재 슬라이드 날짜 카운트
            slideHourCount:                 0, // 현재 슬라이드 시간 카운트
            slideMaxHourCount:              0, // 슬라이드 마지막 카운트
            slideCondition:                 0, // 슬라이드 상태
            slideProgressBarWidth:          0, // 현재 슬라이드진행바 길이
            slideProgressPlusWidth:         0, // 슬라이드 진행시 진행바가 늘어날 길이
        },
        initTag: function() {
            app.BODY                        = $(document);

            app.DATE_FORM                   = $("#datePick");
            app.KOREASVG                    = $("#korea_map");
            app.SLIDECONTROL                = $("#slideBar");


            return this;
        },
        initEvent: function() {

            // 날짜 선택 INPUT 변경시 이벤트
            app.DATE_FORM.find('input').on('change',function(){

                // 이벤트된 INPUT 반대 데이터 확인
                var sideInput =  $(this).parent().siblings().find('input').val();

                // 양쪽의 데이터가 모두 들어가있는지 확인
                if(sideInput !== "" && $(this).val() !== "") {

                    app.slideDateForm(true);
                } else {
                    app.slideDateForm(false)
                }
            })

            // 버튼 클릭시 미세먼지 데이터 가져옴
            app.DATE_FORM.find('button').on('click',app.getDustData);

            // 정지버튼
            app.SLIDECONTROL.find('#slideStopBtn').on('click',app.stopSlide);
            // 재생버튼
            app.SLIDECONTROL.find('#slidePlayBtn').on('click',app.startSlide);
            // 처음버튼
            app.SLIDECONTROL.find('#slideRestartBtn').on('click',app.restartSlide);
            return this;
        },
        start: function() {



            return this
                .initTag()
                .initEvent();
        },
        //  폼 INPUT 이벤트
        slideDateForm: function(data){
            // 시작일이 끝일보다 빠르면 안됨
            if( app.DATE_FORM.find('input').eq(0).val() > app.DATE_FORM.find('input').eq(1).val() ) data = false;
            if( data === true ){
                app.DATA.SLIDEACTION = true;
                app.DATE_FORM.find('button').removeAttr('disabled');
            } else {
                app.DATE_FORM.find('button').attr('disabled','disabled');
                app.DATA.SLIDEACTION = false;
            }
        },
        // 미세먼지 데이터 받아오는 함수
        getDustData: function(){
            // 데이터를 가져오는데 문제가 없으면 실행 있으면 안실행
            if( !app.DATA.SLIDEACTION ) return;
            // 이미 슬라이드가 실행중이면 한번 물어본다
            if( app.DATA.DustData.length > 0){
                if( !confirm('실행중인 슬라이드를 취소하시겠습니까?')) return;
            }
            // 시작일
            app.DATA.startDate = app.DATE_FORM.find('input').eq(0).val();
            // 끝일
            app.DATA.endDate = app.DATE_FORM.find('input').eq(1).val();


            // 미세먼지 데이터 요청
            var dustDataAjax = $.get('/api/getSlideData?startDate='+app.DATA.startDate+'&endDate='+app.DATA.endDate,function(data){
                // 미세먼지 데이터 초기화
                app.DATA.DustData = [];
                // 데이터 2번 못가져오게 막음
                app.DATA.SLIDEACTION = false;
                // 슬라이드 마지막 카운트
                app.DATA.slideMaxHourCount = data.length;
                // 슬라이드 진행바 늘어나는 길이
                app.DATA.slideProgressPlusWidth = 100 / ( data.length * 23 );
                // console.log(app.DATA.DustData , data.length);
                console.log(data);

                // json텍스트를 오브젝트로 바꿈
                for(var i = 0 ; i < data.length ; i++){
                    app.DATA.DustData[i] = data[i];
                    app.DATA.DustData[i].value = JSON.parse(data[i].value);
                }

            });

            // 비동기 슬라이드 세팅
            $.when(dustDataAjax).done(function(){
                app.slideSetting();
                console.log('setting');
            })
        },
        // 슬라이드 세팅
        slideSetting: function(){
            // 슬라이드 기본 데이터 초기화
            app.DATA.slideDayCount = 0;
            // 슬라이드 기본 데이터 초기화
            app.DATA.slideHourCount = 0;
            // 슬라이드 진행바 길이 초기화
            app.SLIDECONTROL.find('#slideProgressBar').css({'width':'0'});
            // 슬라이드 진행바 길이 변수 초기화
            app.DATA.slideProgressBarWidth = 0;
            // 슬라이드 제어버튼 활성화
            app.SLIDECONTROL.find('button').removeAttr('disabled');
            // 인터벌 초기화
            clearInterval(app.DATA.slideInterval);
            // 슬라이드 상태 초기화
            app.DATA.slideCondition = 0;
            // 슬라이드 시작
            app.startSlide();
        },
        // 슬라이드 시작 함수
        startSlide: function(){

            // 슬라이드 실행중이면 중복실행 막음
            if( app.DATA.slideCondition !== 0 ) return false;
            // 슬라이드 진행중으로 변경
            app.DATA.slideCondition = 1;

            // 인터벌 시작
            app.DATA.slideInterval = setInterval(function(){
                // 현재 날짜 배열 위치
                var nowDay = app.DATA.slideDayCount;
                // 현재 시간 배열 위치
                var nowHour = app.DATA.slideHourCount;
                // 현재 슬라이드 데이터
                var data = app.DATA.DustData[nowDay].value[nowHour][nowHour + 1];
                // 진행바 길이 늘리기
                app.DATA.slideProgressBarWidth += app.DATA.slideProgressPlusWidth;
                // 진행바 길이 늘리는 애니메이트
                app.SLIDECONTROL.find('#slideProgressBar').css({'width' : app.DATA.slideProgressBarWidth+'%'});
                console.log(app.DATA.slideProgressBarWidth);
                for(var i =  0; i < data.length ; i++ ) {
                    // 지역명
                    var location = data[i].name;
                    // 지역 색깔
                    var fillColor = data[i].grade;
                    // 스타일 적용
                    app.KOREASVG.find('#layer_1 > path[shortname='+location+']').css({'fill':fillColor});
                }
                console.log('start');
                // 다음시간대로 이동
                app.DATA.slideHourCount++;
                // 24시간 지나면 다음날로 바꿔줌
                if (nowHour === 22){
                    console.log(nowHour , nowDay , app.DATA.slideMaxHourCount);
                    if( nowDay === app.DATA.slideMaxHourCount-1 ) clearInterval( app.DATA.slideInterval );
                    // 슬라이드 데이터 시작값으로
                    app.DATA.slideHourCount = 0;
                    app.DATA.slideDayCount++;
                }

            },app.DATA.slideSpeed);
        },
        stopSlide: function(){
            // 슬라이드 멈춤으로 변경
            app.DATA.slideCondition = 0;
            clearInterval( app.DATA.slideInterval );
        },
        restartSlide: function(){
            // 슬라이드 멈춤
            clearInterval( app.DATA.slideInterval );
            // 슬라이드 상태 멈춤으로
            app.DATA.slideCondition = 0;
            // 현재 슬라이드 시간 초기화
            app.DATA.slideHourCount = 0;
            // 현재 슬라이드 날짜 초기화
            app.DATA.slideDayCount = 0;
            // 현재 슬라이드 진행바 초기화
            app.SLIDECONTROL.find("#slideProgressBar").css({'width':'0'});
            // 현재 슬라이드 진행바 변수 초기화
            app.DATA.slideProgressBarWidth = 0;

            app.startSlide();
        }

    };


    return app;
}