<?php $validastion = session()->getFlashdata('errors'); ?>

<?= $this->extend('layout') ?>

<?= $this->section('title') ?>
List Course
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="mb-4">
    <h2 class="fw-bold">Course List</h2>
    <p class="text-muted">List of courses</p>
</div>

<div class="d-flex flex-wrap justify-content-between w-100 mb-3 gap-1">
    <a href="<?= base_url('course/tambah') ?>" class="btn btn-success fw-semibold">Add Course</a>
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
        <th>Nama Course</th>
        <th>Credist</th>
        <th class="text-end">Action</th>
    </tr>

    <?php foreach ($courses as $course): ?>
        <tr>
            <td><?= esc($course['course_name']) ?></td>
            <td><?= esc($course['credits']) ?></td>
            <td>
                <div class="d-flex w-100 gap-2 flex-wrap justify-content-end">
                    <a href="<?= base_url('course/detail/' . $course['id']) ?>" class="btn flex-grow-1 flex-lg-grow-0 btn-info">Detail</a>
                    <a href="<?= base_url('course/update/' . $course['id']) ?>" class="btn flex-grow-1 flex-lg-grow-0 btn-warning">Update</a>
                    <button data-bs-target="#modal-delete-<?= $course['id'] ?>" data-bs-toggle="modal" class="btn flex-grow-1 flex-lg-grow-0 btn-danger">Delete</button>
                </div>
            </td>
        </tr>

        <div class="modal fade" id="modal-delete-<?= $course['id'] ?>" aria-hidden="true" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header border-0">
                        <h1 class="modal-title fs-5">Delete Confirmation</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Are you sure you want to delete course <strong>"<?= esc($course['course_name']) ?>"</strong>?
                    </div>
                    <form method="post" action="<?= base_url('course/delete/' . $course['id']) ?>">
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