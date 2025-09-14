<?php $validastion = session()->getFlashdata('errors'); ?>

<?= $this->extend('layout') ?>

<?= $this->section('title') ?>
Edit Mahasiswa
<?= $this->endSection() ?>

<?= $this->section('content') ?>


<div class="container mt-5">
    <h2 class="mb-4">Edit Mahasiswa</h2>

    <!-- Semua error -->
    <?php if (isset($validation)) : ?>
        <div class="alert alert-danger">
            <?= $validation->listErrors() ?>
        </div>
    <?php endif; ?>

    <form action="<?= base_url('mahasiswa/edit/' . $mahasiswa['nim']) ?>" method="post">
        <?= csrf_field() ?>

        <input type="hidden" name="_method" value="PUT">

        <!-- NIM -->
        <div class="mb-3">
            <label for="nim" class="form-label">NIM</label>
            <input type="text" class="form-control" id="nim" name="nim"
                value="<?= old('nim', $mahasiswa['nim']) ?>">
        </div>

        <!-- Nama Lengkap -->
        <div class="mb-3">
            <label for="nama_lengkap" class="form-label">Nama Lengkap</label>
            <input type="text" class="form-control" id="nama_lengkap" name="nama_lengkap"
                value="<?= old('nama_lengkap', $mahasiswa['nama_lengkap']) ?>">
        </div>

        <!-- Jenis Kelamin -->
        <div class="mb-3">
            <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
            <select class="form-select" id="jenis_kelamin" name="jenis_kelamin">
                <option value="">-- Pilih --</option>
                <option value="L" <?= old('jenis_kelamin', $mahasiswa['jenis_kelamin']) == 'L' ? 'selected' : '' ?>>Laki-laki</option>
                <option value="P" <?= old('jenis_kelamin', $mahasiswa['jenis_kelamin']) == 'P' ? 'selected' : '' ?>>Perempuan</option>
            </select>
        </div>

        <button type="submit" class="btn btn-success">Update</button>
        <a href="<?= base_url('/mahasiswa') ?>" class="btn btn-secondary">Kembali</a>
    </form>
</div>

<?= $this->endSection() ?>