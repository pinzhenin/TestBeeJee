<?
$tasks = $data['tasks'];
$count = $data['count'];
$page = $data['page'];
$sort = $data['sort'];
$pageFirst = 1;
$pageLast = ceil( $count / 3 );

global $app;
$user = $app->user;
?>

<div class="row">
	<div class="col-xs-6">
		<a href="/task/add" class="btn btn-primary">добавить задачу</a>
	</div>
	<div class="col-xs-6 text-right">
<? if( isset( $user ) ): ?>
		<a href="/user/logout" class="btn btn-default">выход</a>
<? else: ?>
		<a href="/user/login" class="btn btn-default">вход администратора</a>
<? endif ?>
	</div>
</div>
<hr>
<div class="row">
	<div class="col-xs-1">
		<strong>
			<a href="?sort=id">#</a>
		</strong>
	</div>
	<div class="col-xs-2">
		<a href="?sort=userName">имя пользователя</a>
	</div>
	<div class="col-xs-2">
		<a href="?sort=userEmail">email</a>
	</div>
	<div class="col-xs-5">
		<a href="?sort=taskText">задача</a>
	</div>
	<div class="col-xs-2">
		<a href="?sort=taskStatus">статус</a>
	</div>
</div>

<? foreach( $tasks as $task ): ?>
	<hr>
	<div class="row">
		<div class="col-xs-1">
			<strong><?= $task->id ?></strong>
		</div>
		<div class="col-xs-2">
			<?= htmlspecialchars( $task->userName ) ?>
		</div>
		<div class="col-xs-2">
			<?= htmlspecialchars( $task->userEmail ) ?>
		</div>
		<div class="col-xs-5">
			<?= htmlspecialchars( $task->taskText ) ?>
			<? if( $task->editedByAdmin ): ?>
				<div class="small text-right">
					<em>отредактировано администратором</em>
				</div>
			<? endif ?>
		</div>
		<div class="col-xs-2">
			<?= $task->taskStatus ?>
		</div>
		<? if( $task->editedByAdmin || $user ): ?>
			<div class="col-xs-12 small">
				<? if( $user ): ?>
					<a href="/task/edit?id=<?= $task->id ?>">редактировать</a>
					<? if( $task->taskStatus === 'активно' ): ?>
						| <a href="/task/done?id=<?= $task->id ?>">выполнено</a>
				<? endif ?>
			<? endif ?>
			</div>
		<? endif ?>
	</div>
<? endforeach ?>
<hr>

<? include( 'widgetPagination.php' ) ?>
