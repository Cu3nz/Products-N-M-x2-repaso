<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Mail\ContactoMaillabe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactoController extends Controller
{
    //


    public function pintarFormualario(){

        return view('contactoForm.formulario');

    }


    public function procesarFormulario(Request $request){
        //todo validamos y hacemos trychatc

        $request -> validate([
            'nombre' => ['required' , 'string' , 'min:3'],
            'email' => ['required' , 'email'],
            'contenido' => ['required' , 'string' , 'min:5']
        ]);

        try {
            Mail::to('sergio@example.com') -> send(new ContactoMaillabe(ucfirst($request -> nombre), $request -> email , ucfirst($request -> contenido)));
            return redirect() -> route('inicio') -> with('mensaje' , 'Se ha enviado el mensaje');
        } catch (\Exception $ex) {
            dd("Error al enviar el email" . $ex -> getMessage());
            return redirect() -> route('inicio') -> with('mensaje' , 'No se ha podido enviar el mensaje');
        }

    }

}
