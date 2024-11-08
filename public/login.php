<?php

session_start();

require_once (__DIR__ . '/../bootstrap/bootstrap.php');

use Farhannivta\CrudSession\Facades\Auth;
use Farhannivta\CrudSession\Facades\FlashSession;
use Farhannivta\CrudSession\Facades\Route;

if (strtolower($_SERVER['REQUEST_METHOD']) == strtolower('POST')) {
    $isValid = Auth::login($_REQUEST['username'], $_REQUEST['password']);
    if ($isValid) {
        Route::redirect('');
    } else {
        FlashSession::set('Username atau password salah!');
    }
}

if (Auth::isLogged()) {
    Route::redirect('');
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
  <main class="h-screen w-screen flex justify-center items-center text-white">
    <div class="w-[350px] flex flex-col">
      <header class="py-5 border-b border-b-[#32353a] w-full">
        <h1 class="capitalize text-3xl font-semibold text-center">Login Page</h1>
      </header>
      <?php if (FlashSession::isAny()): ?>
        <p class="text-center">
          <?= FlashSession::get(); ?>
        </p>
      <?php endif; ?>

      <form action="" method="post">
        <div class="my-10">
          <input name="username" autofocus class="focus:outline-none w-full bg-transparent border p-2 mb-4 rounded" type="text" placeholder="Masukkan username">
          <input name="password" class="w-full bg-transparent border p-2 rounded" type="password" placeholder="Masukkan password">
        </div>

        <button class="uppercase w-full border py-2 rounded hover:bg-slate-100 hover:text-[#212429]">Login</button>
      </form>

      <p class="text-center mt-4">Belum punya akun? <a href="<?= Route::createUrl('register.php') ?>" class="underline">Daftar di sini</a></p>
    </div>
  </main>
</body>

</html>

<?php
FlashSession::reset();
?>
