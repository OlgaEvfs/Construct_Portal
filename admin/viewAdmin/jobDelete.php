<h2>Удалить вакансию</h2>
<p>Вы уверены, что хотите удалить «<?= htmlspecialchars($detail['title']) ?>»?</p>
<form method="post" action="jobDeleteResult?id=<?= $detail['id'] ?>">
    <button type="submit" name="save">Удалить</button>
    <a href="newsList">Отмена</a>
</form>
