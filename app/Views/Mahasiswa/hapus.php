<?= $this->extend('layout') ?>

<?= $this->section('title') ?>
Hapus Mahasiswa
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="container mt-5">

    <h2 class="mb-0 text-danger">Hapus Mahasiswa</h2>
    <p>Konfirmasi sebelum menghapus data mahasiswa</p>

    <!-- Tombol kembali -->
    <a href="<?= base_url("mahasiswa") ?>" class="btn btn-secondary mb-3">Kembali</a>

    <!-- Tabel detail mahasiswa -->
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

    <!-- Konfirmasi hapus -->
    <form action="<?= base_url('mahasiswa/delete/' . $mahasiswa['nim']) ?>" method="post" onsubmit="return confirm('Apakah Anda yakin ingin menghapus mahasiswa ini?')">
        <?= csrf_field() ?>

        <input type="hidden" name="_method" value="DELETE">

        <button type="submit" class="btn btn-danger">
            <i class="bi bi-trash"></i> Hapus
        </button>
        <a href="<?= base_url("mahasiswa") ?>" class="btn btn-secondary">Batal</a>
    </form>

</div>

<?= $this->endSection() ?>