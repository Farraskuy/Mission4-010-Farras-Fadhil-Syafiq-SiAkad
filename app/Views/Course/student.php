<?= $this->extend('layout') ?>

<?= $this->section('title') ?>
Course Enrollment
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="mb-4">
    <h2 class="fw-bold">Course Enrollment</h2>
    <p class="text-muted">Pilih mata kuliah yang tersedia lalu masukkan ke daftar anda.</p>
</div>

<!-- Pesan sukses -->
<?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-success mb-3">
        <?= session()->getFlashdata('success') ?>
    </div>
<?php endif; ?>
<?php if (session()->getFlashdata('error')): ?>
    <div class="alert alert-danger mb-3">
        <?= session()->getFlashdata('error') ?>
    </div>
<?php endif; ?>

<!-- Available Courses -->
<div class="bg-white p-4 rounded-3 mb-4">
    <h5 class="fw-semibold mb-3">Available Courses</h5>
    <table class="table table-hover align-middle" id="available-table">
        <thead class="table-light">
            <tr>
                <th style="width:50px"></th>
                <th>Nama Course</th>
                <th>Credits</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>
    <button id="btn-enroll" class="btn btn-success">Enroll Selected</button>
</div>

<!-- My Courses -->
<div class="bg-white p-4 rounded-3">
    <h5 class="fw-semibold mb-3">My Courses</h5>
    <div class="mb-2">
        <strong>Total SKS: <span id="total-sks">0</span></strong>
    </div>
    <table class="table table-striped align-middle" id="mycourses-table">
        <thead class="table-light">
            <tr>
                <th style="width:50px"></th>
                <th>Nama Course</th>
                <th>Credits</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>
    <button id="btn-unenroll" class="btn btn-danger">Un-Enroll Selected</button>
</div>

<!-- Modal Konfirmasi -->
<div class="modal fade" id="confirmModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header border-0">
        <h5 class="modal-title">Konfirmasi Aksi</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <p id="confirmMessage"></p>
      </div>
      <div class="modal-footer border-0">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        <button type="button" id="confirmOk" class="btn btn-primary">Ya, Lanjutkan</button>
      </div>
    </div>
  </div>
</div>

<?= $this->endSection() ?>


<?= $this->section('script') ?>
<script>
document.addEventListener("DOMContentLoaded", () => {
    const availableTable = document.querySelector("#available-table tbody");
    const myCoursesTable = document.querySelector("#mycourses-table tbody");
    const totalSksEl = document.querySelector("#total-sks");

    let availableCourses = [];
    let myCourses = [];

    function rowTemplate(course) {
        return `
            <tr>
                <td>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input course-checkbox" value="${course.id}" data-course='${JSON.stringify(course)}' id="cb-${course.id}">
                        <label class="form-check-label" for="cb-${course.id}"></label>
                    </div>
                </td>
                <td>${course.course_name}</td>
                <td>${course.credits}</td>
            </tr>
        `;
    }

    function emptyRow(colspan) {
        return `<tr><td colspan="${colspan}" class="text-center text-muted">Tidak ada data ditemukan</td></tr>`;
    }

    function renderTables() {
        availableTable.innerHTML = availableCourses.length > 0
            ? availableCourses.map(c => rowTemplate(c)).join("")
            : emptyRow(3);

        myCoursesTable.innerHTML = myCourses.length > 0
            ? myCourses.map(c => rowTemplate(c)).join("")
            : emptyRow(3);

        totalSksEl.textContent = myCourses.reduce((sum, c) => sum + parseInt(c.credits), 0);
    }

    function loadCourses() {
        fetch(`${baseURL}course/student`, {
            headers: { "X-Requested-With": "XMLHttpRequest" }
        })
        .then(response => response.json())
        .then(data => {
            availableCourses = data.available || [];
            myCourses = data.taken || [];
            renderTables();
        });
    }

    function getChecked(table) {
        return Array.from(table.querySelectorAll(".course-checkbox:checked"))
            .map(cb => JSON.parse(cb.getAttribute("data-course")));
    }

    // Konfirmasi modal
    function confirmAction(message, callback) {
        const modal = new bootstrap.Modal(document.getElementById("confirmModal"));
        document.getElementById("confirmMessage").textContent = message;

        const okBtn = document.getElementById("confirmOk");
        okBtn.onclick = () => {
            callback();
            modal.hide();
        };

        modal.show();
    }

    document.querySelector("#btn-enroll").addEventListener("click", () => {
        const selected = getChecked(availableTable);
        if (selected.length === 0) return alert("Pilih minimal satu course.");

        confirmAction(`Apakah anda yakin ingin mendaftarkan ${selected.length} course?`, () => {
            const courseIds = selected.map(c => c.id);

            fetch(`${baseURL}course/enroll`, {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-Requested-With": "XMLHttpRequest"
                },
                body: JSON.stringify({ course_ids: courseIds })
            })
            .then(res => res.json())
            .then(res => {
                if (res.success) {
                    myCourses = myCourses.concat(selected);
                    availableCourses = availableCourses.filter(c => !selected.find(s => s.id == c.id));
                    renderTables();
                } else {
                    alert(res.message || "Gagal mendaftar course");
                }
            });
        });
    });

    document.querySelector("#btn-unenroll").addEventListener("click", () => {
        const selected = getChecked(myCoursesTable);
        if (selected.length === 0) return alert("Pilih minimal satu course.");

        confirmAction(`Apakah anda yakin ingin membatalkan ${selected.length} course?`, () => {
            const courseIds = selected.map(c => c.id);

            fetch(`${baseURL}course/unenroll`, {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-Requested-With": "XMLHttpRequest"
                },
                body: JSON.stringify({ course_ids: courseIds })
            })
            .then(res => res.json())
            .then(res => {
                if (res.success) {
                    availableCourses = availableCourses.concat(selected);
                    myCourses = myCourses.filter(c => !selected.find(s => s.id == c.id));
                    renderTables();
                } else {
                    alert(res.message || "Gagal membatalkan course");
                }
            });
        });
    });

    loadCourses();
});
</script>
<?= $this->endSection() ?>
