<?php

##  ##########################
##  БАЗОВЫЙ КЛАСС МОДЕЛИ
##  ##########################

class MVC_Model{

    protected $_table       =   '';
    protected $_fields      =   [];
    protected $_db          =   NULL;
    protected $_order       =   '';


    public  function __construct($db){
        ##  конструктор
        $this->_db  = $db;
    }

    public  function __destruct(){
        ##  деструктор
    }

    public  function __get($name){
        ##  возвращает значение атрибута по его наименованию
        $result =   NULL;
        if (isset($this->_fields[$name]) && isset($this->_fields[$name]['value'])){
            $result =   $this->_fields[$name]['value'];
        }   else
        if (isset($this->$name)){
            $result =   $this->$name;
        }
        return  $result;
    }

    public  function __set($name, $value){
        ##  устанавливает значение атрибута по его наименованию
        if (isset($this->_fields[$name])){
            $this->_fields[$name]['value']  = $value;
        }   else
        if (isset($this->$name)){
            $this->$name    = $value;
        }
    }


    public  function checkMembers(array &$result){
        ##  выполняет проверку наличия необходимых свойств
        $result = [];
        if (!$this->_db){
            $result['result' ] = 'Error';
            $result['message'] = 'Database reference is not defined!';
        }
        if ($this->_table === ''){
            $result['result' ] = 'Error';
            $result['message'] = 'Table name is not defined!';
        }
        return empty($result);
    }

    public  function getCount(){
        ##  возвращает количество элементов
        $result = [];
        if (!$this->checkMembers($result)){
            return  0;
        }

        $result = 0;
        $query = "select count(*) `amount` from `{$this->_table}` where `deleted` = 0";
        if (($stmt = mysqli_query($this->_db, $query)) !== NULL && ($item = mysqli_fetch_object($stmt))){
            $result = $item->amount;
            mysqli_free_result($stmt);
        }
        return  $result;
    }

    public  function getList($sort_name = '', $sort_dir = '', $page = 1){
        ##  возвращает список элементов
        $result = [];
        if (!$this->checkMembers($result)){
            return  $result;
        }

        $order      = '';
        if (!empty($sort_name)){
            $order  = "ORDER BY `{$sort_name}` {$sort_dir}".(!empty($this->_order) ? $this->_order : '');
        }
        $offset = ($page - 1) * 3;
        $query = "
    SELECT `t`.*
      FROM `{$this->_table}` `t`
     WHERE `t`.`deleted` = 0
    {$order}
     LIMIT 3 OFFSET {$offset}";
##      file_put_contents("{$this->_table}_select-". date('Ymd-His').".sql", $query);
        $stmt = mysqli_query($this->_db, $query);
        if ($stmt){
            while($item = mysqli_fetch_object($stmt)){
                $result[] = $item;
            }
            mysqli_free_result($stmt);
        }

        return  $result;
    }

    public  function retrieve($id){
        ##  загружает атрибуты задачи с заданным идентификатором
        $result = [];
        if (!$this->checkMembers($result)){
            return  $result;
        }

        $query = "select * from `{$this->_table}` where `id` = {$id}";
        $stmt = mysqli_query($this->_db, $query);
        if ($stmt && (($item = mysqli_fetch_object($stmt)) !== NULL)){
            foreach ($this->_fields as $f => $p){
                if (isset($item->$f)){
                    $this->$f = $item->$f;
                }
            }
            mysqli_free_result($stmt);
        }

        return  $result;
    }

    public  function save(){
        ##  сохранение данных объекта
        $result = [];
        if (!$this->checkMembers($result)){
            return  $result;
        }

        $get_value  = function($f, $p){
            try{
                $v  = $this->$f;
                if ($v === NULL){
                    if (isset($p['required']) && ($p['required'] === true) && isset($p['default'])){
                        $v  = $p['default'];
                    }
                    else{
                        $v  = 'NULL';
                    }
                }
                else{
                    if (isset($p['type'])){
                        if (in_array($p['type'], ['string', 'text', ])){
                            $v  = str_replace(["'", '"', '<', '>'], ["\'", '&quot;', '&lt;', '&gt;'], $v);
                            $v  = "'{$v}'";
                        }
                    }
                }
            }
            catch(Exception $e){
                $v  = 'NULL';
            }
            return $v;
        };

        $id = $this->id;
        if (!empty($id)){     ##  @TODO: implement $keyfield member instead explicit field `id`
            ##  update
            $query = '';
            $kv = '';
            foreach ($this->_fields as $f => $p){
                $v = $get_value($f, $p);
                if ($f == 'id'){
                    $kv = $v;
                    continue;
                }
                else{
                    $query .= ($query === '' ? '  ' : ', ')."`{$f}` = {$v}".PHP_EOL;
                }
            }
            $query = "update `{$this->_table}` set ".PHP_EOL.$query.PHP_EOL." where `id` = {$kv}";
            try{
                mysqli_query($this->_db, $query);
                $result['result' ] = 'Success';
                $result['action' ] = 'update';
            }
            catch(Exception $e){
                $result['result' ] = 'Error';
                $result['Message'] = $e->getMessage();
            }
            if (($m = mysqli_error($this->_db)) !== ''){
                $result['result' ] = 'Error';
                $result['Message'] = $m;
            }
        }
        else{
            ##  insert
            $lf = '';
            $lv = '';
            foreach ($this->_fields as $f => $p){
                if ($f == 'id'){
                    continue;
                }
                $v  = $get_value($f, $p);
                $lf .= ($lf === '' ? '  ' : ', ')."`{$f}`";
                $lv .= ($lv === '' ? '  ' : ', ')."{$v}";
            }
            $query = "insert into `{$this->_table}` ({$lf}) values ({$lv})";
            try{
                mysqli_query($this->_db, $query);
                $result['result' ] = 'Success';
                $result['action' ] = 'insert';
            }
            catch(Exception $e){
                $result['result' ] = 'Error';
                $result['Message'] = $e->getMessage();
            }
            if (($m = mysqli_error($this->_db)) !== ''){
                $result['result' ] = 'Error';
                $result['Message'] = $m;
            }

            $st = mysqli_query($this->_db, "select LAST_INSERT_ID() `id`;");
            if (($item = mysqli_fetch_object($st)) !== NULL){
                $this->id = $item->id;
                mysqli_free_result($st);
            }
        }
        return  $result;
    }

    public  function toArray(){
        ##  возвращает значения атрибутов в виде ассоциированного массива
        $result = [];
        foreach($this->_fields as $f => $p){
            $result[$f] = $this->$f;
        }
        return  $result;
    }

}
