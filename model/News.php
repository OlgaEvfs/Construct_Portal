<?php
class News {

    private static $db = null;

    public static function setDatabase(Database $db) {
        self::$db = $db;
    }

    private static function getDb() {
        // If a DB connection has been injected, use it. Otherwise, create a new one.
        return self::$db ?: new Database();
    }

    public static function getLast5News() {
        $query = "SELECT * FROM news ORDER BY id DESC LIMIT 5";
        $db = self::getDb();
        $arr = $db->getAll($query);
        return $arr;
    }

    public static function getAllNews() {
        $query = "SELECT * FROM news ORDER BY id DESC";
        $db = self::getDb();
        $arr = $db->getAll($query);
        return $arr;
    }

    public static function getNewsByCategoryID($id) {
        $query = "SELECT * FROM news where category_id=".(string)$id." ORDER BY id DESC";
        $db = self::getDb();
        $arr = $db->getAll($query);
        return $arr;
    }

    public static function getNewsByID($id) {
        $query = "SELECT * FROM news where id=".(string)$id;
        $db = self::getDb();
        $n = $db->getOne($query);
        return $n;
    }
    public static function getAllJobCategory() {
        $query = "SELECT * FROM job_category ORDER BY id ASC";
        $db = self::getDb();
        $arr = $db->getAll($query);
        return $arr;
    }
}
?>