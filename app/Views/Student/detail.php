<?= $this->extend('layout') ?>

<?= $this->section('title') ?>
Detail Student
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="mb-5">
    <h2 class="fw-bold">Detail Student</h2>
    <p class="text-muted">Detail of student data</p>
    <a href="<?= base_url("student") ?>" class="btn btn-secondary">Back</a>
</div>

<h6 class="fw-bold mb-3">Student Data</h6>
<table class="table table-bordered table-striped">
    <tbody>
        <tr>
            <th style="width: 200px;">Full Name</th>
            <td><?= esc($student['full_name']) ?></td>
        </tr>
        <tr>
            <th>NIM</th>
            <td><?= esc($student['nim']) ?></td>
        </tr>
        <tr>
            <th>Tanggal Lahir</th>
            <td><?= esc($student['tanggal_lahir']) ?></td>
        </tr>
        <tr>
            <th>Entry Year</th>
            <td><?= esc($student['entry_year']) ?></td>
        </tr>
        <tr>
            <th>Email</th>
            <td><?= esc($student['email']) ?></td>
        </tr>
        <tr>
            <th>Username</th>
            <td><?= esc($student['username']) ?></td>
        </tr>
    </tbody>
</table>

<?= $this->endSection() ?>