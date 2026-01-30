<?php
ob_start();
?>
<h1>Vabade töökohtade kategooriad</h1>

<?php if(empty($jobs)): ?>
    <p>Нет вакансий в этой категории.</p>
<?php else: ?>
    <?php foreach($jobs as $job): ?>
        <h2><a href="job?id=<?= $job['id'] ?>"><?= htmlspecialchars($job['title']) ?></a></h2>
        <p><?= nl2br(htmlspecialchars($job['description'])) ?></p>
        <p>
            <b>Город:</b> <?= htmlspecialchars($job['city']) ?> | 
            <b>Занятость:</b> <?= htmlspecialchars($job['employment']) ?> | 
            <b>График:</b> <?= htmlspecialchars($job['schedule']) ?> | 
            <b>Зарплата:</b> <?= htmlspecialchars($job['salary']) ?>
        </p>
        <hr>
    <?php endforeach; ?>
<?php endif; ?>

<?php
$content = ob_get_clean();
include_once 'view/layout.php';
?>