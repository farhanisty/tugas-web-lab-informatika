# Tugas Praktikum Web

## Requirement:

- Composer
  
  Saya menggunakan fitur autoload dari composer untuk mempermudah pekerjaan dengan banyak file.

## Install

Import database:

- Import database `db.sql` yang terdapat pada root directori

Install aplikasi:

- Buka terminal

- Masuk ke direktori root projek

- Ketikkan perintah
  
  ```shell
  composer dump-autoload
  ```

## Konfigurasi

Mungkin saja envirovement yang digunakan di local saya berbeda dengan yang lain. Oleh karena itu, Saya mengumpulkan semua konfigurasi di dalam file `Config.php`.

Dokumentasi:****

- **BASE_URL**
  
  Value dari *base_url* adalah path http(s) url terhadap folder public. Konfigurasi ini sangat penting karena *facades* seperti `Route` menggunakannya pada method `createUrl`.
  
  Penting untuk diperhatikan bahwa base url harus berakhiran '/'(slash).
  
  Contoh konfigurasi:
  
  - Untuk PHP built-in server
    
    ```php
    ...
    
    public const BASE_URL = 'http://localhost:8000/public/';
    
    ..
    ```
  
  - Untuk XAMPP atau sejenisnya
    
    ```php
    ...
    
    public const BASE_URL = 'http://<nama_folder>/public/';
    
    ...
    ```

- **DB_NAME**
  
  Konfigursi untuk nama database.

- **DB_HOST**
  
  Konfigurasi untuk nama host. Untuk lokal dapat menggunakan `localhost` atau `127.0.0.1`.

- **DB_USERNAME**
  
  Konfigurasi username mysql, contoh `root`.

- **DB_PASSWORD**
  
  Konfigurasi password mysql. Jika password kosong dapat diisi dengan string kosong, tidak boleh `NULL`.


