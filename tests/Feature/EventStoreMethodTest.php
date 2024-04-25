<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\EventController;
use Illuminate\Foundation\Testing\RefreshDatabase;

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
        // Crear un usuario de prueba y autenticarlo
        $user = User::factory()->create();
        $this->actingAs($user);

        // Datos válidos para crear un evento
        $validData = [
            'name' => 'Evento de Prueba',
            'description' => 'Descripción del Evento de Prueba',
            'assistants_limit' => 100,
            'lat' => 40.7128,
            'lng' => -74.0060,
            'date' => '2024-04-26 12:00:00',
        ];

        // Mockear el objeto Request con datos válidos
        $request = new Request($validData);

        // Llamar al método store del controlador con el Request mockeado
        $controller = new EventController();
        $response = $controller->store($request);

        // Verificar que se haya redirigido a la ruta adecuada después de la creación del evento
        $this->assertEquals(route('events.index'), $response->getTargetUrl());

        // Verificar que el evento se haya creado correctamente en la base de datos
        $this->assertDatabaseHas('events', array_merge($validData, ['creator_id' => $user->id]));
    }

    public function test_store_method_with_missing_fields()
    {
        // Crear un usuario de prueba y autenticarlo
        $user = User::factory()->create();
        $this->actingAs($user);

        // Simular una solicitud con campos faltantes
        $requestData = [
            'name' => 'Evento de Prueba',
            'description' => 'Descripción del Evento de Prueba',
            // Falta el campo 'assistants_limit'
            'lat' => 40.7128,
            'lng' => -74.0060,
            'date' => '2024-04-26 12:00:00',
        ];

        // Mockear el objeto Request con datos de solicitud incompletos
        $request = new Request($requestData);

        // Llamar al método store del controlador con el Request mockeado
        $controller = new EventController();
        $response = $controller->store($request);

        // Verificar que se haya redirigido a la ruta de creación de eventos
        $this->assertEquals(route('events.create'), $response->getTargetUrl());

        // Verificar que se ha establecido un mensaje de error en la sesión
        $this->assertEquals('Por favor, rellena todos los campos.', session('error'));
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
