<?php $validastion = session()->getFlashdata('errors'); ?>

<?= $this->extend('layout') ?>

<?= $this->section('title') ?>
Data Mahasiswa
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<h2>Selamat Datang di Home!</h2>
<p>Ini adalah halaman utama.</p>

<br>
<br>
<br>

<h2>Data Mahasiswa</h2>
<div class="d-flex justify-content-between w-100 mb-3">
    <a href="<?= base_url('mahasiswa/tambah') ?>" class="btn btn-success">Tambah Data</a>
    <form class="d-flex gap-3" method="get">
        <input value="<?= \Config\Services::request()->getGet('keyword') ?>" type="text" name="keyword" class="form-control form-text">
        <button type="submit" class="btn btn-primary">Cari</button>
    </form>
</div>

<!-- Pesan sukses -->
<?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-success mb-3">
        <?= session()->getFlashdata('success') ?>
    </div>
<?php endif; ?>

<table class="table">
    <tr>
        <th>Nim</th>
        <th>Nama</th>
        <th>Kelas</th>
        <th class="text-end">Aksi</th>
    </tr>
    <?php foreach ($mahasiswa as $mhs): ?>
        <tr>
            <td><?= esc($mhs['nim']) ?></td>
            <td><?= esc($mhs['nama_lengkap']) ?></td>
            <td><?= $mhs['jenis_kelamin'] == 'L' ? 'Laki-laki' : 'Perempuan' ?></td>
            <td>
                <div class="d-flex w-100 justify-content-end">
                    <a href="<?= base_url('mahasiswa/detail/' . $mhs['nim']) ?>" class="btn btn-info">Detail</a>
                    <a href="<?= base_url('mahasiswa/edit/' . $mhs['nim']) ?>" class="btn btn-warning">Edit</a>
                    <a href="<?= base_url('mahasiswa/delete/' . $mhs['nim']) ?>" class="btn btn-danger">Hapus</a>
                </div>
            </td>
        </tr>
    <?php endforeach; ?>
</table>

<?= $this->endSection() ?>