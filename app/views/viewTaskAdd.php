<?
$task = empty( $data ) ? NULL : $data;
$errors = $task ? $task->getErrors() : NULL;
$success = isset( $task ) && empty( $errors );
?>

<div class="row">
	<div class="col-xs-6">
		<strong>
<? if( $success ): ?>
			<span class="text-success">
				<span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
				Задача добавлена
			</span>
<? else: ?>
			Добавление новой задачи
<? endif ?>
		</strong>
	</div>
	<div class="col-xs-6 text-right">
		<a href="/task/list">к списку задач</a>
	</div>
</div>
<hr>
<form method="post" action="/task/add" class="form-horizontal">
	<div class="form-group <?= isset( $errors['userName'] ) ? 'has-error' : '' ?>">
		<label for="userName" class="col-sm-2 control-label">Имя пользователя</label>
		<div class="col-sm-10">
			<input type="text" name="task[userName]" class="form-control" id="userName"
				placeholder="имя пользователя"
				value="<?= $task ? htmlspecialchars( $task->userName ) : NULL ?>"
				<?= $success ? 'disabled' : NULL ?>>
<? if( isset( $errors['userName'] ) ): ?>
			<div class="text-danger small">Ошибка ввода</div>
<? endif ?>
		</div>
		<div></div>
	</div>
	<div class="form-group <?= isset( $errors['userEmail'] ) ? 'has-error' : '' ?>">
		<label for="userEmail" class="col-sm-2 control-label">Email</label>
		<div class="col-sm-10">
			<input type="email" name="task[userEmail]" class="form-control" id="userEmail"
				placeholder="email"
				value="<?= $task ? htmlspecialchars( $task->userEmail ) : NULL ?>"
				<?= $success ? 'disabled' : NULL ?>>
<? if( isset( $errors['userEmail'] ) ): ?>
			<div class="text-danger small">Ошибка ввода</div>
<? endif ?>
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
	<div class="form-group">
		<div class="col-sm-offset-2 col-sm-10">
			<button type="submit" class="btn btn-default btn-block btn-info btn-outline"
				<?= $success ? 'disabled' : NULL ?>>
				добавить задачу
			</button>
		</div>
	</div>
</form>
<hr>
