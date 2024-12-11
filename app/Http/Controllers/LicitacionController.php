<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Licitacion;
use App\Models\Usuarios;
use App\Models\Documentos;
use App\Models\Holydays;
use Database\Seeders\Documento1Seeder;
use Database\Seeders\Documento2Seeder;
use Database\Seeders\Documento3Seeder;
use Database\Seeders\Documento4Seeder;
use Database\Seeders\Documento5Seeder;
use Database\Seeders\Documento6Seeder;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
//use Illuminate\Database\Seeder;

class LicitacionController extends Controller
{
    public function index(){
        $archivoPdf = 'app/public/documento1.pdf';
        $urlPdf = Storage::url($archivoPdf);
        $id = auth()->user()->id;
        $datos = Licitacion::where('usuario_id','=',$id)->get();
        return view('Program.Licitacion.index',compact('datos','urlPdf'));
    }

    public function create(){
        $datos = Usuarios::all();
        return view('Program.Licitacion.create',compact('datos'));
    }


    public function store(Request $request)
    {
        $licitacion = new Licitacion();
        $licitacion->usuario_id = auth()->user()->id;
        $licitacion->nombre = $request->post('nombre');
        $licitacion->folio = $request->post('folio');
        $licitacion->area = $request->post('area');
        $licitacion->fecha_elaboracion = $request->post('fecha_elaboracion');
        $licitacion->fecha_recepcion = $request->post('fecha_recepcion');
        $licitacion->plazo_dias = $request->post('plazo_dias');
        $licitacion->formato_fecha = $request->post('formato_fecha');
        $fecha_evaluar = $request->post('fecha_documentos');
        if($fecha_evaluar == "Fecha de elaboracion"){
            $fecha_base = $request->post('fecha_elaboracion');
        }
        if($fecha_evaluar == "Fecha de recepcion"){
            $fecha_base = $request->post('fecha_recepcion');
        }

        $fechaCarbon = Carbon::parse($fecha_base);
        $verificarDia = $request->post('formato_fecha');
        if($verificarDia == "Habiles"){
            $dia = 86400;
            $contador  = 1;
            $fechaEnSegundos = strtotime($fecha_base);
            $dias_sumar = $request->post('plazo_dias');
            while ($contador <= $dias_sumar) {
                if (date('N',$fechaEnSegundos) == 6 or date('N',$fechaEnSegundos) == 7) {
                    $fechaEnSegundos += $dia;
                }else {
                    $fechaEnSegundos += $dia;
                    $contador +=1;	
                }	
            }
            $fecha_calculada = date('Y-m-d h:i:s' , $fechaEnSegundos);
        }
        if($verificarDia == "Naturales"){
            $nombreDiaSemana = $fechaCarbon->englishDayOfWeek;
            if($nombreDiaSemana == "Saturday"){
                $diaExtra = 2;
            }
            if($nombreDiaSemana == "Sunday"){
                $diaExtra = 1;
            }else{
                $diaExtra = 0;
            }

            $dias_sumar = $request->post('plazo_dias');
            $calcular_fecha_timestamp = strtotime($fecha_base) + (($dias_sumar+$diaExtra) * 24 * 60 * 60);
            $fecha_calculada = date('Y-m-d', $calcular_fecha_timestamp);
            
        }

        $licitacion->fecha_culminacion = $fecha_calculada;
        $licitacion->save();

        /*obtener el id de la licitaicon*/
        $getfolio = $request->post('folio');
        $getid = Licitacion::where('folio','=',$getfolio)->pluck('id');
        $ids = implode(', ', $getid->toArray());
        /*generar los requisitos*/
        $documento = $request->post('area');
        if($documento == 'Documentos a integrar'){
            $seeder = new Documento1Seeder();
            $seeder->run($ids);
        }
        if($documento == 'Contratacion de personal'){
            $seeder = new Documento2Seeder();
            $seeder->run($ids);
        }
        if($documento == 'Compras menores'){
            $seeder = new Documento3Seeder();
            $seeder->run($ids);
        }
        if($documento == 'Invitacion restringida'){
            $seeder = new Documento4Seeder();
            $seeder->run($ids);
        }
        if($documento == 'Adjudicacion directa'){
            $seeder = new Documento5Seeder();
            $seeder->run($ids);
        }
        if($documento == 'Licitacion publica'){
            $seeder = new Documento6Seeder();
            $seeder->run($ids);
        }
        return redirect()->route("licitacion.index");
    }

    public function store_admin(Request $request)
    {
        $licitacion = new Licitacion();
        $licitacion->usuario_id = (int) $request->post('usuario_id');
        $licitacion->nombre = $request->post('nombre');
        $licitacion->folio = $request->post('folio');
        $licitacion->area = $request->post('area');
        $licitacion->fecha_elaboracion = $request->post('fecha_elaboracion');
        $licitacion->fecha_recepcion = $request->post('fecha_recepcion');
        $licitacion->plazo_dias = (int) $request->post('plazo_dias');
        $licitacion->formato_fecha = $request->post('formato_fecha');
        $fecha_evaluar = $request->post('fecha_documentos');
        if($fecha_evaluar == "Fecha de elaboracion"){
            $fecha_base = $request->post('fecha_elaboracion');
        }
        if($fecha_evaluar == "Fecha de recepcion"){
            $fecha_base = $request->post('fecha_recepcion');
        }
        $dia = 86400;
        $dias_sumar = $request->post('plazo_dias');
        $contador  = 0;
        $fechaEnSegundos = strtotime($fecha_base);

        $holydays = Holydays::all();
        $dias_restar = 0;

        while ($contador < $dias_sumar) {
            if (date('N',$fechaEnSegundos) == 6 or date('N',$fechaEnSegundos) == 7) {
                $fechaEnSegundos += $dia;
            }
            else {
                $fechaEnSegundos += $dia;
                if(date('N',$fechaEnSegundos) == 6){
                    $fechaEnSegundos = $fechaEnSegundos + $dia + $dia;
                }
                if(date('N',$fechaEnSegundos) == 7){
                    $fechaEnSegundos = $fechaEnSegundos + $dia + $dia;
                }
                $contador +=1;
            }

            foreach($holydays as $item){
                if(date("Y-m-d",$fechaEnSegundos) == $item->feriados){
                    $dias_restar++;
                }
            }
        }

        for($i=0; $i < $dias_restar; $i++){
            $fechaEnSegundos += $dia;
        }

        if(date('N',$fechaEnSegundos) == 7){//cae un día sábado
            $fechaEnSegundos = $fechaEnSegundos + $dia;
        }
        if(date('N',$fechaEnSegundos) == 6){//cae un día sábado
            $fechaEnSegundos = $fechaEnSegundos + $dia + $dia;
        }
        
        $fecha_calculada = date('Y-m-d h:i:s' , $fechaEnSegundos);
        
        $licitacion->fecha_culminacion = $fecha_calculada;

        $licitacion->save();

        /*obtener el id de la licitaicon*/
        $getfolio = $request->post('folio');
        $getid = Licitacion::where('folio','=',$getfolio)->pluck('id');
        $ids = implode(', ', $getid->toArray());
        /*generar los requisitos*/
        $documento = $request->post('area');
        if($documento == 'Documentos a integrar'){
            $seeder = new Documento1Seeder();
            $seeder->run($ids);
        }
        if($documento == 'Contratacion de personal'){
            $seeder = new Documento2Seeder();
            $seeder->run($ids);
        }
        if($documento == 'Compras menores'){
            $seeder = new Documento3Seeder();
            $seeder->run($ids);
        }
        if($documento == 'Invitacion restringida'){
            $seeder = new Documento4Seeder();
            $seeder->run($ids);
        }
        if($documento == 'Adjudicacion directa'){
            $seeder = new Documento5Seeder();
            $seeder->run($ids);
        }
        if($documento == 'Licitacion publica'){
            $seeder = new Documento6Seeder();
            $seeder->run($ids);
        }
        return redirect()->route("licitacion.index");
    }

    public function destroy(string $id)
    {
        $licitacion = Licitacion::find($id);
        $documentos = Documentos::where("licitacion_id",$id)->get();
        foreach($documentos as $documento) { $documento->delete();}
        $licitacion->delete();
        return redirect()->route("licitacion.all");
    }

    public function all()
    {   
        if (Auth::user()->tipo_usuario != 'Administrador') { 
            abort(404);
        }
        
        if (Auth::user()->tipo_usuario == 'Administrador') 
        {
            $datos = Licitacion::all();  
             
        }
        else
        {
            $datos = Licitacion::where('usuario_id', Auth::user()->id)->get();
        }
        
        return view('Program.Licitacion.all', compact('datos'));
    }


    public function busqueda(Request $request){
        if (Auth::user()->tipo_usuario != 'Administrador') { 
            abort(404);
        }

        $fecha_ini = $request->start_date;
        $fecha_fin = $request->end_date;

        if(!is_null($request->usuario_id) && !is_null($request->area)){
            $licitaciones = Licitacion::where('usuario_id', $request->usuario_id)
                            ->where('area', $request->area)
                            ->whereBetween('fecha_elaboracion', [$fecha_ini, $fecha_fin])
                            ->get();
        }
        elseif(!is_null($request->usuario_id) && is_null($request->area)){
            if(is_null($fecha_ini)){
                $licitaciones = Licitacion::where('usuario_id', $request->usuario_id)
                            ->get();
            }
            else{
                $licitaciones = Licitacion::where('usuario_id', $request->usuario_id)
                            ->whereBetween('fecha_elaboracion', [$fecha_ini, $fecha_fin])
                            ->get();
            }
        }
        elseif(is_null($request->usuario_id) && !is_null($request->area)){
            if(is_null($fecha_ini)){
                $licitaciones = Licitacion::where('area', $request->area)
                            ->get();
            }
            else{
                $licitaciones = Licitacion::where('area', $request->area)
                            ->whereBetween('fecha_elaboracion', [$fecha_ini, $fecha_fin])
                            ->get();
            }
        }
        else{
            $licitaciones = Licitacion::whereBetween('fecha_elaboracion', [$fecha_ini, $fecha_fin])
                            ->get();
        }
        
        //dd($licitaciones);
        $usuarios = Usuarios::all();
        return view('Program.Licitacion.busqueda', compact('licitaciones', 'usuarios', 'fecha_ini', 'fecha_fin'));
    }

    public function buscarFolio(Request $request){
        $fecha_ini = '';
        $fecha_fin = '';

        $usuarios = Usuarios::all();
        $licitaciones = Licitacion::where('folio', $request->folio)->get();
        return view('Program.Licitacion.busqueda', compact('licitaciones', 'usuarios', 'fecha_ini', 'fecha_fin'));
    }
    

    public function edit(string $id)
    {
        $licitacion = Licitacion::find($id);
        return view("Program.Licitacion.update",compact('licitacion'));
    }
    public function update(Request $request, string $id)
    {
        $licitacion_encontrada = Licitacion::find($id);
        //dump($licitacion_encontrada->all());
        $licitacion_encontrada->nombre = $request->post('nombre');
        $licitacion_encontrada->folio = $request->post('folio');
        $licitacion_encontrada->fecha_elaboracion = $request->post('fecha_elaboracion');
        $licitacion_encontrada->fecha_recepcion = $request->post('fecha_recepcion');
        $licitacion_encontrada->plazo_dias = $request->post('plazo_dias');
        $licitacion_encontrada->formato_fecha = $request->post('formato_fecha');

        /*$licitacion = new Licitacion();
        $licitacion->usuario_id = $licitacion_encontrada->usuario_id; 
        $licitacion->nombre = $request->post('nombre');
        $licitacion->folio = $request->post('folio');
        $licitacion->area = $licitacion_encontrada->area;
        $licitacion->fecha_elaboracion = $request->post('fecha_elaboracion');
        $licitacion->fecha_recepcion = $request->post('fecha_recepcion');
        $licitacion->plazo_dias = $request->post('plazo_dias');
        $licitacion->formato_fecha = $request->post('formato_fecha');
        */

        $fecha_base = $request->post('fecha_elaboracion');
        $dias_sumar = $request->post('plazo_dias');

        if($request->post('formato_fecha') == "Habiles"){
            $dia = 86400;
            $contador = 1;
            $fechaEnSegundos = strtotime($fecha_base);
            
            while ($contador <= $dias_sumar) {
                if (date('N',$fechaEnSegundos) == 6 or date('N',$fechaEnSegundos) == 7) {
                    $fechaEnSegundos += $dia;
                }else {
                    $fechaEnSegundos += $dia;
                    $contador +=1;	
                }	
            }
            $fecha_calculada = date('Y-m-d h:i:s' , $fechaEnSegundos);
        }
        if($request->post('formato_fecha') == "Naturales"){
            /*$nombreDiaSemana = $fechaCarbon->englishDayOfWeek;
            if($nombreDiaSemana == "Saturday"){
                $diaExtra = 2;
            }
            if($nombreDiaSemana == "Sunday"){
                $diaExtra = 1;
            }else{
                $diaExtra = 0;
            }
            */
            //$dias_sumar = $request->post('plazo_dias');
            $calcular_fecha_timestamp = strtotime($fecha_base) + (($dias_sumar) * 24 * 60 * 60);
            $fecha_calculada = date('Y-m-d', $calcular_fecha_timestamp);
            
        }
        
        //$fecha_base = $request->post('fecha_elaboracion');
        //$dias_sumar = $request->post('plazo_dias');
        //$calcular_fecha_timestamp = strtotime($fecha_base) + ($dias_sumar * 24 * 60 * 60);
        //$fecha_calculada = date('Y-m-d', $calcular_fecha_timestamp);

        $licitacion_encontrada->fecha_culminacion = $fecha_calculada;
        //dump($licitacion_encontrada->all());
        if($licitacion_encontrada->update() == true){
            return redirect()->route("licitacion.all");
        }
        //$licitacion->fecha_culminacion = $fecha_calculada;
        //$licitacion->save();
        //return redirect()->route("licitacion.all");
    }

    public function put(Request $request, string $id) {
        $licitacion_encontrada = Licitacion::find($id);
        $licitacion_encontrada->estado = 'pendiente_out';
        if($licitacion_encontrada->update() == true){
            return redirect()->route("licitacion.all");
        }
    }
}

