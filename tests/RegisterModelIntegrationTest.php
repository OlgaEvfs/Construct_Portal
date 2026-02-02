<?php declare(strict_types=1);

use PHPUnit\Framework\TestCase;

require_once 'model/Register.php';
require_once 'inc/Database.php';

final class RegisterModelIntegrationTest extends TestCase
{
    private $db;

    protected function setUp(): void
    {
        parent::setUp();

        // 1. Connect to the test database
        $this->db = new Database('localhost', 'root', '', 'test_construct_portal');

        // 2. Inject the test database connection into the models
        Register::setDatabase($this->db);
        // Also setting for other models as the setup script creates their tables too
        require_once 'model/News.php';
        News::setDatabase($this->db);
        require_once 'model/Job.php';
        Job::setDatabase($this->db);
        require_once 'admin/modelAdmin/modelAdminNews.php';
        modelAdminNews::setDatabase($this->db);


        // 3. Clear and populate the test database
        $this->seedDatabase();
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        $this->db = null;
    }

    private function seedDatabase(): void
    {
        $sqlFilePath = __DIR__ . '/construct_portal_test_setup.sql';
        if (!file_exists($sqlFilePath)) {
            $this->fail("Test setup SQL file not found at: " . $sqlFilePath);
        }

        $sql = file_get_contents($sqlFilePath);
        if ($sql === false) {
            $this->fail("Failed to read SQL setup file.");
        }

        try {
            // The setup script handles dropping and creating tables
            $this->db->executeRun($sql);
        } catch (PDOException $e) {
            $this->fail("Failed to seed test database: " . $e->getMessage());
        }
    }

    public function testCreateUserInsertsRecordCorrectly(): void
    {
        $userData = [
            'username' => 'newuser',
            'email' => 'newuser@example.com',
            'password' => password_hash('securepassword', PASSWORD_DEFAULT),
            'status' => 'user',
            'registration_date' => date("Y-m-d"),
            'raw_password' => 'securepassword'
        ];

        $result = Register::createUser($userData);
        $this->assertTrue($result);

        // Fetch the inserted record to verify
        $query = "SELECT * FROM users WHERE email = 'newuser@example.com'";
        $insertedUser = $this->db->getOne($query);

        $this->assertIsArray($insertedUser);
        $this->assertEquals($userData['username'], $insertedUser['username']);
        $this->assertEquals($userData['email'], $insertedUser['email']);
        $this->assertTrue(password_verify($userData['raw_password'], $insertedUser['password']));
        $this->assertEquals($userData['status'], $insertedUser['status']);
        $this->assertEquals($userData['registration_date'], $insertedUser['registration_date']);
        $this->assertEquals($userData['raw_password'], $insertedUser['pass']);
    }

    public function testCreateUserWithDuplicateEmailFails(): void
    {
        $userData1 = [
            'username' => 'duplicate',
            'email' => 'duplicate@example.com',
            'password' => password_hash('password', PASSWORD_DEFAULT),
            'status' => 'user',
            'registration_date' => date("Y-m-d"),
            'raw_password' => 'password'
        ];
        $result1 = Register::createUser($userData1);
        $this->assertTrue($result1);

        // Attempt to create user with same email
        $userData2 = [
            'username' => 'duplicate2',
            'email' => 'duplicate@example.com',
            'password' => password_hash('password2', PASSWORD_DEFAULT),
            'status' => 'user',
            'registration_date' => date("Y-m-d"),
            'raw_password' => 'password2'
        ];
        
        // Expect false because PDO::execute() returns false on failure by default
        $result2 = Register::createUser($userData2);
        $this->assertFalse($result2);
    }
}
