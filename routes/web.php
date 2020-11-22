<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use App\Http\Controllers\Card\CardsController;
use App\Http\Controllers\Card\DocCardController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', 'IndexController@index');

Auth::routes();

Route::resource(
    'blog', 'UserBlogController', [
              'only' => [
                  'index',
                  'show',
              ],
          ]
);

Route::get('shops', 'ProductController@index');
Route::get('add-to-cart/{id}', 'ProductController@getAddToCart');
Route::get('reduce/{id}', 'ProductController@getReduceByOne');
Route::get('remove/{id}', 'ProductController@getRemoveItem');
Route::get('shopping-cart', 'ProductController@getCart');
Route::get('checkout', 'ProductController@getCheckout');
Route::get('status', 'ProductController@paymentStatus');
Route::get('tags/{tags}', 'TagsController@show');

//Doctors

Route::post('/{id}/card/create', [DocCardController::class, 'create']);


Route::group(
    ['prefix' => 'admin'], function () {
    Route::get('/', 'DashboardController@index');
    Route::resource('/roles', 'RoleController');
    Route::resource('/users', 'UserController');
    Route::resource('/blog', 'BlogController')->parameters(
        [
            'blogs' => 'blog',
        ]
    );
    Route::resource('/notes', 'NotesController');
}
);

Route::group(
    ['prefix' => 'user'], function () {
    Route::get('orders', 'ProfileController@index');
    Route::get('orders/download/{name}', 'ProfileController@downloadPdf');

    Route::get('/registrations/calendar', 'ProfileController@registrations')->name('registrations');
    Route::get('/{id}/card-write', [DocCardController::class, 'create']);
    Route::post('/{id}/card-write/store', [DocCardController::class, 'store']);

    Route::get('/profile', 'ProfileController@profile');
    Route::post('/profile/update', 'ProfileController@updateProfile')->name('profile.update');

    Route::group(
        ['prefix' => 'card'], static function (): void {
        Route::get('/', [CardsController::class, 'index'])->name('card.index');
    }
    );
}
);

Route::group(
    ['prefix' => 'doctors'], function () {
    Route::get('list', 'RegistrationController@index');
    Route::get('register-to/{slug}', 'RegistrationController@registerTo');
    Route::post('register-to', 'RegistrationController@addRegistrationEvent')->name('register-to.add');
}
);

Route::post('register-time', 'RegistrationController@registerTime')->name('register-time');