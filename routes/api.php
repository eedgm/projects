<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\WorkController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\RoleController;
use App\Http\Controllers\Api\EventController;
use App\Http\Controllers\Api\FieldController;
use App\Http\Controllers\Api\ClientController;
use App\Http\Controllers\Api\StatusController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\WorkUsersController;
use App\Http\Controllers\Api\UserWorksController;
use App\Http\Controllers\Api\user_workController;
use App\Http\Controllers\Api\PermissionController;
use App\Http\Controllers\Api\ClientWorksController;
use App\Http\Controllers\Api\UserClientsController;
use App\Http\Controllers\Api\StatusWorksController;
use App\Http\Controllers\Api\ProductWorksController;
use App\Http\Controllers\Api\EventStatusesController;
use App\Http\Controllers\Api\ClientProductsController;
use App\Http\Controllers\Api\ClientStatusesController;
use App\Http\Controllers\Api\ProductDescriptionController;
use App\Http\Controllers\Api\FieldProductDescriptionsController;
use App\Http\Controllers\Api\ProductProductDescriptionsController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/login', [AuthController::class, 'login'])->name('api.login');

Route::middleware('auth:sanctum')
    ->get('/user', function (Request $request) {
        return $request->user();
    })
    ->name('api.user');

Route::name('api.')
    ->middleware('auth:sanctum')
    ->group(function () {
        Route::apiResource('roles', RoleController::class);
        Route::apiResource('permissions', PermissionController::class);

        Route::apiResource('clients', ClientController::class);

        // Client Products
        Route::get('/clients/{client}/products', [
            ClientProductsController::class,
            'index',
        ])->name('clients.products.index');
        Route::post('/clients/{client}/products', [
            ClientProductsController::class,
            'store',
        ])->name('clients.products.store');

        // Client Works
        Route::get('/clients/{client}/works', [
            ClientWorksController::class,
            'index',
        ])->name('clients.works.index');
        Route::post('/clients/{client}/works', [
            ClientWorksController::class,
            'store',
        ])->name('clients.works.store');

        // Client Status
        Route::get('/clients/{client}/statuses', [
            ClientStatusesController::class,
            'index',
        ])->name('clients.statuses.index');
        Route::post('/clients/{client}/statuses', [
            ClientStatusesController::class,
            'store',
        ])->name('clients.statuses.store');

        Route::apiResource('events', EventController::class);

        // Event Status
        Route::get('/events/{event}/statuses', [
            EventStatusesController::class,
            'index',
        ])->name('events.statuses.index');
        Route::post('/events/{event}/statuses', [
            EventStatusesController::class,
            'store',
        ])->name('events.statuses.store');

        Route::apiResource('fields', FieldController::class);

        // Field Product Descriptions
        Route::get('/fields/{field}/product-descriptions', [
            FieldProductDescriptionsController::class,
            'index',
        ])->name('fields.product-descriptions.index');
        Route::post('/fields/{field}/product-descriptions', [
            FieldProductDescriptionsController::class,
            'store',
        ])->name('fields.product-descriptions.store');

        Route::apiResource('products', ProductController::class);

        // Product Product Descriptions
        Route::get('/products/{product}/product-descriptions', [
            ProductProductDescriptionsController::class,
            'index',
        ])->name('products.product-descriptions.index');
        Route::post('/products/{product}/product-descriptions', [
            ProductProductDescriptionsController::class,
            'store',
        ])->name('products.product-descriptions.store');

        // Product Works
        Route::get('/products/{product}/works', [
            ProductWorksController::class,
            'index',
        ])->name('products.works.index');
        Route::post('/products/{product}/works', [
            ProductWorksController::class,
            'store',
        ])->name('products.works.store');

        Route::apiResource(
            'product-descriptions',
            ProductDescriptionController::class
        );

        Route::apiResource('works', WorkController::class);

        // Work Users
        Route::get('/works/{work}/users', [
            WorkUsersController::class,
            'index',
        ])->name('works.users.index');
        Route::post('/works/{work}/users/{user}', [
            WorkUsersController::class,
            'store',
        ])->name('works.users.store');
        Route::delete('/works/{work}/users/{user}', [
            WorkUsersController::class,
            'destroy',
        ])->name('works.users.destroy');

        Route::apiResource('users', UserController::class);

        // User Clients
        Route::get('/users/{user}/clients', [
            UserClientsController::class,
            'index',
        ])->name('users.clients.index');
        Route::post('/users/{user}/clients', [
            UserClientsController::class,
            'store',
        ])->name('users.clients.store');

        // User Works
        Route::get('/users/{user}/works', [
            UserWorksController::class,
            'index',
        ])->name('users.works.index');
        Route::post('/users/{user}/works/{work}', [
            UserWorksController::class,
            'store',
        ])->name('users.works.store');
        Route::delete('/users/{user}/works/{work}', [
            UserWorksController::class,
            'destroy',
        ])->name('users.works.destroy');

        Route::apiResource('statuses', StatusController::class);

        // Status Works
        Route::get('/statuses/{status}/works', [
            StatusWorksController::class,
            'index',
        ])->name('statuses.works.index');
        Route::post('/statuses/{status}/works', [
            StatusWorksController::class,
            'store',
        ])->name('statuses.works.store');
    });
