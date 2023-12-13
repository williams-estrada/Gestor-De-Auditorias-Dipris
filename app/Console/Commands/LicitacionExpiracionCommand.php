<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Licitacion;
use App\Models\Notificacion;

class LicitacionExpiracionCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'licitacion:expiracion';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Proceso de expiracion de licitacion no completadas';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $licitacion =new Licitacion();
        $licitaciones = $licitacion
                            ->where("estado","<>","expirada")
                            ->where("fecha_culminacion","<=",now())
                            ->get();
        $cantidad = count($licitaciones);
        $this->info("Licitaciones a expirar: {$cantidad}");
        foreach($licitaciones as $licitacion) {
            $licitacion->estado ="expirada";
            $notificacion = new Notificacion();
            $notificacion->usuario_id = $licitacion->usuario_id;

            $notificacion->mensaje = "Licitacion {$licitacion->id} Expirada";
            $notificacion->save();
            $licitacion->save();
        }

        return 0;
    }
}
