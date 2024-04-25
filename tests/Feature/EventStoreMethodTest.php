<?php

namespace Tests\Unit;

use App\Http\Controllers\EventController;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EventStoreMethodTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Prueba el método store con datos válidos.
     *
     * @return void
     */
    public function test_store_method_with_valid_data()
    {
        // Datos válidos para crear un evento
        $validData = [
            'id_user' => 1, // ID de un usuario existente en la base de datos, o cualquier otro valor válido para 'user_id
            'name' => 'Evento de Prueba',
            'description' => 'Descripción del Evento de Prueba',
            'assistants_limit' => 100,
            'lat' => 40.7128,
            'lng' => -74.0060,
            'date' => '2024-04-26 12:00:00',
            'role' => 'admin', // O el rol que necesites
        ];

        // Llamar al método store del controlador con datos válidos
        $controller = new EventController();
        $response = $controller->store($this->createRequest($validData));

        // Asegurar que la respuesta sea una redirección o una respuesta exitosa, según la implementación real
        $response->assertRedirect('/'); // O cualquier otra URL de redirección

        // Asegurar que el evento se haya creado correctamente en la base de datos
        $this->assertDatabaseHas('events', [
            'id_user' => 1,
            'name' => 'Evento de Prueba',
            'description' => 'Descripción del Evento de Prueba',
            'assistants_limit' => 100,
            'lat' => 40.7128,
            'lng' => -74.0060,
            'date' => '2024-04-26 12:00:00',
        ]);
    }

    /**
     * Prueba el método store con datos inválidos.
     *
     * @return void
     */
    public function test_store_method_with_invalid_data()
    {
        // Datos inválidos para crear un evento (por ejemplo, falta el campo 'name')
        $invalidData = [
            'id_user' => 1,
            'description' => 'Descripción del Evento de Prueba',
            'assistants_limit' => 100,
            'lat' => 40.7128,
            'lng' => -74.0060,
            'date' => '2024-04-26 12:00:00',
            'role' => 'admin', // O el rol que necesites
        ];

        // Llamar al método store del controlador con datos inválidos
        $controller = new EventController();
        $response = $controller->store($this->createRequest($invalidData));

        // Asegurar que la respuesta sea una redirección o una respuesta de error, según la implementación real
        $response->assertStatus(302); // O cualquier otro código de estado de respuesta

        // Asegurar que el evento no se haya creado en la base de datos
        $this->assertDatabaseMissing('events', [
            'description' => 'Descripción del Evento de Prueba', // Asegurar que no se creó el evento con esta descripción
        ]);
    }

    /**
     * Método auxiliar para crear un objeto de solicitud.
     *
     * @param array $data
     * @return \Illuminate\Http\Request
     */
    private function createRequest($data)
    {
        // Simplemente crea y devuelve una instancia de Request con los datos proporcionados
        return new \Illuminate\Http\Request($data);
    }
}