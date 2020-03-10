<?php

##
##  ШАБЛОН РЕДАКТОРА ЗАДАЧИ
##  ####

?>

<div class="task_edit">
<h2>Редактирование задачи</h2>
<input class="edit" type="hidden" name="id" value="" />
<table class="edit">
<tbody>
<tr><td><span class="mark">Пользователь</span></td><!--   --><td><input    class="edit" type="text" maxlength="80" name="user_name" value="<?php echo $item->user_name; ?>" /></td></tr>
<tr><td><span class="mark">E-Mail</span></td><!--         --><td><input    class="edit" type="text" maxlength="64" name="email"     value="<?php echo $item->email;     ?>" /></td></tr>
<tr><td><span class="mark">Задача</span></td><!--         --><td><textarea class="edit" name="body"><?php echo $item->body;         ?></textarea></td></tr>
<tr><td><span class="mark">Выполнено</span></td><!--      --><td><input    class="edit" type="checkbox" name="complete"<?php echo ($item->complete == 1 ? ' checked="true"' : ''); ?> /></td></tr>
<tr><td colspan="2" style="text-align: center;"><button class="edit" id="accept">Сохранить</button><button class="edit" id="cancel">Отмена</button></td></tr>
</tbody>
</table>
</div>
