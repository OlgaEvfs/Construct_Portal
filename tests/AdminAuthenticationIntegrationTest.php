<?php declare(strict_types=1);

use PHPUnit\Framework\TestCase;

require_once 'admin/modelAdmin/modelAdmin.php';
require_once 'inc/Database.php';

final class AdminAuthenticationIntegrationTest extends TestCase
{
    private $db;

    protected function setUp(): void
    {
        parent::setUp();

        // 1. Connect to the test database
        $this->db = new Database('localhost', 'root', '', 'test_construct_portal');

        // 2. Inject the test database connection into the models
        modelAdmin::setDatabase($this->db);
        // Also setting for other models as the setup script creates their tables too
        require_once 'model/News.php';
        News::setDatabase($this->db);
        require_once 'model/Job.php';
        Job::setDatabase($this->db);
        require_once 'model/Comments.php';
        Comments::setDatabase($this->db);
        require_once 'model/Register.php';
        Register::setDatabase($this->db);
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

    public function testVerifyCredentialsWithValidAdminUser(): void
    {
        $email = 'admin@test.com';
        $password = '123456'; // Raw password for Test Admin
        
        $user = modelAdmin::verifyCredentials($email, $password);

        $this->assertIsArray($user);
        $this->assertEquals($email, $user['email']);
        $this->assertEquals('Test Admin', $user['username']);
        $this->assertEquals('admin', $user['status']);
    }

    public function testVerifyCredentialsWithInvalidPassword(): void
    {
        $email = 'admin@test.com';
        $password = 'wrongpassword';
        
        $user = modelAdmin::verifyCredentials($email, $password);

        $this->assertFalse($user);
    }

    public function testVerifyCredentialsWithNonExistentEmail(): void
    {
        $email = 'nonexistent@test.com';
        $password = 'anypassword';
        
        $user = modelAdmin::verifyCredentials($email, $password);

        $this->assertFalse($user);
    }
}
