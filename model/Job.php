<?php
    class Job {
        private static $db = null;

        public static function setDatabase(Database $db) {
            self::$db = $db;
        }

        private static function getDb() {
            // If a DB connection has been injected, use it. Otherwise, create a new one.
            return self::$db ?: new Database();
        }

        public static function getJobsByCategoryID($category_id) {
            $query = "SELECT * FROM jobs WHERE job_category_id = ? ORDER BY posted_date DESC";
            $db = self::getDb();
            $stmt = $db->connect()->prepare($query);
            $stmt->execute([$category_id]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        public static function getJobByID($id) {
            $query = "SELECT * FROM jobs WHERE id = ?";
            $db = self::getDb();
            $stmt = $db->connect()->prepare($query);
            $stmt->execute([$id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }
        public static function getAllJobs() {
            $query = "
                SELECT jobs.*, job_category.title AS category_title
                FROM jobs
                LEFT JOIN job_category ON jobs.job_category_id = job_category.id
                ORDER BY jobs.posted_date DESC
            ";
            $db = self::getDb();
            $stmt = $db->connect()->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
    }
?>