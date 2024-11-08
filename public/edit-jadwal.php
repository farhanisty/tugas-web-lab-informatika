<?php

session_start();

require_once (__DIR__ . '/../bootstrap/bootstrap.php');

use Farhannivta\CrudSession\Facades\Auth;
use Farhannivta\CrudSession\Facades\FlashSession;
use Farhannivta\CrudSession\Facades\Route;
use Farhannivta\CrudSession\Repositories\JadwalRepositoryFactory;
use Farhannivta\CrudSession\Repositories\LabRepositoryFactory;
use Farhannivta\CrudSession\Repositories\WaktuRepositoryFactory;

if (!Auth::isLogged()) {
    Route::redirect('login.php');
}

$jadwalRepository = JadwalRepositoryFactory::get();

if (strtolower($_SERVER['REQUEST_METHOD']) == strtolower('POST')) {
    if ($jadwalRepository->update($_REQUEST['id'], $_REQUEST['mk'], $_REQUEST['jurusan'], $_REQUEST['lab'], $_REQUEST['waktu'])) {
        FlashSession::set('Berhasil mengedit jadwal');
    } else {
        FlashSession::set('Gagal mengedit jadwal');
    }

    Route::redirect('jadwal.php');
}

$jadwal = $jadwalRepository->getById($_GET['id']);

$labRepository = LabRepositoryFactory::get();
$rawLabs = $labRepository->getAll();

$labs = [];

foreach ($rawLabs as $rawLab) {
    if ($rawLab->id != $jadwal->id_lab) {
        $labs[] = $rawLab;
    }
}

$waktuRepository = WaktuRepositoryFactory::get();
$rawWaktus = $waktuRepository->getAll();

$waktus = [];
foreach ($rawWaktus as $rawWaktu) {
    if ($rawWaktu->id != $jadwal->id_waktu) {
        $waktus[] = $rawWaktu;
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Praktikum Informatika</title>
  <link href="<?= Route::createUrl('css/style.css') ?>" rel="stylesheet">
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
    <div class="max-w-[500px] w-[500px] px-3 md:px-0">
      <div class="py-5 border-b mb-5">
        <h1 class="text-3xl font-semibold text-center">Ubah Jadwal Praktikum</h1>
      </div>

      <h2 class="font-medium text-center mb-10">Buat jadwal praktikum sesuai dengan yang diinginkan</h2>

      <form method="post">
        <input type="hidden" name="id" value="<?= $jadwal->id ?>" />
        <div>
          <div class="flex items-center gap-3 mb-3">
            <input class="bg-transparent border rounded p-2 w-full" name="mk" type="text" placeholder="Masukkan MK Praktikum" value="<?= $jadwal->mk ?>">
            <input id="if-radio" type="radio" name="jurusan" value="IF" <?= $jadwal->jurusan == 'IF' ? 'checked' : '' ?>>
            <label for="if-radio">IF</label>
            <input id="si-radio" type="radio" name="jurusan" value="SI" <?= $jadwal->jurusan != 'IF' ? 'checked' : '' ?>>
            <label for="si-radio">SI</label>
          </div>

          <select class="bg-transparent w-full border rounded p-2 mb-3" name="lab" id="lab">
            <option value="<?= $jadwal->id_lab ?>" selected><?= $jadwal->lab ?></option>
            <?php foreach ($labs as $lab): ?>
              <option value="<?= $lab->id ?>"><?= $lab->lab; ?></option>
            <?php endforeach ?>
          </select>

          <select class="bg-transparent w-full border rounded p-2 mb-4" name="waktu" id="waktu">
            <option value="<?= $jadwal->id_waktu ?>" selected><?= substr($jadwal->waktu_mulai, 0, 5) . ' - ' . substr($jadwal->waktu_selesai, 0, 5) ?></option>
            <?php foreach ($waktus as $waktu): ?>
              <option value="<?= $waktu->id ?>"><?= substr($waktu->waktu_mulai, 0, 5) . ' - ' . substr($waktu->waktu_selesai, 0, 5) ?></option>
            <?php endforeach ?>
          </select>

          <div class="flex flex-col justify-between gap-5">
            <button class="border rounded flex-1 p-2" type="submit">Submit</button>
            <button class="flex-1 border border-slate-600 text-slate-600 rounded p-2" type="reset">Reset</button>
          </div>
        </div>
      </form>
    </div>
  </main>
</body>

</html>
