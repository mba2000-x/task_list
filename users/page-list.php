<!doctype html>
<html>
<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
    <link rel="stylesheet" type="text/css" href="/assets/style.css">
    <script src="/assets/jquery.js"></script>
    <script src="/assets/main.js"></script>
    <title>Список клиентов</title>
</head>
<body>

<div>
    <a class="push-insert" href="/user/form">Создать</a>
    <a class="push-filter" href="/user/find">Поиск</a>
    <span class="push-drop">
        <span>Выгрузка</span>
        <span>
            <a class="push-export" href="/user/export/xls">Excel</a>
            <a class="push-export" href="/user/export/csv">CSV</a>
        </span>
    </span>
</div>

<br />

<div class="list">
<?php
    if (isset($this->params['user_list'])){
        $list = $this->params['user_list'];
?>
    <table border="0" cellpadding="0" cellspacing="0">
        <thead><tr><td>Фамилия</td><td>Имя</td><td>Телефон</td><td>E-Mail</td><td></td></tr></thead>
        <tbody>
<?php
        foreach ($list as $kv){
            echo '        <tr><td>'.$kv->name_l.'</td><td>'.$kv->name_f.'</td><td>'.$kv->phone.'</td><td>'.$kv->email.'</td>'.
                 '<td><a class="push-modify" href="/user/form?id='.$kv->id.'">Изменить</a><a class="push-remove" href="/user/drop?id='.$kv->id.'">Удалить</a></td></tr>'.PHP_EOL;
        }
?>
        </tbody>
    </table>
<?php
    }
?>

    <!--  filter area  -->
    <div class="filter" style="display: none;">
        <table>
            <tbody>
                <tr><td>Фамилия:</td>   <td><input name="name_l" value="<?php echo (isset($item->name_l) ? $item->name_l : ''); ?>" /></td></tr>
                <tr><td>Имя:</td>       <td><input name="name_f" value="<?php echo (isset($item->name_f) ? $item->name_f : ''); ?>" /></td></tr>
                <tr><td>Телефон:</td>   <td><input name="phone"  value="<?php echo (isset($item->phone ) ? $item->phone  : ''); ?>" /></td></tr>
                <tr><td>E-Mail:</td>    <td><input name="email"  value="<?php echo (isset($item->email ) ? $item->email  : ''); ?>" /></td></tr>
            </tbody>
        </table>
        <div style="padding: 10px 0 0 0; text-align: right;">
            <button name="button-filter" type="button">Фильтровать</button>
            <button name="button-cancel" type="button">Сбросить</button>
        </div>
    </div>
</div>

</body>
</html>