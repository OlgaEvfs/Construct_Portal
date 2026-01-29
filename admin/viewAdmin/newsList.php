<?php ob_start() ?>

<h2>News List</h2>

<div class="container" style="min-height: 400px;">
    <div style="margin: 20px;">
        <a class="btn btn-primary" href="newsAdd" role="button">Добавить новость</a>
    </div>
    <div style="margin: 20px;">
        <a class="btn btn-primary" href="jobsAdd" role="button">Добавить вакансию</a>
    </div>
    <div class="col-md-11">
        <table class="table table-bordered table-responsive">
            <tr>
                <th width="10%">ID</th>
                <th width="70%">Header News</th>
                <th width="20%"></th>
            </tr>
        <?php

        foreach ($arr as $row) {
        echo '<tr>';

            echo '<td>'.$row['id'].'</td>   ';

            echo '<td><b>Title:</b> '.$row['title'].'<br>';
            echo '<b>Категория: </b><i>'.$row['name'].'</i>';
            echo '<br><b>Author: </b><i>'.$row['username'].'</i>';
            echo '</td>';
            echo '<td>
            <a href="newsEdit?id='.$row['id'].'">Edit <span class="glyphicon glyphicon-edit" aria-hidden="true"></span></a>
            <a href="newsDel?id='.$row['id'].'">Delete <span class="glyphicon glyphicon-remove" aria-hidden="true"></span></a>
            </td>   ';

        echo '</tr>';
        }

        ?>
        </table>

        <h2>Вакансии</h2>

        <table class="table table-bordered">
        <tr>
            <th>ID</th>
            <th>Вакансия</th>
            <th>Категория</th>
            <th>Город</th>
            <th>Зарплата</th>
            <th></th>
        </tr>

        <?php foreach ($jobs as $job): ?>
        <tr>
            <td><?= $job['id'] ?></td>
            <td><?= htmlspecialchars($job['title']) ?></td>
            <td><?= htmlspecialchars($job['category_title']) ?></td>
            <td><?= htmlspecialchars($job['city']) ?></td>
            <td><?= htmlspecialchars($job['salary']) ?></td>
            <td>
                <a href="jobEdit?id=<?= $job['id'] ?>">Edit <span class="glyphicon glyphicon-edit" aria-hidden="true"></span></a>
                <a href="jobDel?id=<?= $job['id'] ?>">Delete <span class="glyphicon glyphicon-remove" aria-hidden="true"></span></a>
            </td>
        </tr>
        <?php endforeach; ?>
        </table>

    </div>
</div>
<?php $content = ob_get_clean(); ?>

<?php include "viewAdmin/templates/layout.php"; ?>