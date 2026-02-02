<?php declare(strict_types=1);

use PHPUnit\Framework\TestCase;

// Include the necessary files for the model and database
require_once 'model/News.php';
require_once 'inc/Database.php';

final class NewsModelIntegrationTest extends TestCase
{
    private $db;

    // This method is called before each test
    protected function setUp(): void
    {
        parent::setUp();

        // 1. Connect to the test database
        $this->db = new Database('localhost', 'root', '', 'test_construct_portal');

        // 2. Inject the test database connection into the models
        require_once 'model/News.php';
        News::setDatabase($this->db);
        require_once 'admin/modelAdmin/modelAdminNews.php';
        modelAdminNews::setDatabase($this->db);


        // 3. Clear and populate the test database
        $this->seedDatabase();
    }

    // This method is called after each test
    protected function tearDown(): void
    {
        parent::tearDown();
        // Clear the database after each test
        $this->clearDatabase();
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

        // Execute the setup script
        try {
            $this->db->executeRun($sql);
        } catch (PDOException $e) {
            $this->fail("Failed to seed test database: " . $e->getMessage());
        }
    }

    private function clearDatabase(): void
    {
        try {
            // Drop tables in reverse order of dependency
            $this->db->executeRun("DROP TABLE IF EXISTS `comments`");
            $this->db->executeRun("DROP TABLE IF EXISTS `news`");
            $this->db->executeRun("DROP TABLE IF EXISTS `jobs`");
            $this->db->executeRun("DROP TABLE IF EXISTS `job_category`");
            $this->db->executeRun("DROP TABLE IF EXISTS `category`");
            $this->db->executeRun("DROP TABLE IF EXISTS `users`");
        } catch (PDOException $e) {
            $this->fail("Failed to clear test database: " . $e->getMessage());
        }
    }


    public function testGetAllNewsReturnsAllNewsOrderedByIdDesc(): void
    {
        $news = News::getAllNews();
        $this->assertIsArray($news);
        // We inserted 10 news items
        $this->assertCount(10, $news);

        // Check if ordering is by id DESC
        $prevId = PHP_INT_MAX;
        foreach ($news as $item) {
            $this->assertLessThanOrEqual($prevId, $item['id']);
            $prevId = $item['id'];
        }
    }

    public function testGetLast5NewsReturnsExactly5NewsOrderedByIdDesc(): void
    {
        $news = News::getLast5News();
        $this->assertIsArray($news);
        $this->assertCount(5, $news);

        // Check if ordering is by id DESC
        $this->assertEquals(10, $news[0]['id']);
        $this->assertEquals(9, $news[1]['id']);
        $this->assertEquals(8, $news[2]['id']);
        $this->assertEquals(7, $news[3]['id']);
        $this->assertEquals(6, $news[4]['id']);
    }

    public function testGetNewsByCategoryIDReturnsCorrectNews(): void
    {
        // category_id=1 has 5 news items in our test data
        $categoryId = 1;
        $news = News::getNewsByCategoryID($categoryId);

        $this->assertIsArray($news);
        $this->assertCount(5, $news);

        foreach ($news as $item) {
            $this->assertEquals($categoryId, $item['category_id']);
        }
    }

    public function testGetNewsByIDReturnsSingleNewsItem(): void
    {
        $newsId = 7;
        $newsItem = News::getNewsByID($newsId);

        $this->assertIsArray($newsItem);
        $this->assertEquals($newsId, $newsItem['id']);
        $this->assertEquals('News 7', $newsItem['title']);
    }

    public function testGetNewsByIDReturnsFalseForNonExistentID(): void
    {
        $newsId = 9999; // Non-existent ID
        $newsItem = News::getNewsByID($newsId);

        $this->assertFalse($newsItem);
    }

    public function testAddNewsInsertsRecordCorrectly(): void
    {
        $newsData = [
            'title' => 'My Test Added News',
            'text' => 'This is the text of the test added news.',
            'idCategory' => 2,
            'video' => 'http://example.com/video',
            'image' => null,
            'user_id' => 1
        ];

        $result = modelAdminNews::addNews($newsData);
        $this->assertTrue($result);

        // Fetch the inserted record to verify
        $query = "SELECT * FROM news WHERE title = 'My Test Added News'";
        $insertedNews = $this->db->getOne($query);

        $this->assertIsArray($insertedNews);
        $this->assertEquals($newsData['text'], $insertedNews['text']);
        $this->assertEquals($newsData['idCategory'], $insertedNews['category_id']);
        $this->assertEquals($newsData['video'], $insertedNews['video']);
    }

    public function testEditNewsUpdatesRecordCorrectly(): void
    {
        $newsIdToEdit = 5;
        $updatedData = [
            'title' => 'Updated News Title',
            'text' => 'This text has been updated.',
            'idCategory' => 2, // Change category from 1 to 2
        ];

        // First, get the original record to ensure it's different
        $originalNews = News::getNewsByID($newsIdToEdit);
        $this->assertEquals('News 5', $originalNews['title']);
        $this->assertEquals(1, $originalNews['category_id']);

        // Now, edit the record
        $result = modelAdminNews::editNews($newsIdToEdit, $updatedData);
        $this->assertTrue($result);

        // Fetch the updated record to verify
        $updatedNews = News::getNewsByID($newsIdToEdit);
        $this->assertIsArray($updatedNews);
        $this->assertEquals($updatedData['title'], $updatedNews['title']);
        $this->assertEquals($updatedData['text'], $updatedNews['text']);
        $this->assertEquals($updatedData['idCategory'], $updatedNews['category_id']);
    }

    public function testDeleteNewsRemovesRecordCorrectly(): void
    {
        $newsIdToDelete = 3;

        // First, ensure the record exists
        $originalNews = News::getNewsByID($newsIdToDelete);
        $this->assertIsArray($originalNews);

        // Now, delete the record
        $result = modelAdminNews::deleteNews($newsIdToDelete);
        $this->assertTrue($result);

        // Attempt to fetch the deleted record
        $deletedNews = News::getNewsByID($newsIdToDelete);
        $this->assertFalse($deletedNews);
    }
}
