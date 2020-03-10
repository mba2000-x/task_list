<?php
##
##  ШАБЛОН ОСНОВНОЙ СТРАНИЦЫ СИСТЕМЫ
##  #####
?><!doctype html>
<html>

<head>
    <meta charset="utf-8" />
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <meta http-equiv="content-language" content="ru" />

    <link rel="stylesheet" type="text/css" href="/assets/main.css" charset="UTF-8" />
    <link rel="shortcut icon" href="/favicon.ico" />

    <script src="/assets/jquery-3.4.1.js"></script>
    <script src="/assets/main.js"></script>

    <title><?php echo $title; ?></title>
</head>

<body data-user-name="<?php echo $user_name; ?>">
    <div class="tool-band"><button id="task-create">Создать задачу</button><span class="area_user"><?php echo $area_user; ?></span></div>
    <hr />
    <div class="area-body">
<?php echo $body; ?>
    </div>
    <div class="area-back" style="display: none;"></div>
    <div class="area-info" style="display: none;"></div>
</body>

</html>
