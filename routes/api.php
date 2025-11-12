<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PropertyController;
use App\Http\Controllers\Api\CertificateController;

/**
* --- Property Routes ---
*
* - GET /property: Retrieve a list of properties.
* - POST /property: Create a new property.
* - GET /property/{id}: Retrieve a specific property by ID.
* - PATCH /property/{id}: Update a specific property by ID.
* - DELETE /property/{id}: Delete a specific property by ID.
*
* - GET /property/{property}/certificate: Retrieve certificates associated with a specific property.
* - GET /property/{property}/note: Retrieve notes associated with a specific property.
* - POST /property/{property}/note: Store a new note for a specific property.
*/
Route::get('/property', [PropertyController::class, 'index']);
Route::post('/property', [PropertyController::class, 'store']);
Route::get('/property/{property}', [PropertyController::class, 'show']);
Route::patch('/property/{property}', [PropertyController::class, 'update']);
Route::delete('/property/{property}', [PropertyController::class, 'destroy']);

Route::get('/property/{property}/certificate', [PropertyController::class, 'getCertificates']);
Route::get('/property/{property}/note', [PropertyController::class, 'getNotes']);
Route::post('/property/{property}/note', [PropertyController::class, 'storeNote']);

/**
* --- Certificate Routes ---
*
* - GET /certificate: Retrieve a list of certificates.
* - POST /certificate: Create a new certificate.
* - GET /certificate/{id}: Retrieve a specific certificate by ID.
*
* - GET /certificate/{certificate}/note: Retrieve notes associated with a specific certificate.
* - POST /certificate/{certificate}/note: Store a new note for a specific certificate.
*/
Route::get('/certificate', [CertificateController::class, 'index']);
Route::get('/certificate/{certificate}', [CertificateController::class, 'show']);
Route::post('/certificate', [CertificateController::class, 'store']);

Route::get('/certificate/{certificate}/note', [CertificateController::class, 'getNotes']);
Route::post('/certificate/{certificate}/note', [CertificateController::class, 'storeNote']);
