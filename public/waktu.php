<?php

session_start();

require_once (__DIR__ . '/../bootstrap/bootstrap.php');

use Farhannivta\CrudSession\Facades\Auth;
use Farhannivta\CrudSession\Facades\FlashSession;
use Farhannivta\CrudSession\Facades\Route;
use Farhannivta\CrudSession\Repositories\WaktuRepositoryFactory;

if (!Auth::isLogged()) {
    Route::redirect('login.php');
}

$waktuRepository = WaktuRepositoryFactory::get();

if (strtolower($_SERVER['REQUEST_METHOD']) == strtolower('POST')) {
    if ($waktuRepository->create($_REQUEST['waktu_mulai'], $_REQUEST['waktu_selesai'])) {
        FlashSession::set('Berhasil menambahkan waktu');
    } else {
        FlashSession::set('Gagal menambahkan waktu');
    }

    Route::redirect('waktu.php');
}

if (isset($_GET['id'])) {
    if ($waktuRepository->destroy($_GET['id'])) {
        FlashSession::set('Berhasil hapus waktu');
    } else {
        FlashSession::set('Gagal hapus waktu');
    }

    Route::redirect('waktu.php');
}

$waktus = $waktuRepository->getAll();

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Praktikum Informatika</title>
  <link href="css/style.css" rel="stylesheet">
</head>

<body class="bg-[#212429]">
  <header class="text-white relative z-20">
    <nav class="flex justify-between w-screen px-2 py-4">
      <div class="flex gap-3 items-center">
        <h1 class="text-xl font-medium">Praktikum IF | 123230139</h1>

        <ul class="flex gap-3">
          <li><a class="text-slate-400 hover:underline" href="<?= Route::createUrl('') ?>">Home</a></li>
          <li><a class="text-slate-400 hover:underline" href="<?= Route::createUrl('lab.php') ?>">Lab</a></li>
          <li><a class="hover:underline" href="<?= Route::createUrl('waktu.php') ?>">Waktu</a></li>
          <li><a class="text-slate-400 hover:underline" href="<?= Route::createUrl('jadwal.php') ?>">Jadwal</a></li>
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
              <th class="px-4">Waktu</th>
              <th class="px-4">Action</th>
            </tr>
          </thead>

          <tbody>
            <?php foreach ($waktus as $key => $waktu): ?>
              <tr class="">
                <td><?= $key + 1 ?></td>
                <td class="px-2"><?= substr($waktu->waktu_mulai, 0, 5) . ' - ' . substr($waktu->waktu_selesai, 0, 5) ?></td>
                <td class="flex gap-3 items-center py-3 px-3">
                  <a class="px-4 py-2 border rounded border-red-400 text-red-400" href="<?= Route::createUrl('waktu.php?id=' . $waktu->id) ?>">Delete</a>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>

      <div class="flex-1 min-w-[350px]">
        <div class="border-b pb-3 mb-3">
          <h1 class="text-3xl font-semibold text-center">Input Waktu Praktikum</h1>
        </div>
        <h2 class="text-center mb-10">Masukkan Waktu Pelaksanaan Praktikum</h2>

        <form method="post">

          <div class="flex gap-3">
            <div class="flex flex-col gap-3 flex-1">
              <label class="text-center" for="waktu_mulai">Mulai</label>
              <input class="bg-transparent border rounded w-full p-2 mb-5 inline-block" id="waktu_mulai" name="waktu_mulai" type="time">
            </div>
            <div class="flex flex-col gap-3 flex-1">
              <label class="text-center" for="waktu_selesai">Selesai</label>
              <input class="bg-transparent border rounded w-full p-2 mb-5" type="time" id="waktu_selesai" name="waktu_selesai">
            </div>
          </div>
          <div class="flex justify-between gap-5">
            <button class="border rounded flex-1 p-2 hover:bg-white hover:text-[#212429]" type="submit">Submit</button>
          </div>
        </form>
      </div>
    </div>
  </main>
</body>

</html>

<?php FlashSession::reset(); ?>
