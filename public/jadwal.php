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
    if ($jadwalRepository->create($_REQUEST['mk'], $_REQUEST['jurusan'], $_REQUEST['lab'], $_REQUEST['waktu'])) {
        FlashSession::set('Berhasil menambahkan jadwal');
    } else {
        FlashSession::set('Gagal menambahkan jadwal');
    }

    Route::redirect('jadwal.php');
}

if (isset($_GET['id'])) {
    if ($jadwalRepository->destroy($_GET['id'])) {
        FlashSession::set('Berhasil hapus jadwal');
    } else {
        FlashSession::set('Gagal hapus jadwal');
    }

    Route::redirect('jadwal.php');
}

$jadwals = $jadwalRepository->getAll();

$labRepository = LabRepositoryFactory::get();
$labs = $labRepository->getAll();

$waktuRepository = WaktuRepositoryFactory::get();
$waktus = $waktuRepository->getAll();

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
          <li><a class="text-slate-400 hover:underline" href="<?= Route::createUrl('') ?>">Home</a></li>
          <li><a class="text-slate-400 hover:underline" href="<?= Route::createUrl('lab.php') ?>">Lab</a></li>
          <li><a class="text-slate-400 hover:underline" href="<?= Route::createUrl('waktu.php') ?>">Waktu</a></li>
          <li><a class="hover:underline" href="<?= Route::createUrl('jadwal.php') ?>">Jadwal</a></li>
        </ul>
      </div>
      <a class="text-slate-400 hover:underline" href="<?= Route::createUrl('logout.php'); ?>">Logout</a>
    </nav>
  </header>

  <main class="absolute top-0 w-screen h-screen text-white flex flex-col justify-center items-center">
    <?php if (FlashSession::isAny()): ?>
      <p class="mb-5 border p-2">Notifikasi: <?= FlashSession::get() ?></p>
    <?php endif; ?>
    <div class="flex flex-col lg:flex-row max-w-[800px] gap-5">
      <div class="flex-1">
        <table collpadding=10 class="border-collapse">
          <thead>
            <tr class="border-b mb-3">
              <th class="px-4">No</th>
              <th class="px-4">MK Praktikum</th>
              <th class="px-4">Jurusan</th>
              <th class="px-4">Lab</th>
              <th class="px-4">Waktu</th>
              <th class="px-4">Action</th>
            </tr>
          </thead>

          <tbody>
            <?php foreach ($jadwals as $key => $jadwal): ?>
              <tr class="">
                <td><?= $key + 1; ?></td>
                <td><?= $jadwal->mk; ?></td>
                <td><?= $jadwal->jurusan ?></td>
                <td class="px-2"><?= $jadwal->lab ?></td>
                <td class="px-2"><?= substr($jadwal->waktu_mulai, 0, 5) . ' - ' . substr($jadwal->waktu_selesai, 0, 5) ?></td>
                <td class="flex gap-3 items-center py-3 px-3">
                  <a class="px-4 py-2 border rounded" href="<?= Route::createUrl('edit-jadwal.php?id=' . $jadwal->id) ?>">Edit</a>
                  <a class="px-4 py-2 border rounded border-red-400 text-red-400" href="<?= Route::createUrl('jadwal.php?id=' . $jadwal->id) ?>">Delete</a>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>

      <div class="flex-1 min-w-[350px]">
        <div class="border-b pb-3 mb-3">
          <h1 class="text-3xl font-semibold text-center">Input Jadwal Praktikum</h1>
        </div>
        <h2 class="text-center mb-5">Buat jadwal praktikum sesuai yang diinginkan</h2>

        <form method="post">
          <div>
            <div class="flex items-center gap-3 mb-3">
              <input class="bg-transparent border rounded p-2 w-full" name="mk" type="text" placeholder="Masukkan MK Praktikum">
              <input id="if-radio" type="radio" name="jurusan" value="IF" checked>
              <label for="if-radio">IF</label>
              <input id="si-radio" type="radio" name="jurusan" value="SI">
              <label for="si-radio">SI</label>
            </div>

            <select class="bg-transparent w-full border rounded p-2 mb-3" name="lab" id="lab">
              <?php foreach ($labs as $key => $lab): ?>
                <option value="<?= $lab->id ?>" class="capitalize"><?= $lab->lab ?></option>
              <?php endforeach; ?>
            </select>

            <select class="bg-transparent w-full border rounded p-2 mb-4" name="waktu" id="waktu">
              <?php foreach ($waktus as $key => $waktu): ?>
                <option value="<?= $waktu->id ?>" class="capitalize"><?= substr($waktu->waktu_mulai, 0, 5) . '-' . substr($waktu->waktu_selesai, 0, 5); ?></option>
              <?php endforeach; ?>
            </select>

            <div class="flex justify-between gap-5">
              <button class="border rounded flex-1 p-2" type="submit">Submit</button>
              <button class="flex-1 border border-red-300 text-slate-600 rounded p-2" type="reset">Reset</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </main>
</body>

</html>

<?php FlashSession::reset() ?>
