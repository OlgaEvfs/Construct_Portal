<?php
class modelAdmin {
    private static $db = null;

    public static function setDatabase(Database $db) {
        self::$db = $db;
    }

    private static function getDb() {
        return self::$db ?: new Database();
    }

    // Testable method to verify user credentials
    public static function verifyCredentials(string $email, string $password) {
        $db = self::getDb();
        $sql = 'SELECT * FROM `users` WHERE `email` = :email';
        $stmt = $db->connect()->prepare($sql);
        $stmt->execute([':email' => $email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify(trim($password), $user['password'])) { // Trim the password
            return $user; // Return user data on success
        }
        return false; // Return false on failure
    }

    // АВТОРИЗАЦИЯ АДМИНА (original method, now refactored)
    public static function userAuthentication()
    {
        if (isset($_SESSION['sessionId'])) {
            return true;
        }
        else {
            if(isset($_POST['btnLogin'])) {
                $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
                $password = filter_input(INPUT_POST, 'password');

                if ($email && $password) {
                    $user = self::verifyCredentials($email, $password);

                    if ($user) {
                        $_SESSION['sessionId']=session_id();
                        $_SESSION['userId']=$user['id'];
                        $_SESSION['name']=$user['username'];
                        $_SESSION['status']=$user['status'];
                        return true;
                    } else {
                        $_SESSION['errorString'] = 'Неправильное имя пользователя или пароль';
                    }
                } else {
                    $_SESSION['errorString'] = 'Введите email и пароль';
                }
            }
        }
        return false;
    }
// ВЫХОД ИЗ АДМИНКИ
    public static function userLogout()
    {
        unset($_SESSION['sessionId']);
        unset($_SESSION['userId']);
        unset($_SESSION['name']);
        unset($_SESSION['status']);
        session_destroy();
        return;
    }
}
?>