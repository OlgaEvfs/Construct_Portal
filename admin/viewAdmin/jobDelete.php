<?php ob_start(); ?>
<?php
$id = $_GET['id'];
$detail = modelAdminNews::getJobDetail($id); // данные вакансии
$arr = modelAdminNews::getJobCategories(); // список категорий
?>

<div class="container" style="min-height: 400px;">
    <div class="col-md-11">
        <h2>Delete Job</h2>
        <?php
        if (isset($test)) {
            if ($test == true) {
                ?>
                <div class="alert alert-info">
                    <strong>Вакансия удалена.</strong><a href="newsAdmin">Список вакансий</a>
                </div>
            <?php
            }
            else if ($test == false) {
                ?>
                <div class="alert alert-warning">
                    <strong>Ошибка удаления вакансии!</strong><a href="newsAdmin">Список вакансий</a>
                </div>
            <?php
            }
        }
        else {
            ?>
            <form method="POST" action="jobDelResult?id=<?php echo $id; ?>" enctype="multipart/form-data">
                <table class="table table-bordered">
                    <tr>
                        <td>Название вакансии</td>
                        <td><input type="text" name="title" class="form-control" required value=<?php echo $detail['title']; ?> readonly></td>
                    </tr>
                    <tr>
                        <td>Описание вакансии</td>
                        <td><textarea rows="5" name="description" class="form-control" required readonly><?php echo $detail['description']; ?></textarea></td>
                    </tr>
                    <tr>
                        <td>Категория вакансии</td>
                        <td>
                            <select name="job_category_id" class="form-control" disabled>
                                <?php
                                foreach ($arr as $row) {
                                    $selected = ($row['id'] == $detail['job_category_id']) ? ' selected' : '';
                                    echo '<option value="'.$row['id'].'"'.$selected.'>'.htmlspecialchars($row['title']).'</option>';
                                }
                                ?>
                            </select>
                        </td>
                     </tr>
                     <tr>
                        <td>Город</td>
                        <td><input type="text" name="city" class="form-control" value="<?php echo $detail['city']; ?>" readonly></td>
                     </tr>
                     <tr>
                        <td>Тип занятости</td>
                        <td><input type="text" name="employment" class="form-control" value="<?php echo $detail['employment']; ?>" readonly></td>
                     </tr>
                     <tr>
                        <td>График работы</td>
                        <td><input type="text" name="schedule" class="form-control" value="<?php echo $detail['schedule']; ?>" readonly></td>
                     </tr>
                    <tr>
                        <td>Зарплата</td>
                        <td><input type="text" name="salary" class="form-control" value="<?php echo $detail['salary']; ?>" readonly></td>
                    </tr>
                    <tr>
                        <td>Контактное лицо</td>
                        <td><input type="text" name="contact_name" class="form-control" value="<?php echo $detail['contact_name']; ?>" readonly></td>
                    </tr>
                    <tr>
                        <td>Телефон</td>
                        <td><input type="text" name="phone" class="form-control" value="<?php echo $detail['phone']; ?>" readonly></td>
                    </tr>
                    <tr>
                        <td>Дата размещения</td>
                        <td><input type="date" name="posted_date" class="form-control" value="<?php echo $detail['posted_date']; ?>" readonly></td>
                    </tr>
                    <tr>
                        <td>Дата истечения</td>
                        <td><input type="date" name="expires_date" class="form-control" value="<?php echo $detail['expires_date']; ?>" readonly></td>
                    </tr>
                </table>
                <input type="submit" name="save" class="btn btn-danger" value="Удалить вакансию">
            </form>
        <?php
        }
        ?>
    </div>
</div>
<?php $content = ob_get_clean(); ?>
<?php include "viewAdmin/templates/layout.php"; ?>         