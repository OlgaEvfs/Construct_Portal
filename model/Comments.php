<?php
class Comments {

    private static $db = null;

    public static function setDatabase(Database $db) {
        self::$db = $db;
    }

    private static function getDb() {
        return self::$db ?: new Database();
    }

    public static function validateCommentData(array $data) {
        if (empty($data['text']) || empty($data['news_id'])) {
            return false;
        }

        return [
            'text' => trim($data['text']),
            'news_id' => $data['news_id'],
        ];
    }
    public static function insertComment($c, $id)
    {
        $query ="INSERT INTO `comments` (`id`, `news_id`, `text`, `date`) VALUES (NULL, '".$id."', '".$c."',
        CURRENT_TIMESTAMP)";
        $db = self::getDb();
        $q = $db->executeRun($query);
        return $q;
    }

    public static function getCommentByNewsID($id) {
        $query = "SELECT * FROM comments WHERE  news_id=".(string)$id." ORDER BY id DESC";
        $db = self::getDb();
        $arr = $db->getAll($query);
        return $arr;
    }

    public static function getCommentsCountByNewsID($id) {
        $query = "SELECT count(id) as 'count' FROM comments WHERE news_id=".(string)$id;
        $db = self::getDb();
        $c = $db->getOne($query);
        return $c;
    }

}
?>