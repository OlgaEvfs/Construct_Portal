<?php
class modelAdminNews {

    // -----------NEWS -----------------

    public static function getNewsList() {
        $query = "SELECT news.*, category.name,users.username from news,
        category,users WHERE news.category_id=category.id AND
        news.user_id=users.id ORDER BY `news`.`id` DESC";
        $db = new Database();
        $arr = $db->getAll($query);
        return $arr;
    }
    //------Add
    public static function getNewsAdd() {
        $test = false;
        if (isset($_POST['save'])) {
            if (isset($_POST['title']) && isset($_POST['text']) && isset($_POST['idCategory']) && isset($_POST['video'])) {

                $title = $_POST['title'];
                $text = $_POST['text'];
                $idCategory = $_POST['idCategory'];

                //-------------images type blob
                    $image = null; // по умолчанию, если картинки нет

                        if (!empty($_FILES['picture']['tmp_name'])) {
                            $image = addslashes(file_get_contents($_FILES['picture']['tmp_name']));
                        }

                //------------videos type text
                    $video = addslashes($_POST['video']);
                
                //----------------
                $sql = "INSERT INTO `news` (`id`, `title`, `text`, `picture`, `video`, `category_id`, `user_id`) VALUES (NULL, '$title', '$text', '$image', '$video', '$idCategory', '1')";
                $db = new Database();
                $item = $db->executeRun($sql);
                if ($item == true) {
                    $test = true;
                }
            }
        }
        return $test;
    }
    //----------news detail id
    public static function getNewsDetail($id) {
        $query = "SELECT news.*, category.name,users.username from news, category,users WHERE news.category_id=category_id AND news.user_id=users.id and news.id=".$id;
        $db = new Database();
        $arr = $db->getOne($query);
        return $arr;
    }
    //----------news edit
    public static function getNewsEdit($id) {
        $test = false;
        if (isset($_POST['save'])) {
            if (isset($_POST['title']) && isset($_POST['text']) && isset($_POST['idCategory'])) {
                $title = $_POST['title'];
                $text = $_POST['text'];
                $idCategory = $_POST['idCategory'];
                //-------------images type blob
                $image = $_FILES['picture']['name'];
                if ($image != "") {
                    $image = addslashes(file_get_contents($_FILES['picture']['tmp_name']));
                /*  //------------images type text
                    $uploaddir = '../images/';
                    $uploadfile = $uploaddir . basename($_FILES['picture']['name']);
                    copy($_FILES['picture']['tmp_name'], $uploadfile); */
                }
                //-------------------------
                if ($image == "") {
                    $sql = "UPDATE `news` SET `title` = '$title', `text` = '$text', `category_id` = '$idCategory' WHERE `news`.`id` = ".$id;
                }
                else {
                    $sql = "UPDATE `news` SET `title` = '$title', `text` = '$text', `picture` = '$image', `category_id` = '$idCategory' WHERE `news`.`id` = ".$id;
                }
                        $db = new Database();
                        $item = $db->executeRun($sql);
                    if ($item == true) {
                        $test = true;
                    }
                
            }
        }
        return $test;
    }
    //-----------news delete
    public static function getNewsDelete($id) {
        $test = false;
        if (isset($_POST['save'])) {
            $sql = "DELETE FROM `news` WHERE `news`.`id` = ".$id;
            $db = new Database();
            $item = $db->executeRun($sql);
            if ($item == true) {
                $test = true;
            }
        return $test;
        }
    }

    // ------------------- JOBS -----------------
    public static function getJobCategories() {
        $db = new Database();
        // выбираем все категории вакансий
        $sql = "SELECT * FROM job_category ORDER BY title";
        return $db->getAll($sql);
    }

    public static function getJobsAdd() {
        $test = false;
        if (isset($_POST['save'])) {
            if (isset($_POST['title']) && isset($_POST['description']) && isset($_POST['job_category_id'])) {

                $title = $_POST['title'];
                $description = $_POST['description'];
                $city = $_POST['city'];
                $employment = $_POST['employment'];
                $schedule = $_POST['schedule'];
                $salary = $_POST['salary'];
                $contact_name = $_POST['contact_name'];
                $phone = $_POST['phone'];
                $posted_date = $_POST['posted_date'];
                $expires_date = $_POST['expires_date'];
                $job_category_id = $_POST['job_category_id'];

                $sql = "INSERT INTO `jobs` (`id`, `title`, `description`, `city`, `employment`, `schedule`, `salary`, `contact_name`, `phone`, `posted_date`, `expires_date`, `job_category_id`) VALUES (NULL, '$title', '$description', '$city', '$employment', '$schedule', '$salary', '$contact_name', '$phone', '$posted_date', '$expires_date', '$job_category_id')";
                $db = new Database();
                $item = $db->executeRun($sql);
                if ($item == true) {
                    $test = true;
                }
            }
        }
        return $test;
    }
    //----------job detail id
    public static function getJobDetail($id) {
        $query = "SELECT jobs.*, job_categories.title as category_title from jobs, job_categories WHERE jobs.job_category_id=job_categories.id and jobs.id=".$id;
        $db = new Database();
        $arr = $db->getOne($query);
        return $arr;
    }
    //----------job edit
    public static function getJobEdit($id) {
        $test = false;
        if (isset($_POST['save'])) {
            if (isset($_POST['title']) && isset($_POST['description']) && isset($_POST['job_category_id'])) {
                $title = $_POST['title'];
                $description = $_POST['description'];
                $city = $_POST['city'];
                $employment = $_POST['employment'];
                $schedule = $_POST['schedule'];
                $salary = $_POST['salary'];
                $contact_name = $_POST['contact_name'];
                $phone = $_POST['phone'];
                $posted_date = $_POST['posted_date'];
                $expires_date = $_POST['expires_date'];
                $job_category_id = $_POST['job_category_id'];
                $sql = "UPDATE `jobs` SET `title` = '$title', `description` = '$description', `city` = '$city', `employment` = '$employment', `schedule` = '$schedule', `salary` = '$salary', `contact_name` = '$contact_name', `phone` = '$phone', `posted_date` = '$posted_date', `expires_date` = '$expires_date', `job_category_id` = '$job_category_id' WHERE `jobs`.`id` = ".$id;
                        $db = new Database();
                        $item = $db->executeRun($sql);
                    if ($item == true) {
                        $test = true;
                    }
            }
        }
        return $test;
    }
    //-----------job delete
    public static function getJobDelete($id) {
        $test = false;
        if (isset($_POST['save'])) {
            $sql = "DELETE FROM `jobs` WHERE `jobs`.`id` = ".$id;
            $db = new Database();
            $item = $db->executeRun($sql);
            if ($item == true) {
                $test = true;
            }
        return $test;
        }
    }
}// class