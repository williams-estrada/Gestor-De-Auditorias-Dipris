<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Licitacion;
use App\Models\Documentos;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
//use Illuminate\Foundation\Application;

class DocumentosController extends Controller
{
    public function adjuntar(String $id){
        //dump($id);
        //$id = 1;
        $data = Licitacion::find($id);
        $porcentaje = 0;

        $documentos = collect([
            ['nombre' => 'Documentos a integrar', 'vista' => 'documento1'],
            ['nombre' => 'Contratacion de personal', 'vista' => 'documento2'],
            ['nombre' => 'Compras menores', 'vista' => 'documento3'],
            ['nombre' => 'Invitacion restringida', 'vista' => 'documento4'],
            ['nombre' => 'Adjudicacion directa', 'vista' => 'documento5'],
            ['nombre' => 'Licitacion publica', 'vista' => 'documento6'],
        ]);
        
        $obtenerVista = $documentos->where('nombre',$data->area)->pluck('vista');

        if($obtenerVista[0] == 'documento1'){
            $cantidad_aplica = Documentos::where("licitacion_id","=",$id)
                        ->where("aplica","=","si")
                        ->count();
            $documento1 = Documentos::where("licitacion_id","=",$id)
                        ->where("aplica","=","si")
                        ->get();
                        
            $progreso = Documentos::where("licitacion_id","=",$id)
                        ->whereRaw("LENGTH(ruta_documento) != 0")
                        ->count();
            if($cantidad_aplica > 0){
                $limitar_porcentaje = (100/$cantidad_aplica)*$progreso;
                $porcentaje  = bcdiv($limitar_porcentaje, '1', 1);
            }
            
            return view("Program.Documentos.documento1",compact('documento1','porcentaje'));
        }
        if($obtenerVista[0] == 'documento2'){
            $cantidad_aplica = Documentos::where("licitacion_id","=",$id)
                        ->where("aplica","=","si")
                        ->count();
            $resultado1 = Documentos::where('licitacion_id','=',$id)
                                ->where('categoria', '=','EJERCICIO (RECURSOS HUMANOS)')
                                ->where("aplica","=","si")
                                ->get();
            $resultado2 = Documentos::where('licitacion_id','=',$id)
                                ->where('categoria', '=','SEGUIMIENTO')
                                ->where("aplica","=","si")
                                ->get();
            $resultado3 = Documentos::where('licitacion_id','=',$id)
                                ->where('categoria', '=','RENDICION DE LA CUENTA PUBLICA')
                                ->where("aplica","=","si")
                                ->get();
            $progreso = Documentos::where("licitacion_id","=",$id)
                                ->whereRaw("LENGTH(ruta_documento) != 0")
                                ->count();
            
            if($cantidad_aplica > 0){
                $limitar_porcentaje = (100/$cantidad_aplica)*$progreso;
                $porcentaje  = bcdiv($limitar_porcentaje, '1', 1);
            }
            $porcentaje = "302";
            return view("Program.Documentos.documento2",compact('resultado1','resultado2','resultado3','porcentaje'));
        }
        if($obtenerVista[0] == 'documento3'){
            $cantidad_aplica = Documentos::where("licitacion_id","=",$id)
                        ->where("aplica","=","si")
                        ->count();
            $resultado1 = Documentos::where('licitacion_id','=',$id)
                                ->where('categoria', '=','SOLICITUD DE ADQUISICIÓN')
                                ->where("aplica","=","si")
                                ->get();
            $resultado2 = Documentos::where('licitacion_id','=',$id)
                                ->where('categoria', '=','RECEPCIÓN DE INSUMOS MEDICOS, ADMINISTRATIVOS Y ACTIVOS FIJOS')
                                ->where("aplica","=","si")
                                ->get();
            $resultado3 = Documentos::where('licitacion_id','=',$id)
                                ->where('categoria', '=','TRÁMITE DE PAGO')
                                ->where("aplica","=","si")
                                ->get();
            $resultado4 = Documentos::where('licitacion_id','=',$id)
                                ->where('categoria', '=','SEGUIMIENTO')
                                ->where("aplica","=","si")
                                ->get();
            $resultado5 = Documentos::where('licitacion_id','=',$id)
                                ->where('categoria', '=','RENDICIÓN DE LA CUENTA PÚBLICA')
                                ->where("aplica","=","si")
                                ->get();
            $progreso = Documentos::where("licitacion_id","=",$id)
                                ->whereRaw("LENGTH(ruta_documento) != 0")
                                ->count();
            
            if($cantidad_aplica > 0){
                $limitar_porcentaje = (100/$cantidad_aplica)*$progreso;
                $porcentaje  = bcdiv($limitar_porcentaje, '1', 1);
            }
            $porcentaje = "303";
            return view("Program.Documentos.documento3",compact('resultado1','resultado2','resultado3','resultado4','resultado5','porcentaje'));
        }
        if($obtenerVista[0] == 'documento4'){
            $cantidad_aplica = Documentos::where("licitacion_id","=",$id)
                        ->where("aplica","=","si")
                        ->count();
            $resultado1 = Documentos::where('licitacion_id','=',$id)
                                ->where('categoria', '=','SOLICITUD DE ADQUISICIÓN')
                                ->where("aplica","=","si")
                                ->get();
            $resultado2 = Documentos::where('licitacion_id','=',$id)
                                ->where('categoria', '=','ADQUISICIONES DE BIENES Y SERVICIOS MEDIANTE INVITACIÓN A CUANDO MENOS TRES PERSONAS:')
                                ->where("aplica","=","si")
                                ->get();
            $resultado3 = Documentos::where('licitacion_id','=',$id)
                                ->where('categoria', '=','RECEPCIÓN DE INSUMOS MEDICOS, ADMINISTRATIVOS Y ACTIVOS FIJOS')
                                ->where("aplica","=","si")
                                ->get();
            $resultado4 = Documentos::where('licitacion_id','=',$id)
                                ->where('categoria', '=','TRÁMITE DE PAGO')
                                ->where("aplica","=","si")
                                ->get();
            $resultado5 = Documentos::where('licitacion_id','=',$id)
                                ->where('categoria', '=','GENERALIDADES EN EL CASO DE PENALIZACIONES AL PROVEDOR')
                                ->where("aplica","=","si")
                                ->get();
            $resultado6 = Documentos::where('licitacion_id','=',$id)
                                ->where('categoria', '=','SEGUIMIENTO')
                                ->where("aplica","=","si")
                                ->get();
            $resultado7 = Documentos::where('licitacion_id','=',$id)
                                ->where('categoria', '=','RENDICIÓN DE LA CUENTA PÚBLICA')
                                ->where("aplica","=","si")
                                ->get();
            $progreso = Documentos::where("licitacion_id","=",$id)
                                ->whereRaw("LENGTH(ruta_documento) != 0")
                                ->count();
            
            if($cantidad_aplica > 0){
                $limitar_porcentaje = (100/$cantidad_aplica)*$progreso;
                $porcentaje  = bcdiv($limitar_porcentaje, '1', 1);
            }
            $porcentaje = "304";
            return view("Program.Documentos.documento4",compact('resultado1','resultado2','resultado3','resultado4','resultado5','resultado6','resultado7','porcentaje'));
        }
        if($obtenerVista[0] == 'documento5'){
            $cantidad_aplica = Documentos::where("licitacion_id","=",$id)
                        ->where("aplica","=","si")
                        ->count();
            $resultado1 = Documentos::where('licitacion_id','=',$id)
                                ->where('categoria', '=','SOLICITUD DE ADQUISICIÓN')
                                ->where("aplica","=","si")
                                ->get();
            $resultado2 = Documentos::where('licitacion_id','=',$id)
                                ->where('categoria', '=','PROCESO DE COMPRA')
                                ->where("aplica","=","si")
                                ->get();
            $resultado3 = Documentos::where('licitacion_id','=',$id)
                                ->where('categoria', '=','RECEPCIÓN DE INSUMOS MEDICOS, ADMINISTRATIVOS Y ACTIVOS FIJOS')
                                ->where("aplica","=","si")
                                ->get();
            $resultado4 = Documentos::where('licitacion_id','=',$id)
                                ->where('categoria', '=','TRÁMITE DE PAGO')
                                ->where("aplica","=","si")
                                ->get();
            $resultado5 = Documentos::where('licitacion_id','=',$id)
                                ->where('categoria', '=','GENERALIDADES EN EL CASO DE PENALIZACIONES AL PROVEDOR')
                                ->where("aplica","=","si")
                                ->get();
            $resultado6 = Documentos::where('licitacion_id','=',$id)
                                ->where('categoria', '=','SEGUIMIENTO')
                                ->where("aplica","=","si")
                                ->get();
            $resultado7 = Documentos::where('licitacion_id','=',$id)
                                ->where('categoria', '=','RENDICIÓN DE LA CUENTA PÚBLICA')
                                ->where("aplica","=","si")
                                ->get();
            $progreso = Documentos::where("licitacion_id","=",$id)
                                ->whereRaw("LENGTH(ruta_documento) != 0")
                                ->count();
            
            if($cantidad_aplica > 0){
                $limitar_porcentaje = (100/$cantidad_aplica)*$progreso;
                $porcentaje  = bcdiv($limitar_porcentaje, '1', 1);
            }
            $porcentaje = "305";
            return view("Program.Documentos.documento5",compact('resultado1','resultado2','resultado3','resultado4','resultado5','resultado6','resultado7','porcentaje'));
        }
        if($obtenerVista[0] == 'documento6'){
            $cantidad_aplica = Documentos::where("licitacion_id","=",$id)
                        ->where("aplica","=","si")
                        ->count();
            $resultado1 = Documentos::where('licitacion_id','=',$id)
                                ->where('categoria', '=','SOLICITUD DE ADQUISICIÓN')
                                ->where("aplica","=","si")
                                ->get();
            $resultado2 = Documentos::where('licitacion_id','=',$id)
                                ->where('categoria', '=','ADQUISICIONES DE BIENES Y SERVICIOS MEDIANTE LICITACIÓN PÚBLICA:')
                                ->where("aplica","=","si")
                                ->get();
            $resultado3 = Documentos::where('licitacion_id','=',$id)
                                ->where('categoria', '=','RECEPCIÓN DE INSUMOS MEDICOS, ADMINISTRATIVOS Y ACTIVOS FIJOS')
                                ->where("aplica","=","si")
                                ->get();
            $resultado4 = Documentos::where('licitacion_id','=',$id)
                                ->where('categoria', '=','TRÁMITE DE PAGO')
                                ->where("aplica","=","si")
                                ->get();
            $resultado5 = Documentos::where('licitacion_id','=',$id)
                                ->where('categoria', '=','GENERALIDADES EN EL CASO DE PENALIZACIONES AL PROVEDOR:')
                                ->where("aplica","=","si")
                                ->get();
            $resultado6 = Documentos::where('licitacion_id','=',$id)
                                ->where('categoria', '=','SEGUIMIENTO')
                                ->where("aplica","=","si")
                                ->get();
            $resultado7 = Documentos::where('licitacion_id','=',$id)
                                ->where('categoria', '=','RENDICIÓN DE LA CUENTA PÚBLICA')
                                ->where("aplica","=","si")
                                ->get();
            $progreso = Documentos::where("licitacion_id","=",$id)
                                ->whereRaw("LENGTH(ruta_documento) != 0")
                                ->count();
            
            if($cantidad_aplica > 0){
                $limitar_porcentaje = (100/$cantidad_aplica)*$progreso;
                $porcentaje  = bcdiv($limitar_porcentaje, '1', 1);
            }
            $porcentaje = "306";
            return view("Program.Documentos.documento6",compact('resultado1','resultado2','resultado3','resultado4','resultado5','resultado6','resultado7','porcentaje'));
        }
    }

    public function create(string $id){
        $data = Licitacion::find($id);

        $docs_encontrados = Documentos::where("licitacion_id", $id)->get();

        $count_aplica = 0;
        if($docs_encontrados->count() > 0){
            foreach($docs_encontrados as $item){
                if($item->aplica == "si")
                    $count_aplica++;
            }
            if($count_aplica == 0)
                return back();
        }
            

        $devolver = false;
        $documentos = collect([
            ['nombre' => 'Documentos a integrar', 'vista' => 'documento1'],
            ['nombre' => 'Contratacion de personal', 'vista' => 'documento2'],
            ['nombre' => 'Compras menores', 'vista' => 'documento3'],
            ['nombre' => 'Invitacion restringida', 'vista' => 'documento4'],
            ['nombre' => 'Adjudicacion directa', 'vista' => 'documento5'],
            ['nombre' => 'Licitacion publica', 'vista' => 'documento6'],
        ]);

        $obtenerVista = $documentos->where('nombre',$data->area)->pluck('vista');

        if($obtenerVista[0] == 'documento1'){
            $cantidad_aplica = Documentos::where("licitacion_id","=",$id)
                        ->where("aplica","=","si")
                        ->count();
            $documento1 = Documentos::where("licitacion_id","=",$id)
                        ->where("aplica","=","si")
                        ->get();
            $progreso = Documentos::where("licitacion_id","=",$id)
                        ->whereRaw("LENGTH(ruta_documento) != 0")
                        ->count();

            $licitacion = Licitacion::find($id);

            //dump($licitacion);
            if($licitacion->cantidad_aplica > 0){
                $limitar_porcentaje = (100/$licitacion->cantidad_aplica) * $licitacion->progreso_aplica;
            }
                        
           
            else {
                $limitar_porcentaje = 0; // For example, setting it to 0 here.
            }
            $porcentaje  = bcdiv($limitar_porcentaje, '1', 1);
            session(["porcentaje" => $porcentaje]);
            return view("Program.Documentos.documento1",compact('documento1','porcentaje', 'devolver'));
        }
        if($obtenerVista[0] == 'documento2'){
            $cantidad_aplica = Documentos::where("licitacion_id","=",$id)
                        ->where("aplica","=","si")
                        ->count();
            $resultado1 = Documentos::where('licitacion_id','=',$id)
                                ->where('categoria', '=','EJERCICIO (RECURSOS HUMANOS)')
                                ->where("aplica","=","si")
                                ->get();
            $resultado2 = Documentos::where('licitacion_id','=',$id)
                                ->where('categoria', '=','SEGUIMIENTO')
                                ->where("aplica","=","si")
                                ->get();
            $resultado3 = Documentos::where('licitacion_id','=',$id)
                                ->where('categoria', '=','RENDICION DE LA CUENTA PUBLICA')
                                ->where("aplica","=","si")
                                ->get();
            $progreso = Documentos::where("licitacion_id","=",$id)
                                ->whereRaw("LENGTH(ruta_documento) != 0")
                                ->count();

            $licitacion = Licitacion::find($id);

            if($licitacion->cantidad_aplica > 0){
                $limitar_porcentaje = (100/$licitacion->cantidad_aplica) * $licitacion->progreso_aplica;
            }
                        
            
            else {
                $limitar_porcentaje = 0; // For example, setting it to 0 here.
            }
            $porcentaje  = bcdiv($limitar_porcentaje, '1', 1);
            session(["porcentaje" => $porcentaje]);
            return view("Program.Documentos.documento2",compact('resultado1','resultado2','resultado3','porcentaje', 'devolver'));
        }
        if($obtenerVista[0] == 'documento3'){
            $cantidad_aplica = Documentos::where("licitacion_id","=",$id)
                        ->where("aplica","=","si")
                        ->count();
            $resultado1 = Documentos::where('licitacion_id','=',$id)
                                ->where('categoria', '=','SOLICITUD DE ADQUISICIÓN')
                                ->where("aplica","=","si")
                                ->get();
            $resultado2 = Documentos::where('licitacion_id','=',$id)
                                ->where('categoria', '=','RECEPCIÓN DE INSUMOS MEDICOS, ADMINISTRATIVOS Y ACTIVOS FIJOS')
                                ->where("aplica","=","si")
                                ->get();
            $resultado3 = Documentos::where('licitacion_id','=',$id)
                                ->where('categoria', '=','TRÁMITE DE PAGO')
                                ->where("aplica","=","si")
                                ->get();
            $resultado4 = Documentos::where('licitacion_id','=',$id)
                                ->where('categoria', '=','SEGUIMIENTO')
                                ->where("aplica","=","si")
                                ->get();
            $resultado5 = Documentos::where('licitacion_id','=',$id)
                                ->where('categoria', '=','RENDICIÓN DE LA CUENTA PÚBLICA')
                                ->where("aplica","=","si")
                                ->get();
            $progreso = Documentos::where("licitacion_id","=",$id)
                                ->whereRaw("LENGTH(ruta_documento) != 0")
                                ->count();
            
            $licitacion = Licitacion::find($id);

            if($licitacion->cantidad_aplica > 0){
                $limitar_porcentaje = (100/$licitacion->cantidad_aplica) * $licitacion->progreso_aplica;
            }
                        
            
            else {
                $limitar_porcentaje = 0; // For example, setting it to 0 here.
            }
            $porcentaje  = bcdiv($limitar_porcentaje, '1', 1);
            session(["porcentaje" => $porcentaje]);
            return view("Program.Documentos.documento3",compact('resultado1','resultado2','resultado3','resultado4','resultado5','porcentaje', 'devolver'));
        }
        if($obtenerVista[0] == 'documento4'){
            $cantidad_aplica = Documentos::where("licitacion_id","=",$id)
                        ->where("aplica","=","si")
                        ->count();
            $resultado1 = Documentos::where('licitacion_id','=',$id)
                                ->where('categoria', '=','SOLICITUD DE ADQUISICIÓN')
                                ->where("aplica","=","si")
                                ->get();
            $resultado2 = Documentos::where('licitacion_id','=',$id)
                                ->where('categoria', '=','ADQUISICIONES DE BIENES Y SERVICIOS MEDIANTE INVITACIÓN A CUANDO MENOS TRES PERSONAS:')
                                ->where("aplica","=","si")
                                ->get();
            $resultado3 = Documentos::where('licitacion_id','=',$id)
                                ->where('categoria', '=','RECEPCIÓN DE INSUMOS MEDICOS, ADMINISTRATIVOS Y ACTIVOS FIJOS')
                                ->where("aplica","=","si")
                                ->get();
            $resultado4 = Documentos::where('licitacion_id','=',$id)
                                ->where('categoria', '=','TRÁMITE DE PAGO')
                                ->where("aplica","=","si")
                                ->get();
            $resultado5 = Documentos::where('licitacion_id','=',$id)
                                ->where('categoria', '=','GENERALIDADES EN EL CASO DE PENALIZACIONES AL PROVEDOR')
                                ->where("aplica","=","si")
                                ->get();
            $resultado6 = Documentos::where('licitacion_id','=',$id)
                                ->where('categoria', '=','SEGUIMIENTO')
                                ->where("aplica","=","si")
                                ->get();
            $resultado7 = Documentos::where('licitacion_id','=',$id)
                                ->where('categoria', '=','RENDICIÓN DE LA CUENTA PÚBLICA')
                                ->where("aplica","=","si")
                                ->get();
            $progreso = Documentos::where("licitacion_id","=",$id)
                                ->whereRaw("LENGTH(ruta_documento) != 0")
                                ->count();
            
            $licitacion = Licitacion::find($id);

            
            if($licitacion->cantidad_aplica > 0){
                $limitar_porcentaje = (100/$licitacion->cantidad_aplica) * $licitacion->progreso_aplica;
            }
                        
            
            else {
                $limitar_porcentaje = 0; // For example, setting it to 0 here.
            }
            $porcentaje  = bcdiv($limitar_porcentaje, '1', 1);
            session(["porcentaje" => $porcentaje]);
            return view("Program.Documentos.documento4",compact('resultado1','resultado2','resultado3','resultado4','resultado5','resultado6','resultado7','porcentaje', 'devolver'));
        }
        if($obtenerVista[0] == 'documento5'){
            $cantidad_aplica = Documentos::where("licitacion_id","=",$id)
                        ->where("aplica","=","si")
                        ->count();
            $resultado1 = Documentos::where('licitacion_id','=',$id)
                                ->where('categoria', '=','SOLICITUD DE ADQUISICIÓN')
                                ->where("aplica","=","si")
                                ->get();
            $resultado2 = Documentos::where('licitacion_id','=',$id)
                                ->where('categoria', '=','PROCESO DE COMPRA')
                                ->where("aplica","=","si")
                                ->get();
            $resultado3 = Documentos::where('licitacion_id','=',$id)
                                ->where('categoria', '=','RECEPCIÓN DE INSUMOS MEDICOS, ADMINISTRATIVOS Y ACTIVOS FIJOS')
                                ->where("aplica","=","si")
                                ->get();
            $resultado4 = Documentos::where('licitacion_id','=',$id)
                                ->where('categoria', '=','TRÁMITE DE PAGO')
                                ->where("aplica","=","si")
                                ->get();
            $resultado5 = Documentos::where('licitacion_id','=',$id)
                                ->where('categoria', '=','GENERALIDADES EN EL CASO DE PENALIZACIONES AL PROVEDOR')
                                ->where("aplica","=","si")
                                ->get();
            $resultado6 = Documentos::where('licitacion_id','=',$id)
                                ->where('categoria', '=','SEGUIMIENTO')
                                ->where("aplica","=","si")
                                ->get();
            $resultado7 = Documentos::where('licitacion_id','=',$id)
                                ->where('categoria', '=','RENDICIÓN DE LA CUENTA PÚBLICA')
                                ->where("aplica","=","si")
                                ->get();
            $progreso = Documentos::where("licitacion_id","=",$id)
                                ->whereRaw("LENGTH(ruta_documento) != 0")
                                ->count();
            
            $licitacion = Licitacion::find($id);

            if($licitacion->cantidad_aplica > 0){
                $limitar_porcentaje = (100/$licitacion->cantidad_aplica) * $licitacion->progreso_aplica;
            }
                        
            
            else {
                $limitar_porcentaje = 0; // For example, setting it to 0 here.
            }
            $porcentaje  = bcdiv($limitar_porcentaje, '1', 1);
            session(["porcentaje" => $porcentaje]);

            return view("Program.Documentos.documento5",compact('resultado1','resultado2','resultado3','resultado4','resultado5','resultado6','resultado7','porcentaje', 'devolver'));
        }
        if($obtenerVista[0] == 'documento6'){
            $cantidad_aplica = Documentos::where("licitacion_id","=",$id)
                        ->where("aplica","=","si")
                        ->count();
            $resultado1 = Documentos::where('licitacion_id','=',$id)
                                ->where('categoria', '=','SOLICITUD DE ADQUISICIÓN')
                                ->where("aplica","=","si")
                                ->get();
            $resultado2 = Documentos::where('licitacion_id','=',$id)
                                ->where('categoria', '=','ADQUISICIONES DE BIENES Y SERVICIOS MEDIANTE LICITACIÓN PÚBLICA:')
                                ->where("aplica","=","si")
                                ->get();
            $resultado3 = Documentos::where('licitacion_id','=',$id)
                                ->where('categoria', '=','RECEPCIÓN DE INSUMOS MEDICOS, ADMINISTRATIVOS Y ACTIVOS FIJOS')
                                ->where("aplica","=","si")
                                ->get();
            $resultado4 = Documentos::where('licitacion_id','=',$id)
                                ->where('categoria', '=','TRÁMITE DE PAGO')
                                ->where("aplica","=","si")
                                ->get();
            $resultado5 = Documentos::where('licitacion_id','=',$id)
                                ->where('categoria', '=','GENERALIDADES EN EL CASO DE PENALIZACIONES AL PROVEDOR:')
                                ->where("aplica","=","si")
                                ->get();
            $resultado6 = Documentos::where('licitacion_id','=',$id)
                                ->where('categoria', '=','SEGUIMIENTO')
                                ->where("aplica","=","si")
                                ->get();
            $resultado7 = Documentos::where('licitacion_id','=',$id)
                                ->where('categoria', '=','RENDICIÓN DE LA CUENTA PÚBLICA')
                                ->where("aplica","=","si")
                                ->get();
            $progreso = Documentos::where("licitacion_id","=",$id)
                                ->whereRaw("LENGTH(ruta_documento) != 0")
                                ->count();
            
            $licitacion = Licitacion::find($id);

            if($licitacion->cantidad_aplica > 0){
                $limitar_porcentaje = (100/$licitacion->cantidad_aplica) * $licitacion->progreso_aplica;
            } else {
                $limitar_porcentaje = 0; // For example, setting it to 0 here.
            }
            $porcentaje  = bcdiv($limitar_porcentaje, '1', 1);
            session(["porcentaje" => $porcentaje]);
            return view("Program.Documentos.documento6",compact('resultado1','resultado2','resultado3','resultado4','resultado5','resultado6','resultado7','porcentaje', 'devolver'));
        }
    }

    public function store (Request $request, string $id){
        
        if($request->devolver == "1"){
            $documento_encontrado = Documentos::find($id);
            $documento_eliminar = $documento_encontrado->ruta_documento;
            Storage::delete($documento_eliminar);

            $documento_encontrado->informacion_estado = "";
            $documento_encontrado->ruta_documento = "";
            $documento_encontrado->habilitado = 1;
            if($request->post('comentario') == null){
                $documento_encontrado->comentario = "";
            }
            else{
                $documento_encontrado->comentario = $request->post('comentario');//
            }
            $documento_encontrado->update();

            $licitacion_encontrada = Licitacion::find($documento_encontrado->licitacion_id);
            $cantidad = intval($licitacion_encontrada->progreso_aplica)-1;
            $licitacion_encontrada->progreso_aplica = $cantidad;

            $licitacion_encontrada->update();

            $id = $documento_encontrado->licitacion_id;

            $previa_porcentaje = (100/$licitacion_encontrada->cantidad_aplica)*$licitacion_encontrada->progreso_aplica;
            $porcentaje  = bcdiv($previa_porcentaje, '1', 1);

            
            session(["porcentaje" => $porcentaje]);
            

            return back();
        }
        else if($request->devolver == "0"){
            $documento_encontrado = Documentos::find($id);
            
            //Tratamiento del documento ------------------------------------------------
            $documento_nombre = $request->file('documento');
            if($request->informacion_estado == "si"){
                if(is_null($documento_nombre)){
                    return back();
                }
            }


            if(!is_null($documento_nombre)){
                if($request->informacion_estado == "no"){
                    return back();
                }

                $nombre_original = $documento_nombre->getClientOriginalName();
                $nombre_sin_extencion = pathinfo($nombre_original,PATHINFO_FILENAME);
                $timestamp = now()->timestamp;
                $nombre_completo = strval($timestamp."-".$nombre_sin_extencion);

                $extension = pathinfo($nombre_original, PATHINFO_EXTENSION);

                $documento = $request->file('documento')->storeAs('public/Docs',strval($nombre_completo).".".$extension);
                $documento_encontrado->ruta_documento = strval($documento);//
            }
            else{
                if($request->informacion_estado == "no"){
                    $documento_encontrado->habilitado = 0;
                }
                else{
                    $documento_encontrado->habilitado = 1;
                }
            }

            $documento_encontrado->habilitado = $request->habilitado;
            //---------------------------------------------------------------------------
            //Información estado
            if($request->informacion_estado == null){
                $documento_encontrado->informacion_estado = "no";
            }
            else{
                $documento_encontrado->informacion_estado = $request->informacion_estado;
            }
            //----------------------------------------------------------------------------

            //Comentario
            if($request->post('comentario') == null){
                $documento_encontrado->comentario = "";
            }
            else{
                $documento_encontrado->comentario = $request->post('comentario');//
            }
            //----------------------------------------------------------------------------

            $documento_encontrado->update();

            $licitacion_encontrada = Licitacion::find($documento_encontrado->licitacion_id);
            if(!is_null($documento_nombre)){
                $cantidad = intval($licitacion_encontrada->progreso_aplica)+1;
                $licitacion_encontrada->progreso_aplica = $cantidad;
            }

            if($request->informacion_estado == "no"){
                if($request->habilitado == "0"){
                    $cantidad = intval($licitacion_encontrada->progreso_aplica)+1;
                    $licitacion_encontrada->progreso_aplica = $cantidad;
                }
                elseif($request->habilitado == "1"){
                    $cantidad = intval($licitacion_encontrada->progreso_aplica)-1;
                    $licitacion_encontrada->progreso_aplica = $cantidad;
                }
            }
            
            if ($licitacion_encontrada->cantidad_aplica == $licitacion_encontrada->progreso_aplica){
                $licitacion_encontrada->estado ="completada";
            }
            $licitacion_encontrada->update();

            $id = $documento_encontrado->licitacion_id;

            $previa_porcentaje = (100/$licitacion_encontrada->cantidad_aplica)*$licitacion_encontrada->progreso_aplica;
            $porcentaje  = bcdiv($previa_porcentaje, '1', 1);

            session(["porcentaje" => $porcentaje]);
           
            
            return back();
        }
    }

    public function regresar(Request $request, string $id){
        
    }


    public function anexos(string $id){
        if ($id== "Documentos a integrar"){
            return view("Program.Anexos.anexo1");
        }
        if ($id== "Contratacion de personal"){
            return view("Program.Anexos.anexo2");
        }
        if ($id== "Compras menores"){
            return view("Program.Anexos.anexo3");
        }
        if ($id== "Invitacion restringida"){
            return view("Program.Anexos.anexo4");
        }
        if ($id== "Adjudicacion directa"){
            return view("Program.Anexos.anexo5");
        }
        if ($id== "Licitacion publica"){
            return view("Program.Anexos.anexo6");
        }
    }


    public function aplicavista(string $id){
        $licitacion_id = $id;
        $data = Licitacion::find($id);
        $documentos = collect([
            ['nombre' => 'Documentos a integrar', 'vista' => 'aplica1'],
            ['nombre' => 'Contratacion de personal', 'vista' => 'aplica2'],
            ['nombre' => 'Compras menores', 'vista' => 'aplica3'],
            ['nombre' => 'Invitacion restringida', 'vista' => 'aplica4'],
            ['nombre' => 'Adjudicacion directa', 'vista' => 'aplica5'],
            ['nombre' => 'Licitacion publica', 'vista' => 'aplica6'],
        ]);
        
        $obtenerVista = $documentos->where('nombre',$data->area)->pluck('vista');
        if($obtenerVista[0] == 'aplica1'){
            $documento1 = Documentos::where("licitacion_id","=",$id)->get();
            
            return view("Program.Aplica.aplica1",compact('documento1', 'licitacion_id'));
        }
        if($obtenerVista[0] == 'aplica2'){
            $resultado1 = Documentos::where('licitacion_id','=',$id)
                                ->where('categoria', '=','EJERCICIO (RECURSOS HUMANOS)')
                                ->get();
            $resultado2 = Documentos::where('licitacion_id','=',$id)
                                ->where('categoria', '=','SEGUIMIENTO')
                                ->get();
            $resultado3 = Documentos::where('licitacion_id','=',$id)
                                ->where('categoria', '=','RENDICION DE LA CUENTA PUBLICA')
                                ->get();
            return view("Program.Aplica.aplica2",compact('resultado1','resultado2','resultado3', 'licitacion_id'));
        }
        if($obtenerVista[0] == 'aplica3'){
            $resultado1 = Documentos::where('licitacion_id','=',$id)
                                ->where('categoria', '=','SOLICITUD DE ADQUISICIÓN')
                                ->get();
            $resultado2 = Documentos::where('licitacion_id','=',$id)
                                ->where('categoria', '=','RECEPCIÓN DE INSUMOS MEDICOS, ADMINISTRATIVOS Y ACTIVOS FIJOS')
                                ->get();
            $resultado3 = Documentos::where('licitacion_id','=',$id)
                                ->where('categoria', '=','TRÁMITE DE PAGO')
                                ->get();
            $resultado4 = Documentos::where('licitacion_id','=',$id)
                                ->where('categoria', '=','SEGUIMIENTO')
                                ->get();
            $resultado5 = Documentos::where('licitacion_id','=',$id)
                                ->where('categoria', '=','RENDICIÓN DE LA CUENTA PÚBLICA')
                                ->get();
            return view("Program.Aplica.aplica3",compact('resultado1','resultado2','resultado3','resultado4','resultado5', 'licitacion_id'));
        }
        if($obtenerVista[0] == 'aplica4'){
            $resultado1 = Documentos::where('licitacion_id','=',$id)
                                ->where('categoria', '=','SOLICITUD DE ADQUISICIÓN')
                                ->get();
            $resultado2 = Documentos::where('licitacion_id','=',$id)
                                ->where('categoria', '=','ADQUISICIONES DE BIENES Y SERVICIOS MEDIANTE INVITACIÓN A CUANDO MENOS TRES PERSONAS:')
                                ->get();
            $resultado3 = Documentos::where('licitacion_id','=',$id)
                                ->where('categoria', '=','RECEPCIÓN DE INSUMOS MEDICOS, ADMINISTRATIVOS Y ACTIVOS FIJOS')
                                ->get();
            $resultado4 = Documentos::where('licitacion_id','=',$id)
                                ->where('categoria', '=','TRÁMITE DE PAGO')
                                ->get();
            $resultado5 = Documentos::where('licitacion_id','=',$id)
                                ->where('categoria', '=','GENERALIDADES EN EL CASO DE PENALIZACIONES AL PROVEDOR')
                                ->get();
            $resultado6 = Documentos::where('licitacion_id','=',$id)
                                ->where('categoria', '=','SEGUIMIENTO')
                                ->get();
            $resultado7 = Documentos::where('licitacion_id','=',$id)
                                ->where('categoria', '=','RENDICIÓN DE LA CUENTA PÚBLICA')
                                ->get();
            return view("Program.Aplica.aplica4",compact('resultado1','resultado2','resultado3','resultado4','resultado5','resultado6','resultado7', 'licitacion_id'));
        }
        if($obtenerVista[0] == 'aplica5'){
            $resultado1 = Documentos::where('licitacion_id','=',$id)
                                ->where('categoria', '=','SOLICITUD DE ADQUISICIÓN')
                                ->get();
            $resultado2 = Documentos::where('licitacion_id','=',$id)
                                ->where('categoria', '=','PROCESO DE COMPRA')
                                ->get();
            $resultado3 = Documentos::where('licitacion_id','=',$id)
                                ->where('categoria', '=','RECEPCIÓN DE INSUMOS MEDICOS, ADMINISTRATIVOS Y ACTIVOS FIJOS')
                                ->get();
            $resultado4 = Documentos::where('licitacion_id','=',$id)
                                ->where('categoria', '=','TRÁMITE DE PAGO')
                                ->get();
            $resultado5 = Documentos::where('licitacion_id','=',$id)
                                ->where('categoria', '=','GENERALIDADES EN EL CASO DE PENALIZACIONES AL PROVEDOR')
                                ->get();
            $resultado6 = Documentos::where('licitacion_id','=',$id)
                                ->where('categoria', '=','SEGUIMIENTO')
                                ->get();
            $resultado7 = Documentos::where('licitacion_id','=',$id)
                                ->where('categoria', '=','RENDICIÓN DE LA CUENTA PÚBLICA')
                                ->get();
            return view("Program.Aplica.aplica5",compact('resultado1','resultado2','resultado3','resultado4','resultado5','resultado6','resultado7', 'licitacion_id'));
        }
        if($obtenerVista[0] == 'aplica6'){
            $resultado1 = Documentos::where('licitacion_id','=',$id)
                                ->where('categoria', '=','SOLICITUD DE ADQUISICIÓN')
                                ->get();
            $resultado2 = Documentos::where('licitacion_id','=',$id)
                                ->where('categoria', '=','ADQUISICIONES DE BIENES Y SERVICIOS MEDIANTE LICITACIÓN PÚBLICA:')
                                ->get();
            $resultado3 = Documentos::where('licitacion_id','=',$id)
                                ->where('categoria', '=','RECEPCIÓN DE INSUMOS MEDICOS, ADMINISTRATIVOS Y ACTIVOS FIJOS')
                                ->get();
            $resultado4 = Documentos::where('licitacion_id','=',$id)
                                ->where('categoria', '=','TRÁMITE DE PAGO')
                                ->get();
            $resultado5 = Documentos::where('licitacion_id','=',$id)
                                ->where('categoria', '=','GENERALIDADES EN EL CASO DE PENALIZACIONES AL PROVEDOR:')
                                ->get();
            $resultado6 = Documentos::where('licitacion_id','=',$id)
                                ->where('categoria', '=','SEGUIMIENTO')
                                ->get();
            $resultado7 = Documentos::where('licitacion_id','=',$id)
                                ->where('categoria', '=','RENDICIÓN DE LA CUENTA PÚBLICA')
                                ->get();
            return view("Program.Aplica.aplica6",compact('resultado1','resultado2','resultado3','resultado4','resultado5','resultado6','resultado7', 'licitacion_id'));
        }
    }

    
    public function aplica (Request $request, string $id){
        $documento_encontrado = Documentos::find($id);

        $documento_encontrado->licitacion_id = $documento_encontrado->licitacion_id;//
        $documento_encontrado->categoria = $documento_encontrado->categoria;
        $documento_encontrado->requisito = $documento_encontrado->requisito;
        $documento_encontrado->informacion_estado = $documento_encontrado->informacion_estado;//
        $documento_encontrado->ruta_documento = $documento_encontrado->ruta_documento;//
        $documento_encontrado->comentario = $documento_encontrado->comentario;//
        $documento_encontrado->area = $documento_encontrado->area;
        $documento_encontrado->aplica = $request->post('aplica');

        if($request->post('aplica') === "si"){
            $licitacion_encontrada = Licitacion::find($documento_encontrado->licitacion_id);
            $cantidad = intval($licitacion_encontrada->cantidad_aplica)+1;
            $licitacion_encontrada->cantidad_aplica = $cantidad;
            $licitacion_encontrada->save();  
        }
        if($request->post('aplica') === "no"){
            $licitacion_encontrada = Licitacion::find($documento_encontrado->licitacion_id);
            $cantidad = intval($licitacion_encontrada->cantidad_aplica)-1;
            $licitacion_encontrada->cantidad_aplica = $cantidad;
            $licitacion_encontrada->save();  
        }
        $documento_encontrado->save();         
        $id = $documento_encontrado->licitacion_id;
        return back();
        //return redirect()->route("licitacion.index");
        //return redirect()->route("licitacion.index",$id);
    }

    public function upload(Request $request)
{
    $this->validate($request, [
        'file_input_name' => 'required|file|max:62000', // Tamaño en kilobytes (6200MB)
    ]);

    // Procesa la carga del archivo aquí
}
}
