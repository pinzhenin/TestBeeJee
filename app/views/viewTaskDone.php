<div class="row">
	<div class="col-xs-6">
		<strong>
			<? if( $data->getErrors() ): ?>
				Кажется что-то пошло не так…
				<? print_r($data->getErrors()) ?>
			<? else: ?>
				Задача #<?= $data->id ?> выполнена
			<? endif ?>
		</strong>
	</div>
	<div class="col-xs-6 text-right">
		<a href="/task/list">к списку задач</a>
	</div>
</div>
<hr>
