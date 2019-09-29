<?
/**
 * $page
 * $pageFirsrt
 * $pageLast
 */
?>

<nav aria-label="Page navigation">
	<ul class="pagination">
		<li>
			<? if( $page > 1 ): ?>
				<? $p = $page - 1; ?>
				<a href="?<?= "page={$p}" ?>" aria-label="Previous">
					<span aria-hidden="true">&laquo;</span>
				</a>
			<? else: ?>
				<span aria-label="Previous">
					<span aria-hidden="true">&laquo;</span>
				</span>
			<? endif ?>
		</li>
		<? for( $p = $pageFirst; $p <= $pageLast; $p++ ): ?>
			<li>
				<? if( $page === $p ): ?>
				<span><strong><?= $p ?></strong></span>
				<? else: ?>
				<a href="?<?= "page={$p}" ?>"><?= $p ?></a>
				<? endif ?>
			</li>
		<? endfor ?>
		<li>
			<? if( $page < $pageLast ): ?>
				<? $p = $page + 1; ?>
				<a href="?<?= "page={$p}" ?>" aria-label="Next">
					<span aria-hidden="true">&raquo;</span>
				</a>
			<? else: ?>
				<span aria-label="Next">
					<span aria-hidden="true">&raquo;</span>
				</span>
			<? endif ?>
		</li>
	</ul>
</nav>
