<?php ob_start(); ?>

<?php
// Подгружаем список категорий вакансий из модели
$arr = modelAdminNews::getJobCategories();
?>

<div class="container" style="min-height: 400px;">
    <div class="col-ms-11">

        <h2>Добавить вакансию</h2>

        <?php
        if (isset($test)) {
            if ($test == true) {
                ?>
                <div class="alert alert-info">
                    <strong>Вакансия добавлена.</strong> <a href="newsAdmin">Список вакансий</a>
                </div>
            <?php
            } else {
                ?>
                <div class="alert alert-warning">
                    <strong>Ошибка добавления вакансии!</strong> <a href="newsAdmin">Список вакансий</a>
                </div>
            <?php
            }
        } else {
            ?>
            <form method="POST" action="jobsAddResult" enctype="multipart/form-data">
                <table class="table table-bordered">
                    <tr>
                        <td>Название вакансии</td>
                        <td><input type="text" name="title" class="form-control" required></td>
                    </tr>
                    <tr>
                        <td>Описание вакансии</td>
                        <td><textarea rows="5" name="description" class="form-control" required></textarea></td>
                    </tr>
                    <tr>
                        <td>Категория вакансии</td>
                        <td>
                            <select name="job_category_id" class="form-control" required>
                                <option value="">-- Выберите категорию вакансии --</option>
                                <?php foreach ($arr as $row): ?>
                                    <option value="<?= $row['id'] ?>"><?= htmlspecialchars($row['title']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>Город</td>
                        <td><input type="text" name="city" class="form-control"></td>
                    </tr>
                    <tr>
                        <td>Тип занятости</td>
                        <td><input type="text" name="employment" class="form-control"></td>
                    </tr>
                    <tr>
                        <td>График работы</td>
                        <td><input type="text" name="schedule" class="form-control"></td>
                    </tr>
                    <tr>
                        <td>Зарплата</td>
                        <td><input type="text" name="salary" class="form-control"></td>
                    </tr>
                    <tr>
                        <td>Контактное лицо</td>
                        <td><input type="text" name="contact_name" class="form-control"></td>
                    </tr>
                    <tr>
                        <td>Телефон</td>
                        <td><input type="text" name="phone" class="form-control"></td>
                    </tr>
                    <tr>
                        <td>Дата размещения</td>
                        <td><input type="date" name="posted_date" class="form-control"></td>
                    </tr>
                    <tr>
                        <td>Дата истечения</td>
                        <td><input type="date" name="expires_date" class="form-control"></td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <button type="submit" name="save" class="btn btn-primary">Сохранить</button>
                        </td>
                    </tr>
                </table>
            </form>
        <?php
        }
        ?>

    </div>
</div>

<?php $content = ob_get_clean(); ?>
<?php include "viewAdmin/templates/layout.php"; ?>