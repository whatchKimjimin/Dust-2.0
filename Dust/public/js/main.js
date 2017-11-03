var MainApps = function(){
    'use strict';

    var app = {
        initTag: function(){
            app.DUST_TABLE = $('tbody');

            return this;
        },
        initEvent: function(){


            return this;
        },
        start: function(){


            return this
                .initTag()
                .initEvent()
                .SvgMapSetting();
        },
        SvgMapSetting: function(){
            const TableDatas = app.DUST_TABLE.find('tr');

           for(var i = 1; i < TableDatas.length ; i++){
               var data = TableDatas.eq(i).find('td');
               var location = data.eq(0).html();
               var color = TableDatas.eq(i).attr('class');

               $('#korea_map > #layer_1 path[shortname='+location+']').attr('data-color',color);

           }
        }
    }


    return app;
}