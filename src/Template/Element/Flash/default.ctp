<?php
$class = 'message';
if (!empty($params['class'])) {
	$class .= ' ' . $params['class'];
}
?>
<div class="alert alert-warning <?= h($class) ?>" role="alert">
    <strong><?= h($message) ?></strong>
</div>