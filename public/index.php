<?php

session_start();

require_once (__DIR__ . '/../bootstrap/bootstrap.php');

use Farhannivta\CrudSession\Facades\Auth;
use Farhannivta\CrudSession\Facades\Route;

if (!Auth::isLogged()) {
    Route::redirect('login.php');
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Praktikum Informatika</title>
  <link href="<?= Route::createUrl('css/style.css'); ?>" rel="stylesheet">
</head>

<body class="bg-[#212429]">
  <header class="text-white relative z-20">
    <nav class="flex justify-between w-screen px-2 py-4">
      <div class="flex gap-3 items-center">
        <h1 class="text-xl font-medium">Praktikum IF | 123230139</h1>

        <ul class="flex gap-3">
          <li><a class="hover:underline" href="">Home</a></li>
          <li><a class="text-slate-400 hover:underline" href="<?= Route::createUrl('lab.php') ?>">Lab</a></li>
          <li><a class="text-slate-400 hover:underline" href="<?= Route::createUrl('waktu.php') ?>">Waktu</a></li>
          <li><a class="text-slate-400 hover:underline" href="<?= Route::createUrl('jadwal.php') ?>">Jadwal</a></li>
        </ul>
      </div>
      <a class="text-slate-400 hover:underline" href="<?= Route::createUrl('logout.php'); ?>">Logout</a>
    </nav>
  </header>

  <main class="absolute top-0 w-screen h-screen text-white flex flex-col justify-center items-center">
    <div class="mb-10">
      <h2 class="text-center font-medium">Selamat Datang di</h2>
      <h1 class="text-center text-3xl font-semibold">Praktikum Informatika</h1>
    </div>

    <div class="w-[900px] min-w-[400px] px-10">
      <div class="flex gap-5 w-full mb-5">
        <a class="flex-1 border text-center py-2 rounded hover:bg-white hover:text-[#212429]" href="<?= Route::createUrl('lab.php') ?>">Lab</a>
        <a class="flex-1 bg-transparent border text-center py-2 rounded hover:bg-white hover:text-[#212429]" href="<?= Route::createUrl('waktu.php') ?>">Waktu Praktikum</a>
      </div>
      <a class="border text-center w-full inline-block p-2 rounded hover:bg-white hover:text-[#212429]" href="<?= Route::createUrl('jadwal.php') ?>">Jadwal Praktikum</a>
    </div>
  </main>
</body>

</html>
