<?php

use App\Http\Controllers\ContactoController;
use App\Http\Controllers\Socialite\GithubController;
use App\Http\Controllers\TagController;
use App\Livewire\PrincipalProducts;
use App\Models\Product;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    $producto = Product::with('user') -> where('disponible' , 'SI') -> paginate(5);
    return view('welcome' ,compact('producto'));
}) -> name('inicio');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::resource('tag' , TagController::class);

    Route::get('products' , PrincipalProducts::class) -> name('index.products');

});



//todo Pra el correo
Route::get('contacto' , [ContactoController::class , 'pintarFormualario']) -> name('email.pintar');
Route::post('contacto' , [ContactoController::class , 'procesarFormulario']) -> name('email.enviar');


//todo Para el login

Route::get('/auth/github/redirect' , [GithubController::class , 'redirect']) -> name('github.redirect');
Route::get('/auth/github/callback' , [GithubController::class , 'callback']) -> name('github.callback');