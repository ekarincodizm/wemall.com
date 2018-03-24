<?php
    $firstPage = 1;
    $currentPage = $paginator->getCurrentPage();
    $prevPage = ($currentPage > 1) ? $currentPage-1 : $firstPage ;
    $lastPage = $paginator->getLastPage();
    $nextPage = ($currentPage < $lastPage) ? $currentPage+1 : $lastPage ;

    $nearby = 2;
    $nearbyLeft = $currentPage - $nearby;
    $nearbyRight = $currentPage + $nearby;
?>
<?php if ($paginator->getLastPage() > 1): ?>
<ul>
	<?php if ($currentPage != $firstPage) { ?>
		<li class="paging-next">
			<a href="<?php echo $paginator->getUrl($firstPage) ?>"><img src="http://<?php echo Request::server ("SERVER_NAME"); ?>/assets/itruemart_new/global/images/level_b/arrow-left.jpg"> <?php echo __("pagination-first-btn"); ?></a>
		</li>
		<li class="paging-next">
			<a href="<?php echo $paginator->getUrl($prevPage) ?>"><img src="http://<?php echo Request::server ("SERVER_NAME"); ?>/assets/itruemart_new/global/images/level_b/arrow-left.jpg"> <?php echo __("pagination-previous-btn"); ?></a>
		</li>
	<?php } ?>

	<?php $tmpVar = $currentPage - $nearby ?>
	<?php if ( $tmpVar > 1 ) { ?>
	<li class="paging">
		<a href="<?php echo $paginator->getUrl(1) ?>">1</a>
	</li>
	<?php } ?>


	<?php if ( $nearbyLeft > $firstPage ) { ?>
		<li class="paging-blank">...</li>
	<?php } ?>

<?php /*
	<?php for ($i=$firstPage; $i<=$lastPage; $i++) { ?>
		<?php if ($i == $currentPage) { ?>
			<li class="current-selected">
				<a href="<?php echo $paginator->getUrl($i) ?>"><?php echo $i ?></a>
			</li>
		<?php } else { ?>
			<li class="paging">
				<a href="<?php echo $paginator->getUrl($i) ?>"><?php echo $i ?></a>
			</li>
		<?php } ?>
	<?php } ?>
*/ ?>

	<?php for ($i=$nearbyLeft; $i<$currentPage; $i++) { ?>
		<?php if ($i < 1) continue; ?>
		<li class="paging">
			<a href="<?php echo $paginator->getUrl($i) ?>"><?php echo $i ?></a>
		</li>
	<?php } ?>

	<li class="current-selected">
		<a href="<?php echo $paginator->getUrl($i) ?>"><?php echo $i ?></a>
	</li>

	<?php for ($i=$currentPage+1; $i<=$nearbyRight; $i++) { ?>
		<?php if ($i > $lastPage) continue; ?>
		<li class="paging">
			<a href="<?php echo $paginator->getUrl($i) ?>"><?php echo $i ?></a>
		</li>
	<?php } ?>

	<?php if ( $nearbyRight < $lastPage ) { ?>
		<li class="paging-blank">...</li>
	<?php } ?>

	<?php $tmpVar = $currentPage + $nearby ?>
	<?php if ( $tmpVar < $lastPage ) { ?>
	<li class="paging">
		<a href="<?php echo $paginator->getUrl($lastPage) ?>"><?php echo $lastPage ?></a>
	</li>
	<?php } ?>

	<?php if ($currentPage != $lastPage) { ?>
		<li class="paging-prev">
			<a href="<?php echo $paginator->getUrl($nextPage) ?>"><img src="http://<?php echo Request::server ("SERVER_NAME"); ?>/assets/itruemart_new/global/images/level_b/arrow-right.jpg"> <?php echo __("pagination-next-btn"); ?></a>
		</li>
		<li class="paging-prev">
			<a href="<?php echo $paginator->getUrl($lastPage) ?>"><img src="http://<?php echo Request::server ("SERVER_NAME"); ?>/assets/itruemart_new/global/images/level_b/arrow-right.jpg"> <?php echo __("pagination-last-btn"); ?></a>
		</li>
	<?php } ?>
</ul>
<?php endif; ?>