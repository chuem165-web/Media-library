<?php require BASE_PATH . '/view/layout/header.php'; ?>

<?php
$found_in_full_catalog = $found_in_full_catalog ?? 0;
?>

<div class="section catalog page">
	<div class="wrapper">

		<?php

$title = '';

if (!empty($search)) {

    $title = 'Search results for "' . htmlspecialchars($search) . '"';

    if (!empty($section)) {
        $title .= ' in ' . ucfirst($section);
    }

} else {

    if (!empty($section)) {
        $title .= "<a href='index.php?page=catalog'>Full Catalog</a> &gt; ";
    }

    $title .= htmlspecialchars($pageTitle);
}

echo $title;
?>
		<?php if ($totalItems < 1): ?> 

			<?php if (!empty($section) && $found_in_full_catalog > 0): ?>

				<p>You are searching in the wrong section. Please check again.</p>

				<p>
					<a href="index.php?page=catalog&s=<?= urlencode($search) ?>">
						Search in the Full Catalog
					</a>
				</p>

			<?php else: ?>

				<p>No items were found matching that search term.</p>

				<p>
					Search again or
					<a href="index.php?page=catalog">Browse the Full Catalog.</a>
				</p>

			<?php endif; ?>

		<?php else: ?>

			<?php require BASE_PATH . '/view/partials/pagination.php'; ?>

			<ul class="catalog">
				<?php foreach ($catalog as $item): ?>
					<?= ItemView::render($item); ?>
				<?php endforeach; ?>
			</ul>

			<?php require BASE_PATH . '/view/partials/pagination.php'; ?>

		<?php endif; ?>

	</div>
</div>

<?php require BASE_PATH . '/view/layout/footer.php'; ?>
