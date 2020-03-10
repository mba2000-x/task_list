<?php

##
##  ШАБЛОН СПИСКА ЗАДАЧ
##  #########################

$lh = '';
$lc = '';
if (isset($_COOKIE['user']) && $_COOKIE['user'] == 'admin'){
    $lh = '<td>Действия</td>';
    $lc = '<td><a href="#" class="edit">Изменить</a></td>';
}
?>

<table class="grid">
<thead<?php echo $th_sort; ?>>
<tr>
    <td data-name="user_name" class="sortable"<?php echo $sc['un']; ?>>Пользователь</td>
    <td data-name="email"     class="sortable"<?php echo $sc['em']; ?>>E-Mail</td>
    <td data-name="body">Задача</td>
    <td data-name="status"    class="sortable"<?php echo $sc['st']; ?>>Статус</td><?php echo $lh; ?>
</tr>
</thead>
<tbody>

<?php   foreach($list as $item):    ?>

<tr data-id="<?php
    echo $item->id; ?>" data-complete="<?php
    echo $item->complete; ?>"><td><?php
    echo $item->user_name; ?></td><td><?php
    echo $item->email; ?></td><td><?php
    echo $item->body; ?></td><td><?php
    echo $item->status; ?></td><?php
    echo $lc; ?></tr>

<?php   endforeach; ?>

</tbody>
</table>
