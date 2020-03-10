<?php

##                                                                 ####
##  КЛАСС МОДЕЛИ ДАННЫХ ЗАДАЧИ                                     ####
##                                                                  ####

class TaskModel extends MVC_Model{

    public  function __construct($db){
        ##  конструктор
        parent::__construct($db);

        $this->_table   =   'task_list';
        $this->_fields  =   [
            'id'        =>  ['type' => 'int', ],
            'user_name' =>  ['type' => 'string', 'size' => 80, ],
            'email'     =>  ['type' => 'string', 'size' => 64, ],
            'body'      =>  ['type' => 'text', ],
            'status'    =>  ['type' => 'string', 'size' => 32, ],
            'complete'  =>  ['type' => 'int', 'default' => 0, 'required' => true, ],
        ];
    }

    public  function __destruct(){
        ##  деструктор
        parent::__destruct();
    }

}
