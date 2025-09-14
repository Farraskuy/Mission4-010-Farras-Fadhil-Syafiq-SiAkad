<?= $this->extend('layout') ?>

<?= $this->section('title') ?>
Detail Mahasiswa
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="container mt-5">

    <h2 class="mb-0">Detail Mahasiswa</h2>
    <p>Informasi lengkap mahasiswa</p>

    <!-- Tombol kembali -->
    <a href="<?= base_url("mahasiswa") ?>" class="btn btn-secondary mb-3">Kembali</a>

    <!-- Tabel detail -->
    <table class="table table-bordered">
        <tbody>
            <tr>
                <th>NIM</th>
                <td><?= esc($mahasiswa['nim']) ?></td>
            </tr>
            <tr>
                <th>Nama Lengkap</th>
                <td><?= esc($mahasiswa['nama_lengkap']) ?></td>
            </tr>
            <tr>
                <th>Jenis Kelamin</th>
                <td><?= $mahasiswa['jenis_kelamin'] == 'L' ? 'Laki-laki' : 'Perempuan' ?></td>
            </tr>
        </tbody>
    </table>

</div>

<?= $this->endSection() ?>