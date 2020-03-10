<?php
##
##  КЛАСС ЯДРА ПРИЛОЖЕНИЯ
##

require_once 'mvc/MVC_Controller.php';
require_once 'mvc/MVC_View.php';
require_once 'mvc/MVC_Model.php';

class Core extends MVC_Controller{

    private     $_module    =   '';     ##  активный модуль
    private     $_action    =   '';     ##  выполняемое действие
    protected   $_db        =   NULL;
    private     $_db_config =   [
        'mba.zzz.com.ua'    =>  [
            'hostname'  => 'mysql.zzz.com.ua',
            'username'  => 'mba2000',
            'password'  => 'noin_957_deX',
            'dbname'    => 'mba2000',
            'port'      => '3306',
            'socket'    => '',
        ],
        'default'       =>  [
            'hostname'  => 'localhost',     ##  ini_get("mysqli.default_host")
            'username'  => 'root',          ##  ini_get("mysqli.default_user")
            'password'  => 'noname',        ##  ini_get("mysqli.default_pw")
            'dbname'    => 'tasklist',      ##  ""
            'port'      => '3306',          ##  ini_get("mysqli.default_port")
            'socket'    => '',              ##  ini_get("mysqli.default_socket")
        ]
    ];


    public  function __construct($db){
        ##  конструктор
        parent::__construct($db);

        $host           = $_SERVER['SERVER_NAME'];
        $cp             = isset($this->_db_config[$host]) ? $this->_db_config[$host] : $this->_db_config['default'];
        $this->_db      = mysqli_connect($cp['hostname'], $cp['username'], $cp['password'], $cp['dbname'], $cp['port'] /* , $cp['socket'] */);
        if (!$this->_db){
            die('<div>CANNOT CONNECT TO DEFINED DATABASE</div>');
        }

        $this->_module = self::getParam('module', 'Core');
        $this->_action = self::getParam('action', 'Default');
    }

    public  function __destruct(){
        ##  деструктор
        if ($this->_db){
            mysqli_close($this->_db);
        }

        parent::__destruct();
    }


    public  function action_Default(){
        ##  выполнение действия по-умолчанию
        require_once 'modules/Task/Controller.php';
        $tc = new TaskController($this->_db);
        return  $tc->action_List();
    }


    public  static function execute(){
        ##  запуск приложения
        $core   = new Core(NULL);
        $ctrl   = NULL;
        if ($core->_module === 'Core'){
            $ctrl   = $core;
        }
        else{
            $file   = 'modules/'.ucfirst($core->_module).'/Controller.php';
            if (file_exists($file)){
                require_once $file;
                $class  =   ucfirst($core->_module).'Controller';
                if (class_exists($class)){
                    $ctrl   = new $class($core->_db);
                }
            }
        }
        $body   = '';
        if ($ctrl !== NULL){
            $method = 'action_'.$core->_action;
            if (method_exists($ctrl, $method)){
                $body   = $ctrl->$method();
            }
            else{
                $body   = 'UNKNOWN ACTION: '.$core->_action;
            }
        }
        else{
            $body   = 'UNKNOWN MODULE: '.$core->_module;
        }

        $result =   '';
        if (strtolower(Core::getParam('mode', '')) === 'api'){
            $result =   $body;
        }
        else{
            $view   =   new MVC_View();
            $title  =   'Список задач';
            $area_user  = '';
            $user_name  = '';
            if (isset($_COOKIE['user']) && $_COOKIE['user'] === 'admin'){
                $user_name  =   $_COOKIE['user'];
                $area_user  =   '<span>'.$user_name.'</span>&nbsp;<button id="logout">Выход</button>';
            }
            else {
                $area_user  = '<button id="login">Авторизация</button>';
            }
            $result =   $view->render('modules/Core/template-page.php', ['body' => $body, 'title' => $title,
                            'area_user' => $area_user, 'user_name' => $user_name, ]);
        }
        echo $result;
    }

    public  static function getParam($name, $default){
        ##  возвращает значение параметра по его наименованию
        ##  $default    --  значение, возвращаемое по-умолчанию
        $result = isset($_REQUEST[$name]) ? $_REQUEST[$name] : $default;
        return  $result;
    }

}

//                                        ####
