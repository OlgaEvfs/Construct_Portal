<h2>Добавить вакансию</h2>
<form method="post" action="jobAddResult" enctype="multipart/form-data">
    <input type="text" name="title" placeholder="Название вакансии" required>
    <textarea name="description" placeholder="Описание вакансии" required></textarea>
    <input type="text" name="city" placeholder="Город">
    <input type="text" name="employment" placeholder="Тип занятости">
    <input type="text" name="schedule" placeholder="График работы">
    <input type="text" name="salary" placeholder="Зарплата">
    <input type="text" name="contact_name" placeholder="Контактное лицо">
    <input type="text" name="phone" placeholder="Телефон">
    <input type="date" name="posted_date">
    <input type="date" name="expires_date">

    <select name="job_category_id">
        <?php foreach ($jobCategories as $cat): ?>
            <option value="<?= $cat['id'] ?>"><?= htmlspecialchars($cat['title']) ?></option>
        <?php endforeach; ?>
    </select>

    <button type="submit" name="save">Сохранить</button>
</form>
