<?php

namespace Tests\Unit;

use App\Http\Controllers\UserController;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Validator;
use Tests\TestCase;

class ValidationTest extends TestCase
{
    /**
     * Test validarDNI method with valid DNI.
     *
     * @return void
     */
    public function test_validarDNI_with_valid_dni()
    {
        $controller = new UserController();

        // Valid DNI: 12345678Z
        $result = $controller->validarDNI('12345678Z');

        $this->assertTrue($result);
    }

    /**
     * Test validarDNI method with invalid DNI.
     *
     * @return void
     */
    public function test_validarDNI_with_invalid_dni()
    {
        $controller = new UserController();

        // Invalid DNI: 1234567A
        $result = $controller->validarDNI('1234567A');

        $this->assertFalse($result);
    }

    /**
     * Test validarEmail method with valid email.
     *
     * @return void
     */
    public function test_validarEmail_with_valid_email()
    {
        $controller = new UserController();

        // Valid email
        $result = $controller->validarEmail('user@example.com');

        $this->assertTrue($result);
    }

    /**
     * Test validarEmail method with invalid email.
     *
     * @return void
     */
    public function test_validarEmail_with_invalid_email()
    {
        $controller = new UserController();

        // Invalid email
        $result = $controller->validarEmail('invalid_email');

        $this->assertFalse($result);
    }
}