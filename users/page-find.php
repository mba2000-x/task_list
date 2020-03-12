<!doctype html>
<html>
<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
    <link rel="stylesheet" type="text/css" href="/assets/style.css" />
    <script src="/assets/jquery.js"></script>
    <script src="/assets/main.js"></script>
    <title>Поиск клиентов</title>
</head>
<body>

<?php
//    $item = isset($this->params['user_item']) ? $this->params['user_item'] : NULL;
?>

<form action="/user/list" class="item">
    <input name="id" type="hidden" value="<?php echo (isset($item) ? $item->id : ''); ?>">
    <table>
        <tbody>
            <tr><td>Фамилия:</td>   <td><input name="name_l" value="" /></td></tr>
            <tr><td>Имя:</td>       <td><input name="name_f" value="" /></td></tr>
            <tr><td>Телефон:</td>   <td><input name="phone"  value="" /></td></tr>
            <tr><td>E-Mail:</td>    <td><input name="email"  value="" /></td></tr>
        </tbody>
    </table>
    <div style="padding: 10px 0 0 0; text-align: right;">
        <button name="button-accept" type="submit">Поиск</button>
     <!--button name="button-cancel" type="button">Отменить</button-->
    </div>
</form>

</body>
</html>
