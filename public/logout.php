<?php

session_start();

require_once (__DIR__ . '/../bootstrap/bootstrap.php');

use Farhannivta\CrudSession\Facades\Auth;
use Farhannivta\CrudSession\Facades\FlashSession;
use Farhannivta\CrudSession\Facades\Route;

if (Auth::isLogged()) {
    FlashSession::set('Anda telah berhasil logout');
    Auth::logout();
}

Route::redirect('login.php');
