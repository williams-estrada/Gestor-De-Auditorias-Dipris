<?php

namespace App\Http\Controllers;

use App\Models\Holydays;
use Illuminate\Http\Request;

class ConfiguracionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if( auth()->user()->tipo_usuario != 'Administrador') 
        { 
            return redirect('/home');
        }

        $lista_feriados = Holydays::where('estado', 1)
                                    ->orderBy('feriados', 'ASC')
                                    ->get();
        return view('Program.Configuracion.index', compact('lista_feriados'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $feriado = new Holydays();
        $feriado->feriados = $request->fecha;
        $feriado->estado = 1;
        $feriado->save();
        return back();
    }

    public function busquedaAnio(Request $request){
        
        $lista_feriados = Holydays::whereYear('feriados', $request->anio)
                                    ->where('estado', 1)->get();
        return view('Program.Configuracion.index', compact('lista_feriados'));
    }

    public function anular($id)
    {
        $holyday = Holydays::find($id);
        $holyday->estado = 0;
        $holyday->update();
        return back();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Holydays  $holydays
     * @return \Illuminate\Http\Response
     */
    public function show(Holydays $holydays)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Holydays  $holydays
     * @return \Illuminate\Http\Response
     */
    public function edit(Holydays $holydays)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Holydays  $holydays
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Holydays $holydays)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Holydays  $holydays
     * @return \Illuminate\Http\Response
     */
    public function destroy(Holydays $holydays)
    {
        //
    }
}
