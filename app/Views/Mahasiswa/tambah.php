<?php $validation = session()->getFlashdata('errors'); ?>

<?= $this->extend('layout') ?>

<?= $this->section('title') ?>
Tambah Mahasiswa
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="container mt-5">

    <h2 class="mb-0">Form Input Mahasiswa</h2>
    <p>Formulir untuk menambah data mahasiswa</p>
    <a href="<?= base_url("mahasiswa") ?>" class="btn btn-secondary">Kembali</a>
    
    <br>
    <br>
    <br>

    <div class="card-body">

        <!-- Form -->
        <form action="<?= base_url('mahasiswa/tambah') ?>" method="post">
            <?= csrf_field() ?>

            <!-- NIM -->
            <div class="mb-3">
                <label for="nim" class="form-label">NIM</label>
                <input type="text"
                    class="form-control <?= $validation && $validation['nim'] ? 'is-invalid' : '' ?>"
                    id="nim" name="nim" value="<?= old('nim') ?>">
                <?php if ($validation && $validation['nim']): ?>
                    <div class="invalid-feedback">
                        <?= $validation['nim'] ?>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Nama Lengkap -->
            <div class="mb-3">
                <label for="nama_lengkap" class="form-label">Nama Lengkap</label>
                <input type="text"
                    class="form-control <?= $validation && $validation['nama_lengkap'] ? 'is-invalid' : '' ?>"
                    id="nama_lengkap" name="nama_lengkap" value="<?= old('nama_lengkap') ?>">
                <?php if ($validation && $validation['nama_lengkap']): ?>
                    <div class="invalid-feedback">
                        <?= $validation['nama_lengkap'] ?>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Jenis Kelamin -->
            <div class="mb-3">
                <label class="form-label">Jenis Kelamin</label>
                <select name="jenis_kelamin" class="form-select <?= $validation && $validation['jenis_kelamin'] ? 'is-invalid' : '' ?>">
                    <option value="">-- Pilih --</option>
                    <option value="L" <?= old('jenis_kelamin') === 'L' ? 'selected' : '' ?>>Laki-laki</option>
                    <option value="P" <?= old('jenis_kelamin') === 'P' ? 'selected' : '' ?>>Perempuan</option>
                </select>
                <?php if ($validation && $validation['jenis_kelamin']): ?>
                    <div class="invalid-feedback">
                        <?= $validation['jenis_kelamin'] ?>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Tombol -->
            <div class="d-flex justify-content-end">
                <button type="reset" class="btn btn-secondary me-2">Reset</button>
                <button type="submit" class="btn btn-success">Simpan</button>
            </div>

        </form>
    </div>

</div>

<?= $this->endSection() ?>