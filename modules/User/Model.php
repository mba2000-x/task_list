<?php

##  ###################
##  КЛАСС МОДЕЛИ ДАННЫХ ПОЛЬЗОВАТЕЛЯ
##  ##################

class UserModel extends MVC_Model{

    public  function __construct($db){
        ##  конструктор
        parent::__construct($db);

##      $this->_table   =   'task_list';
        $this->_fields  =   [
            'username'  =>  ['type' => 'string', 'size' => 80, ],
        ];
    }

    public  function __destruct(){
        ##  деструктор
        parent::__destruct();
    }


    public  function isAdmin(){
        ##  возвращает признак того, что пользователь -- администратор
        return  $this->username === 'admin';
    }


    public  static function getCurrent(){
        ##  возвращает объект, описывающий текущего пользователя
        $result = new UserModel(NULL);
        if (!empty($_COOKIE['user'])){
            $result->username = $_COOKIE['user'];
        }

        return  $result;
    }

}
