<?php declare(strict_types=1);

use PHPUnit\Framework\TestCase;

require_once 'model/Register.php';

final class RegistrationValidationTest extends TestCase
{
    public function testValidDataReturnsArray(): void
    {
        $validInput = [
            'name' => 'testuser',
            'email' => 'test@example.com',
            'password' => 'password123',
            'confirm' => 'password123',
        ];

        $validatedData = Register::validateRegistrationData($validInput);

        $this->assertIsArray($validatedData);
        $this->assertEquals('testuser', $validatedData['name']);
        $this->assertEquals('test@example.com', $validatedData['email']);
    }

    public function testMissingNameReturnsFalse(): void
    {
        $invalidInput = [
            'name' => '',
            'email' => 'test@example.com',
            'password' => 'password123',
            'confirm' => 'password123',
        ];
        $this->assertFalse(Register::validateRegistrationData($invalidInput));
    }

    public function testInvalidEmailReturnsFalse(): void
    {
        $invalidInput = [
            'name' => 'testuser',
            'email' => 'invalid-email',
            'password' => 'password123',
            'confirm' => 'password123',
        ];
        $this->assertFalse(Register::validateRegistrationData($invalidInput));
    }

    public function testEmptyPasswordReturnsFalse(): void
    {
        $invalidInput = [
            'name' => 'testuser',
            'email' => 'test@example.com',
            'password' => '',
            'confirm' => '',
        ];
        $this->assertFalse(Register::validateRegistrationData($invalidInput));
    }

    public function testShortPasswordReturnsFalse(): void
    {
        $invalidInput = [
            'name' => 'testuser',
            'email' => 'test@example.com',
            'password' => 'short',
            'confirm' => 'short',
        ];
        $this->assertFalse(Register::validateRegistrationData($invalidInput));
    }

    public function testPasswordsDoNotMatchReturnsFalse(): void
    {
        $invalidInput = [
            'name' => 'testuser',
            'email' => 'test@example.com',
            'password' => 'password123',
            'confirm' => 'differentpassword',
        ];
        $this->assertFalse(Register::validateRegistrationData($invalidInput));
    }

    public function testNoDataReturnsFalse(): void
    {
        $this->assertFalse(Register::validateRegistrationData([]));
    }
}
