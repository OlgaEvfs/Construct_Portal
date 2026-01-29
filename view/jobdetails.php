<?php
ob_start();
?>
<h1><?= htmlspecialchars($job['title']) ?></h1>
<p><?= nl2br(htmlspecialchars($job['description'])) ?></p>
<p><b>Город:</b> <?= htmlspecialchars($job['city']) ?></p>
<p><b>Занятость:</b> <?= htmlspecialchars($job['employment']) ?></p>
<p><b>График:</b> <?= htmlspecialchars($job['schedule']) ?></p>
<p><b>Зарплата:</b> <?= htmlspecialchars($job['salary']) ?></p>
<p><b>Контакт:</b> <?= htmlspecialchars($job['contact_name']) ?> | <?= htmlspecialchars($job['phone']) ?></p>
<p><b>Дата публикации:</b> <?= htmlspecialchars($job['posted_date']) ?></p>
<p><b>Срок действия:</b> <?= htmlspecialchars($job['expires_date']) ?></p>

<?php
$content = ob_get_clean();
include_once 'view/layout.php';
?>