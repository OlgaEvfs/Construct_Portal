<?php ob_start(); ?>
<?php
$id = $_GET['id'];

// Получаем данные вакансии
$detail = modelAdminNews::getJobDetail($id);

// Получаем все категории вакансий для select
$jobCategories = modelAdminNews::getJobCategories();
?>

<div class="container" style="min-height: 400px;">
    <div class="col-md-11">
        <h2>Edit Job</h2>
        <?php
        if (isset($test)) {
            if ($test == true) {
                ?>
                    <div class="alert alert-info">
                        <strong>Вакансия изменена.</strong><a href="newsAdmin">Список вакансий</a>
                    </div>
                <?php
            }
            else if ($test == false) {
                ?>
                    <div class="alert alert-warning">
                        <strong>Ошибка изменения вакансии!</strong><a href="newsAdmin">Список вакансий</a>
                    </div>
                <?php
            }
        }
        else {
            ?>
            <form method="POST" action="jobEditResult?id=<?php echo $id; ?>" enctype="multipart/form-data">
                <table class="table table-bordered">
                    <tr>
                        <td>Название вакансии</td>
                        <td><input type="text" name="title" class="form-control" required value="<?php echo htmlspecialchars($detail['title']); ?>" ></td>
                    </tr>
                    <tr>
                        <td>Описание вакансии</td>
                        <td><textarea rows="5" name="description" class="form-control" required ><?php echo htmlspecialchars($detail['description']); ?></textarea></td>
                    </tr>
                    <tr>
                        <td>Категория вакансии</td>
                        <td>
                            <select name="job_category_id" class="form-control" required>
                                <option value="">-- Выберите категорию вакансии --</option>
                                <?php
                                foreach ($jobCategories as $cat) {
                                    $selected = ($cat['id'] == $detail['job_category_id']) ? ' selected' : '';
                                    echo '<option value="' . $cat['id'] . '"' . $selected . '>' . htmlspecialchars($cat['title']) . '</option>';
                                }
                                ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>Город</td>
                        <td><input type="text" name="city" class="form-control" value="<?php echo htmlspecialchars($detail['city']); ?>"></td>
                    </tr>
                    <tr>
                        <td>Тип занятости</td>
                        <td><input type="text" name="employment" class="form-control" value="<?php echo htmlspecialchars($detail['employment']); ?>"></td>
                    </tr>
                    <tr>
                        <td>График работы</td>
                        <td><input type="text" name="schedule" class="form-control" value="<?php echo htmlspecialchars($detail['schedule']); ?>"></td>
                    </tr>
                    <tr>
                        <td>Зарплата</td>
                        <td><input type="text" name="salary" class="form-control" value="<?php echo htmlspecialchars($detail['salary']); ?>"></td>
                    </tr>
                    <tr>
                        <td>Контактное лицо</td>
                        <td><input type="text" name="contact_name" class="form-control" value="<?php echo htmlspecialchars($detail['contact_name']); ?>"></td>
                    </tr>
                    <tr>
                        <td>Телефон</td>
                        <td><input type="text" name="phone" class="form-control" value="<?php echo htmlspecialchars($detail['phone']); ?>"></td>
                    </tr>
                    <tr>
                        <td>Дата размещения</td>
                        <td><input type="date" name="posted_date" class="form-control" value="<?php echo htmlspecialchars($detail['posted_date']); ?>"></td>
                    </tr>
                    <tr>
                        <td>Дата истечения</td>
                        <td><input type="date" name="expires_date" class="form-control" value="<?php echo htmlspecialchars($detail['expires_date']); ?>"></td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <button type="submit" name="save" class="btn btn-primary">Сохранить</button>
                            <a href="newsAdmin" class="btn btn-secondary">Отмена</a>
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