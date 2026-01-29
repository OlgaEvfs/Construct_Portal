<h2>Редактировать вакансию</h2>
<form method="post" action="jobEditResult?id=<?= $detail['id'] ?>" enctype="multipart/form-data">
    <input type="text" name="title" value="<?= htmlspecialchars($detail['title']) ?>" required>
    <textarea name="description" required><?= htmlspecialchars($detail['description']) ?></textarea>
    <input type="text" name="city" value="<?= htmlspecialchars($detail['city']) ?>">
    <input type="text" name="employment" value="<?= htmlspecialchars($detail['employment']) ?>">
    <input type="text" name="schedule" value="<?= htmlspecialchars($detail['schedule']) ?>">
    <input type="text" name="salary" value="<?= htmlspecialchars($detail['salary']) ?>">
    <input type="text" name="contact_name" value="<?= htmlspecialchars($detail['contact_name']) ?>">
    <input type="text" name="phone" value="<?= htmlspecialchars($detail['phone']) ?>">
    <input type="date" name="posted_date" value="<?= $detail['posted_date'] ?>">
    <input type="date" name="expires_date" value="<?= $detail['expires_date'] ?>">

    <select name="job_category_id">
        <?php foreach ($jobCategories as $cat): ?>
            <option value="<?= $cat['id'] ?>" <?= $cat['id'] == $detail['job_category_id'] ? 'selected' : '' ?>>
                <?= htmlspecialchars($cat['title']) ?>
            </option>
        <?php endforeach; ?>
    </select>

    <button type="submit" name="save">Сохранить изменения</button>
</form>

