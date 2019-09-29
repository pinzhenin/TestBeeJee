<?
$task = isset( $data['task'] ) ? $data['task'] : NULL;
$errors = $task ? $task->getErrors() : NULL;
$success = isset( $data['success'] ) ? $data['success'] : NULL;
?>

<div class="row">
	<div class="col-xs-6">
		<strong>
<? if( $success ): ?>
			<span class="text-success">
				<span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
				Задача отредактирована
			</span>
<? else: ?>
			Редактирование задачи
<? endif ?>
		</strong>
	</div>
	<div class="col-xs-6 text-right">
		<a href="/task/list">к списку задач</a>
	</div>
</div>
<hr>
<form method="post" action="/task/edit" class="form-horizontal">
	<input type="hidden" name="task[id]" id="id" value="<?= $task->id ?>">
	<input type="hidden" name="task[userName]" value="<?= htmlspecialchars( $task->userName ) ?>">
	<input type="hidden" name="task[userEmail]" value="<?= htmlspecialchars( $task->userEmail ) ?>">
	<div class="form-group">
		<label for="userName" class="col-sm-2 control-label">Имя пользователя</label>
		<div class="col-sm-10">
			<div class="form-control" readonly>
				<?= htmlspecialchars( $task->userName ) ?>
			</div>
		</div>
	</div>
	<div class="form-group">
		<label for="userEmail" class="col-sm-2 control-label">Email</label>
		<div class="col-sm-10">
			<div class="form-control" readonly>
				<?= htmlspecialchars( $task->userEmail ) ?>
			</div>
		</div>
	</div>
	<div class="form-group <?= isset( $errors['taskText'] ) ? 'has-error' : '' ?>">
		<label for="taskText" class="col-sm-2 control-label">Задача</label>
		<div class="col-sm-10">
			<textarea name="task[taskText]" class="form-control" id="taskText"
				<?= $success ? 'disabled' : NULL ?>
				><?= $task ? htmlspecialchars( $task->taskText ) : NULL ?></textarea>
<? if( isset( $errors['taskText'] ) ): ?>
			<div class="text-danger small">Ошибка ввода</div>
<? endif ?>
		</div>
	</div>
	<div class="form-group <?= isset( $errors['taskStatus'] ) ? 'has-error' : '' ?>">
		<label for="taskStatus" class="col-sm-2 control-label">Статус</label>
		<div class="col-sm-10">
			<select class="form-control" name="task[taskStatus]" id="taskStatus"
				<?= $success ? 'disabled' : NULL ?>>
				<option value="активно" <?= $task->taskStatus == 'активно' ? 'selected' : '' ?>>активно</option>
				<option value="выполнено" <?= $task->taskStatus == 'выполнено' ? 'selected' : '' ?>>выполнено</option>
			</select>
<? if( isset( $errors['taskStatus'] ) ): ?>
			<div class="text-danger small">Ошибка ввода</div>
<? endif ?>
		</div>
	</div>
	<div class="form-group">
		<div class="col-sm-offset-2 col-sm-8">
			<button type="submit" class="btn btn-default btn-block btn-info btn-outline"
				<?= $success ? 'disabled' : NULL ?>>
				сохранить изменения
			</button>
		</div>
	</div>
</form>
<hr>
