<?php declare(strict_types=1);

use PHPUnit\Framework\TestCase;

require_once 'model/Job.php';
require_once 'inc/Database.php';

final class JobModelIntegrationTest extends TestCase
{
    private $db;

    protected function setUp(): void
    {
        parent::setUp();

        // 1. Connect to the test database
        $this->db = new Database('localhost', 'root', '', 'test_construct_portal');

        // 2. Inject the test database connection into the models
        require_once 'model/Job.php';
        Job::setDatabase($this->db);
        require_once 'admin/modelAdmin/modelAdminNews.php';
        modelAdminNews::setDatabase($this->db);
        // Also setting for News as the setup script creates news tables too
        require_once 'model/News.php';
        News::setDatabase($this->db);

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

    public function testGetAllJobsReturnsAllJobs(): void
    {
        $jobs = Job::getAllJobs();
        $this->assertIsArray($jobs);
        // We inserted 3 jobs
        $this->assertCount(3, $jobs);
        // Check for the joined column
        $this->assertArrayHasKey('category_title', $jobs[0]);
    }

    public function testGetJobsByCategoryIDReturnsCorrectJobs(): void
    {
        // job_category_id=1 has 2 jobs in our test data
        $categoryId = 1;
        $jobs = Job::getJobsByCategoryID($categoryId);

        $this->assertIsArray($jobs);
        $this->assertCount(2, $jobs);

        foreach ($jobs as $item) {
            $this->assertEquals($categoryId, $item['job_category_id']);
        }
    }

    public function testGetJobByIDReturnsSingleJobItem(): void
    {
        $jobId = 2;
        $jobItem = Job::getJobByID($jobId);

        $this->assertIsArray($jobItem);
        $this->assertEquals($jobId, $jobItem['id']);
        $this->assertEquals('Job 2', $jobItem['title']);
    }

    public function testGetJobByIDReturnsFalseForNonExistentID(): void
    {
        $jobId = 9999; // Non-existent ID
        $jobItem = Job::getJobByID($jobId);

        $this->assertFalse($jobItem);
    }

    public function testAddJobInsertsRecordCorrectly(): void
    {
        $jobData = [
            'title' => 'My Test Added Job',
            'description' => 'This is the text of the test added job.',
            'job_category_id' => 2,
            'city' => 'Test City',
            'employment' => 'Полная занятость',
            'schedule' => 'Стандартный график',
            'salary' => '5000',
            'contact_name' => 'Test Contact',
            'phone' => '555-5555',
            'posted_date' => '2026-02-01 12:00:00',
            'expires_date' => null
        ];

        $result = modelAdminNews::addJob($jobData);
        $this->assertTrue($result);

        // Fetch the inserted record to verify
        $query = "SELECT * FROM jobs WHERE title = 'My Test Added Job'";
        $insertedJob = $this->db->getOne($query);

        $this->assertIsArray($insertedJob);
        $this->assertEquals($jobData['description'], $insertedJob['description']);
        $this->assertEquals($jobData['job_category_id'], $insertedJob['job_category_id']);
        $this->assertEquals($jobData['city'], $insertedJob['city']);
        $this->assertEquals($jobData['salary'], $insertedJob['salary']);
    }

    public function testEditJobUpdatesRecordCorrectly(): void
    {
        $jobIdToEdit = 1;
        $updatedData = [
            'title' => 'Updated Job Title',
            'description' => 'This job description has been updated.',
            'job_category_id' => 2,
            'city' => 'New City',
            'employment' => 'Частичная занятость',
            'schedule' => 'Сменный',
            'salary' => '9999',
            'contact_name' => 'New Contact',
            'phone' => '999-9999',
            'posted_date' => '2026-02-02 12:00:00',
            'expires_date' => null
        ];

        $result = modelAdminNews::editJob($jobIdToEdit, $updatedData);
        $this->assertTrue($result);

        // Fetch the updated record to verify
        $updatedJob = Job::getJobByID($jobIdToEdit);
        $this->assertIsArray($updatedJob);
        $this->assertEquals($updatedData['title'], $updatedJob['title']);
        $this->assertEquals($updatedData['description'], $updatedJob['description']);
        $this->assertEquals($updatedData['salary'], $updatedJob['salary']);
        $this->assertEquals($updatedData['city'], $updatedJob['city']);
    }

    public function testDeleteJobRemovesRecordCorrectly(): void
    {
        $jobIdToDelete = 2;

        // First, ensure the record exists
        $originalJob = Job::getJobByID($jobIdToDelete);
        $this->assertIsArray($originalJob);

        // Now, delete the record
        $result = modelAdminNews::deleteJob($jobIdToDelete);
        $this->assertTrue($result);

        // Attempt to fetch the deleted record
        $deletedJob = Job::getJobByID($jobIdToDelete);
        $this->assertFalse($deletedJob);
    }
}
