<?php

use core\Router;

use src\Controllers\ArticleController;
use src\Controllers\LoginController;
use src\Controllers\LogoutController;
use src\Controllers\RegistrationController;
use src\Controllers\SettingsController;

Router::get('/', [ArticleController::class, 'index']); // the root/index page

// User/Auth related

Router::get('/login', [LoginController::class, 'index']);
Router::post('/login', [LoginController::class, 'login']);

Router::get('/register', [RegistrationController::class, 'index']); // show registration form.
Router::post('/register', [RegistrationController::class, 'register']); // process a registration req.

Router::post('/logout', [LogoutController::class, 'logout']);

// Article related

Router::get('/create_article', [ArticleController::class, 'create']);
Router::get('/update_article', [ArticleController::class, 'edit']);
Router::get('/articles/update_article', [ArticleController::class, 'edit']);
Router::get('/articles/store', [ArticleController::class, 'index']);
Router::post('/articles/store', [ArticleController::class, 'store']);
Router::post('/articles/update', [ArticleController::class, 'update']);
Router::post('/delete_article', [ArticleController::class, 'delete']);
Router::post('/articles/delete_article', [ArticleController::class, 'delete']);

// Setting
Router::get('/setting', [SettingsController::class, 'index']);
Router::post('/setting', [SettingsController::class, 'update']);
Router::post('/settings', [SettingsController::class, 'index']);


// TODO: set up routes for all the article and settings functions
