<?php declare(strict_types=1);

use PHPUnit\Framework\TestCase;

// We need to include the class we are testing
require_once 'admin/modelAdmin/modelAdminNews.php';

final class NewsValidationTest extends TestCase
{
    public function testValidDataReturnsArray(): void
    {
        $validInput = [
            'title' => 'A Valid Title',
            'text' => 'Some valid news text.',
            'idCategory' => '1',
            'video' => 'https://example.com/video.mp4',
            'save' => true,
        ];

        $validatedData = modelAdminNews::validateNewsData($validInput);

        $this->assertIsArray($validatedData);
        $this->assertEquals('A Valid Title', $validatedData['title']);
        $this->assertEquals('Some valid news text.', $validatedData['text']);
    }

    public function testMissingTitleReturnsFalse(): void
    {
        $invalidInput = [
            'title' => '', // Empty title
            'text' => 'Some valid news text.',
            'idCategory' => '1',
            'video' => 'https://example.com/video.mp4',
            'save' => true,
        ];

        $this->assertFalse(modelAdminNews::validateNewsData($invalidInput));
    }

    public function testMissingTextReturnsFalse(): void
    {
        $invalidInput = [
            'title' => 'A Valid Title',
            'text' => '', // Empty text
            'idCategory' => '1',
            'video' => 'https://example.com/video.mp4',
            'save' => true,
        ];

        $this->assertFalse(modelAdminNews::validateNewsData($invalidInput));
    }

    public function testNoDataReturnsFalse(): void
    {
        $this->assertFalse(modelAdminNews::validateNewsData([]));
    }

    public function testDataWithMissingOptionalFieldsReturnsArray(): void
    {
        $input = [
            'title' => 'Title with missing optional',
            'text' => 'Text with missing optional.',
            'save' => true,
        ];

        $validatedData = modelAdminNews::validateNewsData($input);

        $this->assertIsArray($validatedData);
        $this->assertEquals('Title with missing optional', $validatedData['title']);
        $this->assertEquals('Text with missing optional.', $validatedData['text']);
        $this->assertNull($validatedData['idCategory']);
        $this->assertNull($validatedData['video']);
    }

    public function testDataWithEmptyOptionalFieldsReturnsArray(): void
    {
        $input = [
            'title' => 'Title with empty optional',
            'text' => 'Text with empty optional.',
            'idCategory' => '',
            'video' => '',
            'save' => true,
        ];

        $validatedData = modelAdminNews::validateNewsData($input);

        $this->assertIsArray($validatedData);
        $this->assertEquals('Title with empty optional', $validatedData['title']);
        $this->assertEquals('Text with empty optional.', $validatedData['text']);
        $this->assertEquals('', $validatedData['idCategory']); // Expect empty string, not null
        $this->assertEquals('', $validatedData['video']);       // Expect empty string, not null
    }

    public function testDataWithWhitespaceInFieldsIsTrimmed(): void
    {
        $input = [
            'title' => '  Trimmed Title   ',
            'text' => '   Trimmed Text    ',
            'idCategory' => '1',
            'video' => 'https://example.com/video.mp4',
            'save' => true,
        ];

        $validatedData = modelAdminNews::validateNewsData($input);

        $this->assertIsArray($validatedData);
        $this->assertEquals('Trimmed Title', $validatedData['title']);
        $this->assertEquals('Trimmed Text', $validatedData['text']);
    }
}
