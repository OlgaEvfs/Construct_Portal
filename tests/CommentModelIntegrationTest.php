<?php declare(strict_types=1);

use PHPUnit\Framework\TestCase;

require_once 'model/Comments.php';
require_once 'inc/Database.php';

final class CommentModelIntegrationTest extends TestCase
{
    private $db;

    protected function setUp(): void
    {
        parent::setUp();

        // 1. Connect to the test database
        $this->db = new Database('localhost', 'root', '', 'test_construct_portal');

        // 2. Inject the test database connection into the models
        Comments::setDatabase($this->db);
        // Also setting for other models as the setup script creates their tables too
        require_once 'model/News.php';
        News::setDatabase($this->db);
        require_once 'model/Job.php';
        Job::setDatabase($this->db);

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

    public function testGetCommentByNewsID(): void
    {
        // News ID 1 has 2 comments in test data
        $newsId = 1;
        $comments = Comments::getCommentByNewsID($newsId);
        $this->assertIsArray($comments);
        $this->assertCount(2, $comments);
        $this->assertEquals('Comment 2 for news 1', $comments[0]['text']); // Ordered by ID DESC
        $this->assertEquals('Comment 1 for news 1', $comments[1]['text']);

        // News ID 2 has 1 comment
        $newsId = 2;
        $comments = Comments::getCommentByNewsID($newsId);
        $this->assertIsArray($comments);
        $this->assertCount(1, $comments);

        // News ID 3 has 0 comments
        $newsId = 3;
        $comments = Comments::getCommentByNewsID($newsId);
        $this->assertIsArray($comments);
        $this->assertCount(0, $comments);
    }

    public function testGetCommentsCountByNewsID(): void
    {
        // News ID 1 has 2 comments
        $newsId = 1;
        $result = Comments::getCommentsCountByNewsID($newsId);
        $this->assertEquals(2, $result['count']);

        // News ID 2 has 1 comment
        $newsId = 2;
        $result = Comments::getCommentsCountByNewsID($newsId);
        $this->assertEquals(1, $result['count']);

        // News ID 3 has 0 comments
        $newsId = 3;
        $result = Comments::getCommentsCountByNewsID($newsId);
        $this->assertEquals(0, $result['count']);
    }

    public function testInsertComment(): void
    {
        $newsId = 4;
        $commentText = 'A brand new comment!';

        // Before insert, count should be 0
        $result = Comments::getCommentsCountByNewsID($newsId);
        $this->assertEquals(0, $result['count']);

        // Insert the comment
        $insertResult = Comments::insertComment($commentText, $newsId);
        $this->assertTrue($insertResult !== false);

        // After insert, count should be 1
        $result = Comments::getCommentsCountByNewsID($newsId);
        $this->assertEquals(1, $result['count']);

        // Check the content of the inserted comment
        $comments = Comments::getCommentByNewsID($newsId);
        $this->assertEquals($commentText, $comments[0]['text']);
    }
}
