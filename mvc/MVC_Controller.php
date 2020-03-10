<?php

##
##  БАЗОВЫЙ КЛАСС КОНТРОЛЛЕРА
##  ###############

class MVC_Controller{

    protected   $_db    =   NULL;       ##  указатель на объект БД


    public  function __construct($db){
        ##  конструктор
        $this->_db = $db;
    }

    public  function __destruct(){
        ##  деструктор
    }

}
