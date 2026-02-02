<?php declare(strict_types=1);

use PHPUnit\Framework\TestCase;

require_once 'model/Comments.php';

final class CommentValidationTest extends TestCase
{
    public function testValidDataReturnsArray(): void
    {
        $validInput = [
            'text' => 'This is a valid comment.',
            'news_id' => '1',
        ];

        $validatedData = Comments::validateCommentData($validInput);

        $this->assertIsArray($validatedData);
        $this->assertEquals('This is a valid comment.', $validatedData['text']);
        $this->assertEquals('1', $validatedData['news_id']);
    }

    public function testMissingTextReturnsFalse(): void
    {
        $invalidInput = [
            'text' => '',
            'news_id' => '1',
        ];
        $this->assertFalse(Comments::validateCommentData($invalidInput));
    }

    public function testMissingNewsIdReturnsFalse(): void
    {
        $invalidInput = [
            'text' => 'Some comment text.',
            'news_id' => '',
        ];
        $this->assertFalse(Comments::validateCommentData($invalidInput));
    }

    public function testNoDataReturnsFalse(): void
    {
        $this->assertFalse(Comments::validateCommentData([]));
    }

    public function testDataWithWhitespaceInTextFieldIsTrimmed(): void
    {
        $input = [
            'text' => '  A comment with whitespace   ',
            'news_id' => '1',
        ];

        $validatedData = Comments::validateCommentData($input);

        $this->assertIsArray($validatedData);
        $this->assertEquals('A comment with whitespace', $validatedData['text']);
        $this->assertEquals('1', $validatedData['news_id']);
    }
}
