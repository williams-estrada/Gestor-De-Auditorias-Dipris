<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\Usuarios;    
use Illuminate\Http\Request;
use App\Notifications\MessageNotification;
use App\Events\MessageEvent;

class MessageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        auth()->user()->unreadNotifications->markAsRead();

        if(auth()->user()->tipo_usuario == "Cliente"){
            $usuarios = Usuarios::where("tipo_usuario", "Administrador")
                                ->where("id", "!=", 3)
                                ->get();
        }
        else{
            $usuarios = Usuarios::where('id', '!=', auth()->user()->id)
                                ->where("id", "!=", 3)
                                ->get();
        }

        if(auth()->user()->tipo_usuario == "Cliente"){ 
            $mensajes = Message::where("to_user_id", auth()->user()->id)
                                ->orderBy("created_at", "DESC")
                                ->paginate(5);;

        } else {
            $mensajes = Message::orderBy("created_at", "DESC")
                                ->paginate(5);;            
        }

        
        return view('Program.Mensaje.index', compact('usuarios', 'mensajes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $mensaje_nuevo = new Message();
        $mensaje_nuevo->titulo = $request->titulo;
        $mensaje_nuevo->contenido = $request->contenido;
        $mensaje_nuevo->user_id = auth()->user()->id;
        $mensaje_nuevo->to_user_id = $request->usuario;
        $mensaje_nuevo->save();

        self::make_message_notification($mensaje_nuevo);

        return back()->with('status', 'Mensaje enviado con éxito.');
    }

    static function make_message_notification(Message $mensaje_nuevo){
        //if($mensaje_nuevo->usuario == 3){
            event(new MessageEvent($mensaje_nuevo));


            /*Usuarios::where('id', '!=', auth()->user()->id)
            ->each(function(Usuarios $user) use ($mensaje_nuevo){
                $user->notify(new MessageNotification($mensaje_nuevo));
            });*/
        /*}
        else{
            Usuarios::where('id', $mensaje_nuevo->to_user_id)
            ->each(function(Usuarios $user) use ($mensaje_nuevo){
                $user->notify(new MessageNotification($mensaje_nuevo));
            });
        }*/
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
     * @param  \App\Models\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function show(Message $message)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function edit(Message $message)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Message $message)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function destroy(Message $message)
    {
        //
    }
}
