<?php declare(strict_types=1);

use PHPUnit\Framework\TestCase;

require_once 'admin/modelAdmin/modelAdminNews.php';

final class JobValidationTest extends TestCase
{
    public function testValidDataReturnsArray(): void
    {
        $validInput = [
            'title' => 'Valid Job Title',
            'description' => 'A detailed description for the valid job.',
            'city' => 'New York',
            'employment' => 'Full-time',
            'schedule' => '9-5',
            'salary' => '100000',
            'contact_name' => 'John Doe',
            'phone' => '123-456-7890',
            'posted_date' => '2024-01-01',
            'expires_date' => '2024-12-31',
            'job_category_id' => '1',
        ];

        $validatedData = modelAdminNews::validateJobData($validInput);

        $this->assertIsArray($validatedData);
        $this->assertEquals('Valid Job Title', $validatedData['title']);
        $this->assertEquals('A detailed description for the valid job.', $validatedData['description']);
        $this->assertEquals('1', $validatedData['job_category_id']);
    }

    public function testMissingTitleReturnsFalse(): void
    {
        $invalidInput = [
            'title' => '',
            'description' => 'Description here.',
            'job_category_id' => '1',
        ];
        $this->assertFalse(modelAdminNews::validateJobData($invalidInput));
    }

    public function testMissingDescriptionReturnsFalse(): void
    {
        $invalidInput = [
            'title' => 'Job Title',
            'description' => '',
            'job_category_id' => '1',
        ];
        $this->assertFalse(modelAdminNews::validateJobData($invalidInput));
    }

    public function testMissingJobCategoryIdReturnsFalse(): void
    {
        $invalidInput = [
            'title' => 'Job Title',
            'description' => 'Description here.',
            'job_category_id' => '',
        ];
        $this->assertFalse(modelAdminNews::validateJobData($invalidInput));
    }

    public function testNoDataReturnsFalse(): void
    {
        $this->assertFalse(modelAdminNews::validateJobData([]));
    }

    public function testDataWithMissingOptionalFieldsReturnsArray(): void
    {
        $input = [
            'title' => 'Job Title',
            'description' => 'Description here.',
            'job_category_id' => '1',
        ];

        $validatedData = modelAdminNews::validateJobData($input);

        $this->assertIsArray($validatedData);
        $this->assertEquals('Job Title', $validatedData['title']);
        $this->assertEquals('Description here.', $validatedData['description']);
        $this->assertEquals('1', $validatedData['job_category_id']);
        $this->assertEquals('', $validatedData['city']); // Expect empty string as per implementation
        $this->assertNull($validatedData['posted_date']); // Expect null as per implementation
    }

    public function testDataWithEmptyOptionalFieldsReturnsArray(): void
    {
        $input = [
            'title' => 'Job Title',
            'description' => 'Description here.',
            'city' => '',
            'employment' => '',
            'schedule' => '',
            'salary' => '',
            'contact_name' => '',
            'phone' => '',
            'posted_date' => '', // This will be treated as an empty string, not null, by ?? null if key exists
            'expires_date' => '', // This will be treated as an empty string, not null, by ?? null if key exists
            'job_category_id' => '1',
        ];

        $validatedData = modelAdminNews::validateJobData($input);

        $this->assertIsArray($validatedData);
        $this->assertEquals('Job Title', $validatedData['title']);
        $this->assertEquals('Description here.', $validatedData['description']);
        $this->assertEquals('1', $validatedData['job_category_id']);
        $this->assertEquals('', $validatedData['city']);
        $this->assertEquals('', $validatedData['employment']);
        $this->assertEquals('', $validatedData['schedule']);
        $this->assertEquals('', $validatedData['salary']);
        $this->assertEquals('', $validatedData['contact_name']);
        $this->assertEquals('', $validatedData['phone']);
        $this->assertEquals('', $validatedData['posted_date']);
        $this->assertEquals('', $validatedData['expires_date']);
    }

    public function testDataWithWhitespaceInFieldsIsTrimmed(): void
    {
        $input = [
            'title' => '  Job Title   ',
            'description' => '   A Description   ',
            'city' => '  City  ',
            'employment' => ' Full-time ',
            'schedule' => ' 9-5 ',
            'salary' => ' 100000 ',
            'contact_name' => ' John Doe ',
            'phone' => ' 123-456-7890 ',
            'posted_date' => '2024-01-01',
            'expires_date' => '2024-12-31',
            'job_category_id' => '1',
        ];

        $validatedData = modelAdminNews::validateJobData($input);

        $this->assertIsArray($validatedData);
        $this->assertEquals('Job Title', $validatedData['title']);
        $this->assertEquals('A Description', $validatedData['description']);
        $this->assertEquals('City', $validatedData['city']);
        $this->assertEquals('Full-time', $validatedData['employment']);
        $this->assertEquals('9-5', $validatedData['schedule']);
        $this->assertEquals('100000', $validatedData['salary']);
        $this->assertEquals('John Doe', $validatedData['contact_name']);
        $this->assertEquals('123-456-7890', $validatedData['phone']);
        $this->assertEquals('2024-01-01', $validatedData['posted_date']);
        $this->assertEquals('2024-12-31', $validatedData['expires_date']);
        $this->assertEquals('1', $validatedData['job_category_id']);
    }
}
