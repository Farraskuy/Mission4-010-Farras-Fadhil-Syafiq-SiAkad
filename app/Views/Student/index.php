<?php $validastion = session()->getFlashdata('errors'); ?>

<?= $this->extend('layout') ?>

<?= $this->section('title') ?>
List Student
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="mb-4">
    <h2 class="fw-bold">Student List</h2>
    <p class="text-muted">List of students</p>
</div>

<div class="d-flex flex-wrap justify-content-between w-100 mb-3 gap-1">
    <a href="<?= base_url('student/tambah') ?>" class="btn btn-success fw-semibold">Add Student</a>
    <form class="d-flex gap-3" method="get">
        <input value="<?= service('request')->getGet('keyword') ?>" type="text" name="keyword" class="form-control form-text m-0">
        <button type="submit" class="btn btn-primary">Search</button>
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
        <th>Nama Lengkap</th>
        <th>Tanggal Lahir</th>
        <th>Entry Date</th>
        <th class="text-end">Action</th>
    </tr>
    <?php foreach ($students as $student): ?>
        <tr>
            <td><?= esc($student['nim']) ?></td>
            <td><?= esc($student['full_name']) ?></td>
            <td><?= esc(date('d M Y', strtotime($student['tanggal_lahir']))) ?></td>
            <td><?= esc(date('Y', strtotime($student['entry_year']))) ?></td>
            <td>
                <div class="d-flex w-100 gap-2 flex-wrap justify-content-end">
                    <a href="<?= base_url('student/detail/' . $student['nim']) ?>" class="btn flex-grow-1 flex-lg-grow-0 btn-info">Detail</a>
                    <a href="<?= base_url('student/update/' . $student['nim']) ?>" class="btn flex-grow-1 flex-lg-grow-0 btn-warning">Update</a>
                    <button data-bs-target="#modal-delete-<?= $student['nim'] ?>" data-bs-toggle="modal" class="btn flex-grow-1 flex-lg-grow-0 btn-danger">Delete</button>
                </div>
            </td>
        </tr>

        <div class="modal fade" id="modal-delete-<?= $student['nim'] ?>" aria-hidden="true" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header border-0">
                        <h1 class="modal-title fs-5">Delete Confirmation</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Are you sure you want to delete student <strong>"<?= esc($student['full_name']) ?>"</strong>?
                    </div>
                    <form method="post" action="<?= base_url('student/delete/' . $student['nim']) ?>">
                        <?= csrf_field() ?>
                        <input type="hidden" name="_method" value="DELETE">
                        <div class="modal-footer border-0">
                            <button type="button" class="btn  btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-outline-danger">Yes, Delete</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>


    <?php endforeach; ?>
</table>

<?= $this->endSection() ?>