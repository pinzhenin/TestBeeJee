<?
$user = $data;
$errors = isset( $user ) ? $user->getErrors() : NULL;
?>

<div class="row">
	<div class="col-xs-6">
		<strong>
			Вход
		</strong>
	</div>
	<div class="col-xs-6 text-right">
		<a href="/task/list">к списку задач</a>
	</div>
</div>
<hr>
<form method="post" action="/user/login" class="form-horizontal">
<? if( isset( $errors['auth'] ) ): ?>
	<div class="form-group has-error">
		<label for="login" class="col-sm-2 control-label"></label>
		<div class="col-sm-9 text-danger">
			<?= $errors['auth'] ?>
		</div>
	</div>
<? endif ?>
	<div class="form-group <?= isset( $errors['login'] ) ? 'has-error' : '' ?>">
		<label for="login" class="col-sm-2 control-label">Логин</label>
		<div class="col-sm-9">
			<input type="text" name="user[login]" class="form-control" id="login"
				placeholder="логин"
				value="<?= isset( $user ) ? htmlspecialchars( $user->login ) : NULL ?>">
<? if( isset( $errors['login'] ) ): ?>
		<div class="text-danger small">
			<?= $errors['login'] ?>
		</div>
<? endif ?>
		</div>
	</div>
	<div class="form-group <?= isset( $errors['password'] ) ? 'has-error' : '' ?>">
		<label for="password" class="col-sm-2 control-label">Пароль</label>
		<div class="col-sm-9">
			<input type="password" name="user[password]" class="form-control" id="password"
				placeholder="пароль"
				value="<?= isset( $user ) ? htmlspecialchars( $user->password ) : NULL ?>">
<? if( isset( $errors['password'] ) ): ?>
			<div class="text-danger small">
				<?= $errors['password'] ?>
			</div>
<? endif ?>
		</div>
	</div>
	<div class="form-group">
		<div class="col-sm-offset-2 col-sm-8">
			<button type="submit" class="btn btn-default btn-block btn-info btn-outline">
				войти
			</button>
		</div>
	</div>
</form>
<hr>
