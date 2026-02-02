<?php
class modelAdminNews {

    private static $db = null;

    public static function setDatabase(Database $db) {
        self::$db = $db;
    }

    private static function getDb() {
        // If a DB connection has been injected, use it. Otherwise, create a new one.
        return self::$db ?: new Database();
    }

    public static function validateNewsData(array $data) {
        if (empty($data['title']) || empty($data['text'])) {
            return false;
        }

        return [
            'title' => trim($data['title']),
            'text' => trim($data['text']),
            'idCategory' => $data['idCategory'] ?? null,
            'video' => $data['video'] ?? null,
        ];
    }

    public static function validateJobData(array $data) {
        // Required fields
        if (empty($data['title']) || empty($data['description']) || empty($data['job_category_id'])) {
            return false;
        }

        return [
            'title' => trim($data['title']),
            'description' => trim($data['description']),
            'city' => trim($data['city'] ?? ''),
            'employment' => trim($data['employment'] ?? ''),
            'schedule' => trim($data['schedule'] ?? ''),
            'salary' => trim($data['salary'] ?? ''),
            'contact_name' => trim($data['contact_name'] ?? ''),
            'phone' => trim($data['phone'] ?? ''),
            'posted_date' => $data['posted_date'] ?? null,
            'expires_date' => $data['expires_date'] ?? null,
            'job_category_id' => $data['job_category_id'],
        ];
    }

    // -----------NEWS -----------------

    public static function getNewsList() {
        $query = "SELECT news.*, category.name,users.username from news,
        category,users WHERE news.category_id=category.id AND
        news.user_id=users.id ORDER BY `news`.`id` DESC";
        $db = self::getDb();
        $arr = $db->getAll($query);
        return $arr;
    }
    
    // Testable method for adding news
    public static function addNews(array $data) {
        $sql = "INSERT INTO `news` (`title`, `text`, `picture`, `video`, `category_id`, `user_id`) VALUES (?, ?, ?, ?, ?, ?)";
        
        $db = self::getDb();
        $stmt = $db->connect()->prepare($sql);

        // Bind parameters
        $stmt->bindValue(1, $data['title']);
        $stmt->bindValue(2, $data['text']);
        $stmt->bindValue(3, $data['image'] ?? null, PDO::PARAM_LOB);
        $stmt->bindValue(4, $data['video'] ?? null);
        $stmt->bindValue(5, $data['idCategory']);
        $stmt->bindValue(6, $data['user_id'] ?? 1); // Default user_id to 1 if not provided

        return $stmt->execute();
    }

    //------Add (original method, now refactored)
    public static function getNewsAdd() {
        if (!isset($_POST['save'])) {
            return false;
        }

        $validatedData = self::validateNewsData($_POST);
        if ($validatedData === false) {
            return false;
        }
        
        $imageContent = null;
        if (!empty($_FILES['picture']['tmp_name'])) {
            // It's better to handle file uploads in a controller, but for now, we keep it here.
            $imageContent = file_get_contents($_FILES['picture']['tmp_name']);
        }

        $dataToInsert = [
            'title' => $validatedData['title'],
            'text' => $validatedData['text'],
            'idCategory' => $validatedData['idCategory'],
            'video' => $validatedData['video'],
            'image' => $imageContent,
            'user_id' => 1 // Assuming a default user_id
        ];

        return self::addNews($dataToInsert);
    }
    //----------news detail id
    public static function getNewsDetail($id) {
        $query = "SELECT news.*, category.name,users.username from news, category,users WHERE news.category_id=category_id AND news.user_id=users.id and news.id=".$id;
        $db = self::getDb();
        $arr = $db->getOne($query);
        return $arr;
    }

    // Testable method for editing news
    public static function editNews($id, array $data) {
        $db = self::getDb();
        
        $sql = "UPDATE `news` SET `title` = ?, `text` = ?, `category_id` = ?";
        $params = [$data['title'], $data['text'], $data['idCategory']];

        if (array_key_exists('image', $data)) {
            $sql .= ", `picture` = ?";
            $params[] = $data['image'];
        }

        $sql .= " WHERE `id` = ?";
        $params[] = $id;
        
        $stmt = $db->connect()->prepare($sql);
        return $stmt->execute($params);
    }
    
    //----------news edit (original method, now refactored)
    public static function getNewsEdit($id) {
        if (!isset($_POST['save'])) {
            return false;
        }

        $validatedData = self::validateNewsData($_POST);
        if ($validatedData === false) {
            return false;
        }

        $dataToUpdate = [
            'title' => $validatedData['title'],
            'text' => $validatedData['text'],
            'idCategory' => $validatedData['idCategory'],
        ];

        if (!empty($_FILES['picture']['tmp_name'])) {
            $dataToUpdate['image'] = file_get_contents($_FILES['picture']['tmp_name']);
        }

        return self::editNews($id, $dataToUpdate);
    }

    // Testable method for deleting news
    public static function deleteNews($id) {
        $sql = "DELETE FROM `news` WHERE `id` = ?";
        $db = self::getDb();
        $stmt = $db->connect()->prepare($sql);
        return $stmt->execute([$id]);
    }

    //-----------news delete (original method, now refactored)
    public static function getNewsDelete($id) {
        if (isset($_POST['save'])) {
            return self::deleteNews($id);
        }
        return false;
    }

    // ------------------- JOBS -----------------
    public static function getJobCategories() {
        $db = self::getDb();
        // выбираем все категории вакансий
        $sql = "SELECT * FROM job_category ORDER BY title";
        return $db->getAll($sql);
    }
    
    // Testable method for adding a job
    public static function addJob(array $data) {
        $sql = "INSERT INTO `jobs` (`title`, `description`, `city`, `employment`, `schedule`, `salary`, `contact_name`, `phone`, `posted_date`, `expires_date`, `job_category_id`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        
        $db = self::getDb();
        $stmt = $db->connect()->prepare($sql);

        $params = [
            $data['title'],
            $data['description'],
            $data['city'] ?? null,
            $data['employment'] ?? 'Полная занятость',
            $data['schedule'] ?? 'Стандартный график',
            $data['salary'] ?? null,
            $data['contact_name'] ?? null,
            $data['phone'] ?? null,
            $data['posted_date'] ?? date('Y-m-d H:i:s'),
            $data['expires_date'] ?? null,
            $data['job_category_id'],
        ];

        return $stmt->execute($params);
    }

    public static function getJobsAdd() {
        if (!isset($_POST['save'])) {
            return false;
        }

        $validatedData = self::validateJobData($_POST);
        if ($validatedData === false) {
            return false;
        }

        return self::addJob($validatedData);
    }
    //----------job detail id
    public static function getJobDetail($id) {
        $db = self::getDb();

        $query = "SELECT jobs.*, job_category.title AS category_title
                FROM jobs
                LEFT JOIN job_category ON jobs.job_category_id = job_category.id
                WHERE jobs.id = ".$id;

        $arr = $db->getOne($query);
        return $arr;
    }

    // Testable method for editing a job
    public static function editJob($id, array $data) {
        $sql = "UPDATE jobs SET
                title = :title,
                description = :description,
                city = :city,
                employment = :employment,
                schedule = :schedule,
                salary = :salary,
                contact_name = :contact_name,
                phone = :phone,
                posted_date = :posted_date,
                expires_date = :expires_date,
                job_category_id = :job_category_id
                WHERE id = :id";
        
        $db = self::getDb();
        $stmt = $db->connect()->prepare($sql);

        $data['id'] = $id;

        return $stmt->execute($data);
    }

    //----------job edit (original method, now refactored)
    public static function getJobEdit($id) {
        if (!isset($_POST['save'])) {
            return false;
        }

        $validatedData = self::validateJobData($_POST);
        if ($validatedData === false) {
            return false;
        }

        // The validation function returns all fields, so we can pass it directly
        return self::editJob($id, $validatedData);
    }
    
    // Testable method for deleting a job
    public static function deleteJob($id) {
        $sql = "DELETE FROM `jobs` WHERE `id` = ?";
        $db = self::getDb();
        $stmt = $db->connect()->prepare($sql);
        return $stmt->execute([$id]);
    }

    //-----------job delete (original method, now refactored)
    public static function getJobDelete($id) {
        if (isset($_POST['save'])) {
            return self::deleteJob($id);
        }
        return false;
    }
}// class