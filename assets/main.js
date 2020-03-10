//  #########################
//  ФРОНТ-ЭНД ФУНКЦИОНАЛ ####
//  #########################

var core = {

    $form_auth: null        //  окно авторизации
  , $form_edit: null        //  окно редактирования
  , $area_back: null        //  фоновая область модального окна

  , init: function(){
        //  инициализация
        core.$area_back = $('div.area-back');
    }

  , task_edit: function(sender, data = null){
        //  вызов окна редактирования задачи
        if (core.$form_edit === null){
            $.post('/', {module:'task', action: 'edit', mode: 'api'}, function(response){
                core.$form_edit = $(response);
                core.$form_edit.css('display', 'none');
                core.$form_edit.addClass('modal');
                $('body').append(core.$form_edit);
                core.form_show(data);
            });
        }
        else{
            core.form_show(data);
        }
    }

  , form_show: function(data){
        //  отобразить окно
        if (core.$form_edit === null){
            return;
        }

        core.$form_edit.find('.edit').each(function(index, item){
            if (['INPUT', 'TEXTAREA'].indexOf(item.tagName) < 0){
                return;
            }

            var $ctrl = $(item);
            if ($ctrl.prop('type') === 'checkbox'){
                $ctrl.prop('checked', false);
                $ctrl.removeProp('value');
            }
            else{
                $ctrl.val('');
            }
        });
        core.$form_edit.show();
        core.$area_back.show();
        if (data !== null){
            core.$form_edit.find('input[name="id"]'       ).val(data.id);
            core.$form_edit.find('input[name="user_name"]').val(data.user_name);
            core.$form_edit.find('input[name="email"]'    ).val(data.email);
            core.$form_edit.find('textarea[name="body"]'  ).val(data.body);
            core.$form_edit.find('input[name="complete"]' ).prop('checked', data.complete === '1' ? true : false);
            core.$form_edit.find('tr:nth-child(4)').show();
        }
        else{
            core.$form_edit.find('tr:nth-child(4)').hide();
        }
    }

  , form_hide: function(){
        //  скрыть окно
        core.$form_edit.hide();
        core.$area_back.hide();
    }

  , task_edit_accept: function(){
        //  сохранить введённые данные
        var data = {module:'task', action: 'save', mode: 'api',
            task:{
                id        : $('input[name="id"]'       ).val(),
                user_name : $('input[name="user_name"]').val(),
                email     : $('input[name="email"]'    ).val(),
                body      : $('textarea[name="body"]'  ).val(),
                complete  : $('input[name="complete"]' ).prop('checked') === true ? '1' : '0'
            }
        };
        $.post('/', data, function(data){
            data = JSON.parse(data);
            if (data.result){
                var $info = $('div.area-info');
                var info  = '';
                if (data.result === 'Success'){
                    core.form_hide();
                    info  = 'Succefully save';
                    $info.removeClass('error');
                    if (data.task){
                        if (data.action && data.action === 'update'){
                            var s = 'table.grid tr[data-id="' + data.task.id + '"]', $row = $(s);
                            if ($row.length === 1){
                                $row.find('td:nth-child(1)').html(data.task.user_name);
                                $row.find('td:nth-child(2)').html(data.task.email);
                                $row.find('td:nth-child(3)').html(data.task.body);
                                $row.find('td:nth-child(4)').html(data.task.status);
                            }
                        }   else
                        if (data.action && data.action === 'insert'){
/*
                            var $row    =   $('<tr>'), $user = $('body').attr('data-user-name');
                            $row.attr('data-id', data.task.id);
                            $row.append($('<td>').html(data.task.user_name))
                                .append($('<td>').html(data.task.email))
                                .append($('<td>').html(data.task.body))
                                .append($('<td>').html(data.task.status));
                            if ($user === 'admin'){
                                $row.append($('<td>').html('<a href="#" class="edit">Изменить</a>'));
                            }
                            $('table.grid > tbody').append($row);
  */
                            window.location.reload();
                        }
                    }
                }   else

                if (data.result === 'Error' && data.message){
                    info  = data.message;   //  .replace(/\r\n/g, "<br />\r\n");
                    $info.addClass('error');
                }
                $info.html(info);
                $info.show();
                setTimeout(() => $info.fadeOut(500), 5000);
            }
        });
    }

  , task_edit_cancel: function(){
        //  закрыть модальное окно
        core.form_hide();
    }


  , form_auth_exec: function(){
        //  отобразить окно авторизации
        if (core.$form_auth === null){
            $.post('/', {module:'user', action: 'form_auth', mode: 'api'}, function(data){
                core.$form_auth = $(data);
                core.$form_auth.css('display', 'none');
                core.$form_auth.addClass('modal');
                $('body').append(core.$form_auth);
                core.form_auth_show();
            });
        }
        else{
            core.form_auth_show();
        }
    }

  , form_auth_show: function(){
        //  отобразить форму авторизации
        if (core.$form_auth === null){
            return;
        }
        core.$form_auth.find('.edit').each(function(index, item){
            if (item.tagName === 'INPUT'){
                $(item).val('');
            }
        });
        core.$form_auth.show();
        core.$area_back.show();
        core.$form_auth.find('input[name="username"]').focus();
    }

  , form_auth_accept: function(){
        //  форма авторизации: нажать на кнопку войти
        var data = {module: 'user', action: 'login', mode: 'api', auth: {
                username: $('.form_auth input[name="username"]').val(),
                password: $('.form_auth input[name="password"]').val()
        }};
        $.post('/', data, function(response){
            response = JSON.parse(response);
            if (response.result && response.result === 'Error' && response.message){
                var $info = $('div.area-info');
                $info.addClass('error');
                $info.html(response.message);
                $info.show();
                setTimeout(() => $info.fadeOut(500), 5000);
            }
            else{
                window.location.reload();
            }
        });
    }

  , form_auth_cancel: function(){
        //  форма авторизации: нажать на кнопку отмена
        core.$form_auth.hide();
        core.$area_back.hide();
    }

  , user_login: function(){
        //  авторизация пользователя
        core.form_auth_exec();
    }

  , user_logout: function(){
        //  выход пользователя из авторизации
        var data = {module: 'user', action: 'logout', mode: 'api'};
        $.post('/', data, function(response){
            response = JSON.parse(response);
            if (response.result && response.result === 'Success'){
                window.location.reload();
            }
        });
    }

  , form_task_edit_call: function(){
        //  редактирование задач администратором
        var $row = $(this).parent().parent(), data = {
            id          :   $row.attr('data-id'),
            user_name   :   $row.find('td:nth-child(1)').html(),
            email       :   $row.find('td:nth-child(2)').html(),
            body        :   $row.find('td:nth-child(3)').html(),
            complete    :   $row.attr('data-complete')
        };
        core.task_edit(null, data);
        return false;
    }

  , list_sort: function(){
        //  обработка нажатия на заголовок колонки списка задач
        var $cell = $(this);
        if (!$cell.hasClass('sortable')){
            return false;
        }

        var $head = $cell.parent().parent()
          , sort_name = $head.attr('data-sort-name') || 'id'
          , sort_dir  = $head.attr('data-sort-dir' ) || ''
          , head_name = $cell.attr('data-name'     )
          ;

        if (sort_name !== head_name){
            sort_name = head_name;
            sort_dir  = 'asc';
            $('table.grid > thead > tr:nth-child(1) > td[data-sort-dir]').removeAttr('data-sort-dir');
        }
        else{
            switch(sort_dir){
                case 'asc'  : sort_dir  = 'desc'; break;
                case 'desc' : sort_dir  = '';     break;
                default     : sort_dir  = 'asc';  break;
            }
            if (sort_dir === ''){
                sort_name = '';
            }
        }

        if (sort_name === ''){
            $head.removeAttr('data-sort-name');
        }
        else{
            $head.attr('data-sort-name', sort_name);
        }

        if (sort_dir === ''){
            $head.removeAttr('data-sort-dir');
            $cell.removeAttr('data-sort-dir');
        }
        else{
            $head.attr('data-sort-dir', sort_dir);
            $cell.attr('data-sort-dir', sort_dir);
        }

        var page = $('div.pages > span.selected').text().trim();
        var request = {module: 'task', action: 'list', mode: 'api', sort_name: sort_name, sort_dir: sort_dir, page: page};
        $.post('/', request, function(data){
            $('table.grid').html(data);
        });
    }

  , navigate: function(){
        //  постраничная навигация
        var $head = $('table.grid > thead')
          , sort_name   = $head.attr('data-sort-name') || 'id'
          , sort_dir    = $head.attr('data-sort-dir' ) || 'asc'
          , $pages      = $('div.pages')
          , $page_sel   = $(this)
          , page        = $page_sel.text().trim()
          , request     = {module: 'task', action: 'list', mode: 'api', sort_name: sort_name, sort_dir: sort_dir, page: page}
          ;
        $.post('/', request, function(data){
            $('table.grid').html(data);
            $pages.find('span.selected').removeClass('selected');
            $page_sel.addClass('selected');
        });

//        console.log();
    }

};

$(document).ready(core.init);

$(document).on('click', 'button#task-create',           core.task_edit);
$(document).on('click', 'button#login',                 core.user_login);
$(document).on('click', 'button#logout',                core.user_logout);

$(document).on('click', 'button#accept',                core.task_edit_accept);
$(document).on('click', 'button#cancel',                core.task_edit_cancel);

$(document).on('click', 'button#auth-accept',           core.form_auth_accept);
$(document).on('click', 'button#auth-cancel',           core.form_auth_cancel);

$(document).on('click', 'table.grid a.edit',            core.form_task_edit_call);
$(document).on('click', 'table.grid > thead > * > *',   core.list_sort);
$(document).on('click', 'div.pages > span',             core.navigate);
