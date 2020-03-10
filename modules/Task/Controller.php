<?php

##
##  БАЗОВЫЙ КЛАСС МОДЕЛИ
##

require_once 'modules/Task/Model.php';
require_once 'modules/User/Model.php';

class TaskController extends MVC_Controller{

    public  function __construct($db){
        ##  конструктор
        parent::__construct($db);

    }

    public  function __destruct(){
        ##  деструктор
        parent::__destruct();
    }


    public  function action_Default(){
        ##  действие по-умолчанию: вывод списка задач
        return  $this->action_List();
    }

    public  function action_Edit(){
        ##  вывод окна редактора
        $item   =   new TaskModel($this->_db);
        $view   =   new MVC_View();
        $result =   $view->render('modules/Task/template-edit.php', ['item' => $item, ]);
        return  $result;
    }

    public  function action_List(){
        ##  вывод списка задач
        require_once 'modules/Task/Model.php';

        $sort_name  = Core::getParam('sort_name', 'id');
        $sort_dir   = Core::getParam('sort_dir',  'asc');
        $page       = (int)Core::getParam('page',      '1');

        $th_sort    = (!empty($sort_name) ? ' data-sort-name="'.$sort_name.'"' : '').(!empty($sort_dir ) ? ' data-sort-dir="' .$sort_dir .'"' : '');
        $sc         = [
            'un'    => $sort_name === 'user_name' ? ' data-sort-dir="' .$sort_dir .'"' : '',
            'em'    => $sort_name === 'email'     ? ' data-sort-dir="' .$sort_dir .'"' : '',
            'st'    => $sort_name === 'status'    ? ' data-sort-dir="' .$sort_dir .'"' : '',
        ];

        $sort_dir   =   strtoupper($sort_dir);
        $tm         =   new TaskModel($this->_db);
        $tm->_order =   ($sort_name === 'status' ? ", `complete` {$sort_dir}" : '');
        $list       =   $tm->getList($sort_name, $sort_dir, $page);
        foreach($list as $item){
            $status         = $item->status;
            $item->status  .= $item->complete === '1' ? (empty($status) ? '' : ', ').'выполнено' : '';
        }

##      $file   =   count($list) > 0 ? 'modules/Task/template-list.php' : 'common/template-not-found.php';
        $file   =   'modules/Task/template-list.php';
        $view   =   new MVC_View();
        $result =   $view->render($file, ['list' => $list, 'th_sort' => $th_sort, 'sc' => $sc, ]).(Core::getParam('mode', '') === 'api' ? '' : $this->pagination($page));
        unset($list);
        return  $result;
    }

    public  function action_Save(){
        ##  сохранение данных
        $result     =   [];
        $task       =   isset($_REQUEST['task']) ? $_REQUEST['task'] : NULL;
        if ($task === NULL){
            $result = ['result' => 'Error', 'message' => 'No data present', ];
        }
        else{
            $ex = '';
            if (!empty($task['id'])){
                $user       = UserModel::getCurrent();
                if (!$user->isAdmin()){
                    $ex = 'Need authorization';
                }
            }

            if (empty($ex)){
                if ($task['user_name'] === ''){
                    $ex .= 'User name cannot be a empty<br />'.PHP_EOL;
                }
                if ($task['email'] === ''){
                    $ex .= 'Email cannot be a empty<br />'.PHP_EOL;
                }   else
                if (!filter_var($task['email'], FILTER_VALIDATE_EMAIL)){
                    $ex .= 'Email is not valid<br />'.PHP_EOL;
                }
                if ($task['body'] === ''){
                    $ex .= 'Task body cannot be a empty<br />'.PHP_EOL;
                }
            }

            if (!empty($ex)){
                $result = ['result' => 'Error', 'message' => $ex, ];
            }
            else{
                $changed            =   false;
                $item               =   new TaskModel($this->_db);
                if (!empty($task['id'])){
                    $item->retrieve($task['id']);
                    $changed        =   $item->body !== $task['body'];
                }
                foreach($task as $key => $val){
                    $item->$key     =   $val;
                }
                if ($changed){
                    $item->status   =   'отредактировано администратором';
                }
                $result             =   $item->save();
                if (isset($result) && ($result['result'] === 'Success')){
                    $item->retrieve($item->id);
                    $status         =   $item->status;
                    $item->status  .=   $item->complete === '1' ? (empty($status) ? '' : ', ').'выполнено' : '';
                    $result['task'] =   $item->toArray();
                }
            }
        }

        return  json_encode($result);
    }

    private function pagination($page){
        //  пагинация
        $result     =   '';
        $tm         =   new TaskModel($this->_db);
        $count      =   $tm->getCount();
//      $pages      =   intdiv($count, 3) + ($count % 3 > 0 ? 1 : 0);
        $pages      =   floor($count / 3) + ($count % 3 > 0 ? 1 : 0);
        if ($pages > 1){
            for($i = 0; $i < $pages; $i++){
                $n = $i + 1;
                $result    .=   '<span'.($n === $page ? ' class="selected"' : '').'>'.$n.'</span>';
            }
        }
        $result     = PHP_EOL.PHP_EOL."        <div class=\"pages\">{$result}</div>".PHP_EOL;

        return  $result;
    }

}

##                                          ####
