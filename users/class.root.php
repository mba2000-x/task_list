<?php   ##                                  ####

##
##  КЛАСС ОБРАБОТЧИКА HTML-ЗАПРОСОВ
##

class Site{

    private $DB;
    private $db_host = 'localhost';
    private $db_user = 'root';
    private $db_pass = 'noname';
    private $db_name = 'tasklist';

    public function __construct(){
        $this->DB = mysqli_connect($this->db_host, $this->db_user, $this->db_pass, $this->db_name);
    }

    public function __destruct(){
        mysqli_close($this->DB);
    }


    static function Exec(){
        $site = new Site();
        $site->procQuery();
    }


    private function actionPage404(){
        //  Вывод сообщения "Ошибка 404"
        $this->render('page-404.php');
    }

    private function actionUserDrop(){
        //  удаление клиента - установка признака активности в 0
        $id = $this->getParam('id');
        if (!$this->checkID($id)){
            die('Invalid parameter value');
        }

        mysqli_query($this->DB, 'update client set active = 0 where id = '.$id);
        header('Location: /user/list');
    }

    private function actionUserExport($format){
        //  экспорт данных
        $s = '';
        $ct = '';
        $ul = $this->UserListSelect();
        if ($format === 'csv'){
            $ct = 'text/csv';
            foreach($ul as $kv){
                $s .= '"'.$kv->name_l.'";"'.$kv->name_f.'";"'.$kv->phone.'";"'.$kv->email.'"'.PHP_EOL;
            }
        }   else
        if ($format === 'xls'){
            $ct = 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet';
            foreach($ul as $kv){
                $s .=
                    '<Row ss:Height="13.00">'.
                        '<Cell><Data ss:Type="String">'.$kv->name_l.'</Data></Cell>'.
                        '<Cell><Data ss:Type="String">'.$kv->name_f.'</Data></Cell>'.
                        '<Cell><Data ss:Type="String">'.$kv->phone.'</Data></Cell>'.
                        '<Cell><Data ss:Type="String">'.$kv->email.'</Data></Cell>'.
                    '</Row>';
            }
            $s =
                '<Workbook xmlns:c="urn:schemas-microsoft-com:office:component:spreadsheet" xmlns:html="http://www.w3.org/TR/REC-html40" '.
                'xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" '.
                'xmlns="urn:schemas-microsoft-com:office:spreadsheet" xmlns:x2="http://schemas.microsoft.com/office/excel/2003/xml" '.
                'xmlns:ss="urn:schemas-microsoft-com:office:spreadsheet" xmlns:x="urn:schemas-microsoft-com:office:excel">'.
                    '<Styles><Style ss:ID="ta1" /></Styles>'.
                    '<ss:Worksheet ss:Name="Лист1">'.
                        '<Table ss:StyleID="ta1">'.
                            '<Column ss:Width="70.00" />'.
                            '<Column ss:Width="70.00" />'.
                            '<Column ss:Width="90.00" />'.
                            '<Column ss:Width="150.00" />'.
                            $s.
                        '</Table>'.
                    '</ss:Worksheet>'.
                    '</Workbook>';
            $format = 'xlsx';
        }   else{
            return;
        }

        $fn = 'Unload-'.date('Y.m.d-H.i.s').'.'.$format;

        header('Content-Type: '.$ct);
        header('Content-Disposition: attachment; filename="'.$fn.'"');
        echo $s;
    }

    private function actionUserFind(){
        //  Вывод окна поиска
        $this->render('page-find.php');
    }

    private function actionUserForm(){
        //  Вывод окна редактора данных клиентов
        $id = $this->getParam('id');
        if (!$this->checkID($id)){
            die('Invalid parameter value');
        }

        $ui = $this->UserItemSelect($id);
        $this->render('page-form.php', array('user_item' => $ui, ));
    }

    private function actionUserList(){
        //  Вывод списка клиентов
        $ul = $this->UserListSelect();
        if ($this->getParam('mode', '') === 'ajax'){
            $s = '';
            foreach($ul as $kv){
                $s .= '        <tr><td>'.$kv->name_l.'</td><td>'.$kv->name_f.'</td><td>'.$kv->phone.'</td><td>'.$kv->email.'</td>'.
                 '<td><a class="push-modify" href="/user/form?id='.$kv->id.'">Изменить</a><a class="push-remove" href="/user/drop?id='.$kv->id.'">Удалить</a></td></tr>'.PHP_EOL;
            }
            echo $s;
        }
        else{
            $this->render('page-list.php', array('user_list' => $ul, ));
        }
    }

    private function actionUserSave(){
        //  сохранение данных
        $qt = '';
        $id = $this->getParam('id');

        if (!$this->checkID($id)){
            die('Invalid parameter value');
        }

        if ($id !== 0){
            $qt = "update client set ".
                    "name_f = '".$this->getParam('name_f', '')."', ".
                    "name_l = '".$this->getParam('name_l', '')."', ".
                    "phone = '" .$this->getParam('phone',  '')."', ".
                    "email = '" .$this->getParam('email',  '')."' where id = ".$id;
        }
        else{
            $qt = "insert into client (name_f, name_l, phone, email) values".
                    "('".$this->getParam('name_f', '')."', '".$this->getParam('name_l', '')."', '".$this->getParam('phone', '')."', '".$this->getParam('email', '')."')";
        }
        mysqli_query($this->DB, $qt);
        $e = mysqli_error($this->DB);
        if (!empty($e)){
            die($e);
        }
        header('Location: /user/list');
    }

    public function getParam($name, $default = NULL){
        //  возвразщает значение параметра с заданным наименованием
        return isset($_REQUEST[$name]) ? $_REQUEST[$name] : $default;
    }

    function procQuery(){
        //  обработка запросов
        $req = strtolower($_SERVER['REQUEST_URI']);
        if (substr($req, 0, 10)  === '/user/drop'){
            $this->actionUserDrop();
        } else
        if ($req === '/' || substr($req, 0, 10) === '/user/list'){
            $this->actionUserList();
        } else
        if (substr($req, 0, 10)  === '/user/find'){
            $this->actionUserFind();
        } else
        if (substr($req, 0, 10)  === '/user/form'){
            $this->actionUserForm();
        } else
        if (substr($req, 0, 10)  === '/user/save'){
            $this->actionUserSave();
        } else
        if (substr($req, 0, 12)  === '/user/export'){
            $this->actionUserExport(substr($req, 13, 3));
        } else{
            $this->actionPage404();
        }
    }

    protected function render($AName, $AParams = NULL){
        //  рендеринг страницы
        $this->params = $AParams;
        require $AName;
        unset($this->params);
    }

    private function UserItemSelect($id){
        //  выборка элемента списка клиентов по идентификатору
        $result = NULL;
        if (($ds = mysqli_query($this->DB, 'select * from client where id = '.$id)) !== FALSE){
            if (($item = mysqli_fetch_object($ds)) !== NULL){
                $result = $item;
            }
            mysqli_free_result($ds);
        }
        return $result;
    }

    private function UserListSelect(){
        //  выборка списка клиентов
        $result = [];
        $name_f = $this->getParam('name_f', '');
        $name_l = $this->getParam('name_l', '');
        $phone  = $this->getParam('phone',  '');
        $email  = $this->getParam('email',  '');

        $sql = "
      select    *
        from    client
       where    active = 1
         and    ((upper('$name_f') = '') or (upper(name_f) like concat('%', upper('$name_f'), '%')))
         and    ((upper('$name_l') = '') or (upper(name_l) like concat('%', upper('$name_l'), '%')))
         and    ((upper('$phone' ) = '') or (upper(phone)  like concat('%', upper('$phone' ), '%')))
         and    ((upper('$email' ) = '') or (upper(email)  like concat('%', upper('$email' ), '%')))
    order by    name_l";
        if (($ds = mysqli_query($this->DB, $sql)) !== FALSE){
            while ($item = mysqli_fetch_object($ds)){
                $result[] = $item;
            }
            mysqli_free_result($ds);
        }
        return $result;
    }

    private function checkID(&$value){
        ##  проверка валидности идентификатора
        $value = (int) $value;
        return $value !== 0;
    }

}
