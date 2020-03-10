<?php

##  ##############
##  БАЗОВЫЙ КЛАСС МОДЕЛИ
##  #############

##  require_once 'modules/Task/Model.php';

class UserController extends MVC_Controller{

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
        $result =   '';
        return  $result;
    }

    public  function action_Form_auth(){
        ##  вывод окна авторизации

        $view   =   new MVC_View();
        $result =   $view->render('modules/User/template-form-auth.php');

        return  $result;
    }

    public  function action_Login(){
        ##  авторизация пользователя
        $auth           =   isset($_REQUEST['auth']) ? $_REQUEST['auth'] : [];
        $success        =   !empty($auth) && ($auth['username'] === 'admin') && ($auth['password'] === '123');
        $result         =   [];
        if ($success){
            $result['result' ]  = 'Success';
            setcookie('user', 'admin', time() + 3600);
        }
        else{
            $result['result' ]  =   'Error';
            $result['message']  =   empty($auth['username']) ? 'Username cannot be a empty' : 'Invalid authentication data';
        }

        return  json_encode($result);
    }

    public  function action_Logout(){
        ##  выход пользователя
        $result['result' ]  = 'Success';
        setcookie('user', '', time() - 3600);

        return  json_encode($result);
    }

}
