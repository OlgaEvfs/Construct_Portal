<?php
class Register {

    private static $db = null;

    public static function setDatabase(Database $db) {
        self::$db = $db;
    }

    private static function getDb() {
        return self::$db ?: new Database();
    }

    public static function validateRegistrationData(array $data) {
        $errorString = "";

        if (empty($data['name'])) {
            $errorString .= "Имя пользователя не может быть пустым<br />";
        }

        $email = filter_var($data['email'] ?? '', FILTER_VALIDATE_EMAIL);
        if (!$email) {
            $errorString .= "Неправельный email<br />";
        }

        $password = $data['password'] ?? '';
        $confirm = $data['confirm'] ?? '';

        if (empty($password) || empty($confirm) || mb_strlen($password) < 6) {
            $errorString .= "Пароль должен быть больше 6 символов <br />";
        }
        if ($password != $confirm) {
            $errorString .= "Пароли не совпадают<br />";
        }

        if (mb_strlen($errorString) == 0) {
            return [
                'name' => trim($data['name']),
                'email' => $email,
                'password' => $password, // Not hashing here, just returning for further processing
                'confirm' => $confirm,
            ];
        } else {
            return false; // Return false or the error string itself
        }
    }

    // Testable method for creating a user
    public static function createUser(array $data) {
        $sql = "INSERT INTO `users` (`username`, `email`, `password`, `status`, `registration_date`, `pass`)
                VALUES (?, ?, ?, ?, ?, ?)";
        $db = self::getDb();
        $stmt = $db->connect()->prepare($sql);

        $params = [
            $data['username'],
            $data['email'],
            $data['password'], // This should be the HASHED password
            $data['status'] ?? 'user',
            $data['registration_date'] ?? date("Y-m-d"),
            $data['raw_password'] // This is the plain text password for the 'pass' column
        ];

        try {
            return $stmt->execute($params);
        } catch (PDOException $e) {
            // Check if it's a duplicate entry error (specific error code might vary by DB)
            // For MySQL, integrity constraint violation is usually SQLSTATE 23000
            if ($e->getCode() == '23000') { // Integrity constraint violation
                return false; // Return false for duplicate email
            }
            throw $e; // Re-throw other PDOExceptions
        }
    }

    //------------------register (original method, now refactored)
    public static function registerUser() {
        $controll = array(0=>false, 1=>'error');
        if(!isset($_POST['save'])) {
            return $controll;
        }

        $validatedData = self::validateRegistrationData($_POST);
        if ($validatedData === false) {
            // Re-run validation to get the error string, as validateRegistrationData returns false
            $errorString = "";
            if (empty($_POST['name'])) {
                $errorString .= "Имя пользователя не может быть пустым<br />";
            }
            if (!filter_var($_POST['email'] ?? '', FILTER_VALIDATE_EMAIL)) {
                $errorString .= "Неправельный email<br />";
            }
            if (empty($_POST['password']) || empty($_POST['confirm']) || mb_strlen($_POST['password']) < 6) {
                $errorString .= "Пароль должен быть больше 6 символов <br />";
            }
            if (($_POST['password'] ?? '') != ($_POST['confirm'] ?? '')) {
                $errorString .= "Пароли не совпадают<br />";
            }
            return array(0=>false, 1=>$errorString);
        }
        
        $passwordHash = password_hash($validatedData['password'], PASSWORD_DEFAULT);
        $date = date("Y-m-d");

        $userData = [
            'username' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => $passwordHash,
            'status' => 'user',
            'registration_date' => $date,
            'raw_password' => $validatedData['password'] // Store raw password for 'pass' column
        ];

        $item = self::createUser($userData);
        if($item) {
            $controll = array(0=>true);
        } else {
            $controll = array(0=>false, 1=>'Ошибка при создании пользователя в базе данных');
        }
        return $controll;
    }
}

?>