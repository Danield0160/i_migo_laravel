<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Event;
use Carbon\Carbon;

class UpdateEventsCommand extends Command
{
    protected $signature = 'events:update';
    protected $description = 'Actualiza los eventos cada 30 minutos';

    public function handle()
    {
        // Buscar eventos activos con date menor que la actual
        $events = Event::where('date', '<', Carbon::now())
                        ->get();

        // Desactivar los eventos encontrados
        foreach ($events as $event) {
            $event->delete();
        }

        $this->info('Events updated successfully.');
    }
}