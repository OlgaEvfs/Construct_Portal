<?php
ob_start();
?>
<h1>Vabade töökohtade kategooriad</h1>
<ul>
<?php foreach($arr as $cat): ?>
    <li>
        <a href="jobs?category=<?= $cat['id'] ?>">
            <?= htmlspecialchars($cat['title']) ?>
        </a>
    </li>
<?php endforeach; ?>
</ul>

<?php
$content = ob_get_clean();
include_once 'view/layout.php';
?>
