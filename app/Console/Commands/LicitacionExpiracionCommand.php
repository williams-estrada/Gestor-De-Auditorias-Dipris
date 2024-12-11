<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Licitacion;
use App\Models\Notificacion;
use App\Models\Message;
use App\Models\Usuarios;
use App\Events\MessageEvent;

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
                            ->where("estado","pendiente")
                            ->where("fecha_culminacion","<=",now())
                            ->get();
        $cantidad = count($licitaciones);

        $usuario = Usuarios::Where('tipo_usuario', 'Administrador')->first();

        $this->info("Licitaciones a expirar: {$cantidad}");
        foreach($licitaciones as $licitacion) {
            $licitacion->estado ="expirada";

            $mensaje_nuevo = new Message();
            $mensaje_nuevo->titulo = "Licitacion Folio No. {$licitacion->folio} Expirada";
            $mensaje_nuevo->contenido = "Licitacion Folio No. {$licitacion->folio} Expirada";
            $mensaje_nuevo->user_id = $licitacion->usuario_id;
            $mensaje_nuevo->to_user_id = $usuario->id;
            
            $mensaje_nuevo->save();
            event(new MessageEvent($mensaje_nuevo));


            $licitacion->save();
        }

        return 0;
    }
}
