<?php

namespace Tests\Unit;

use App\Http\Controllers\UserController;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class UserStoreMethodTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test store method with valid data.
     *
     * @return void
     */
    public function test_store_method_with_valid_data()
    {
        $controller = new UserController();

        // Datos válidos para crear un usuario
        $requestData = [
            'name' => 'John',
            'surname' => 'Doe',
            'dni' => '12345678Z', // DNI válido
            'email' => 'john@example.com', // Email válido
            'pass' => 'password',
            'pass_check' => 'password',
        ];

        // Llamada al método store con datos válidos
        $response = $controller->store($this->createRequest($requestData));

        // Verificación de que el usuario se ha creado correctamente
        $this->assertDatabaseHas('users', [
            'name' => 'John',
            'surname' => 'Doe',
            'dni' => '12345678Z',
            'email' => 'john@example.com',
        ]);
    }

    /**
     * Test store method with invalid data.
     *
     * @return void
     */
    public function test_store_method_with_invalid_data()
    {
        $controller = new UserController();

        // Datos inválidos para crear un usuario (contraseñas no coinciden)
        $requestData = [
            'name' => 'John',
            'surname' => 'Doe',
            'dni' => '12345678Z', // DNI válido
            'email' => 'john@example.com', // Email válido
            'pass' => 'password',
            'pass_check' => 'wrongpassword', // Contraseña incorrecta
        ];

        // Llamada al método store con datos inválidos
        $response = $controller->store($this->createRequest($requestData));

        // Verificación de que el usuario no se ha creado
        $this->assertDatabaseMissing('users', [
            'name' => 'John',
            'surname' => 'Doe',
            'dni' => '12345678Z',
            'email' => 'john@example.com',
        ]);
    }

    /**
     * Helper method to create request object.
     *
     * @param array $data
     * @return \Illuminate\Http\Request
     */
    private function createRequest($data)
    {
        // Simplemente se crea y devuelve una instancia de Request con los datos proporcionados
        return new \Illuminate\Http\Request($data);
    }
}