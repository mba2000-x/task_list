//  приложение

$(document).ready(function(){

    if (window.location.href.indexOf('/user/form') > 0){
        $('button[name="button-cancel"]').click(function(){
            window.location.href = '/user/list';
        });
    }

    if (window.location.href.indexOf('/user/list') > 0){

        //  обработка нажатия кнопки "Поиск"
        $('a.push-filter').click(function(){
            $('div.list > table').hide();
            $('div.list > div.filter').show();
            return false;
        });

        //  обработка нажатия кнопки "Фильтровать"
        $('button[name="button-filter"]').click(function(){
            var d1 = {mode: 'ajax'};
            d1.name_f = $('input[name="name_f"]').val();
            d1.name_l = $('input[name="name_l"]').val();
            d1.phone  = $('input[name="phone"]' ).val();
            d1.email  = $('input[name="email"]' ).val();
            $.get('/user/list', d1, function(data, textStatus, jqXHR){
                $('div.list > table > tbody').empty();
                $('div.list > table > tbody').append($(data));
            });
            $('div.list > table').show();
            $('div.list > div.filter').hide();
            return false;
        });

        //  обработка нажатия кнопки "Сбросить"
        $('button[name="button-cancel"]').click(function(){
            window.location.reload();
            return false;
        });

        //  обработка нажатия кнопок "Экспорт"
        $('.push-export').click(function(){
            var $this = $(this), url = $this.attr('href') +
                '?name_f=' + $('input[name="name_f"]').val() +
                '&name_l=' + $('input[name="name_l"]').val() +
                '&phone='  + $('input[name="phone"]' ).val() +
                '&email='  + $('input[name="email"]' ).val();
            window.location.href = url;
            return false;
        });

    }
});

