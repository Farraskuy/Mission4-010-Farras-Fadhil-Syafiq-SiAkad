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
    <form class="d-flex gap-3 search" method="get">
        <input value="<?= service('request')->getGet('keyword') ?>" type="text" name="keyword" class="form-control form-text m-0">
        <button type="submit" class="btn btn-primary text-nowrap">Search</button>
    </form>
</div>

<!-- Pesan sukses -->
<?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-success mb-3">
        <?= session()->getFlashdata('success') ?>
    </div>
<?php endif; ?>

<div class="bg-white p-4 rounded-3">
    <table class="table table-hover align-middle">
        <thead class="table-light">
            <tr>
                <th>NIM</th>
                <th>Nama Lengkap</th>
                <th>Tanggal Lahir</th>
                <th>Entry Year</th>
                <th class="text-end">Action</th>
            </tr>
        </thead>

        <tbody id="tbody"></tbody>

        <script>
            let rowTableDataTemplate = (data) => {
                return `
                    <td>${data.nim}</td>
                    <td>${data.full_name}</td>
                    <td>${data.tanggal_lahir}</td>
                    <td>${data.entry_year}</td>
                    <td>
                        <div class="d-flex gap-2 flex-wrap justify-content-end">
                            <a href="${baseURL}student/detail/${data.nim}" class="btn btn-info btn-sm">Detail</a>
                            <a href="${baseURL}student/update/${data.nim}" class="btn btn-warning btn-sm">Update</a>
                            <!-- Delete Trigger -->
                            <button class="btn btn-danger btn-sm"
                                data-bs-toggle="modal"
                                data-bs-target="#modal-delete-${data.nim}">
                                Delete
                            </button>
                        </div>

                        <div class="modal fade" id="modal-delete-${data.nim}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header border-0">
                                        <h5 class="modal-title">Delete Confirmation</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        Are you sure you want to delete student
                                        <strong>"${data.full_name}"</strong>?
                                    </div>
                                    <form method="post" action="${baseURL}student/delete/${data.nim}">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <div class="modal-footer border-0">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                            <button type="submit" class="btn btn-outline-danger">Yes, Delete</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </td>
                `;
            };
        </script>

    </table>

</div>


<?= $this->endSection() ?>