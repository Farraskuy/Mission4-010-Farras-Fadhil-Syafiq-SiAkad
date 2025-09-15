<?= $this->extend('layout') ?>

<?= $this->section('title') ?>
Add Course
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="mb-5">
    <h2 class="fw-bold">Add Course</h2>
    <p class="text-muted">Form to add course list</p>
    <a href="<?= base_url("course") ?>" class="btn btn-secondary">Back</a>
</div>

<form action="<?= base_url('course/tambah') ?>" method="post">
    <?= csrf_field() ?>

    <div class="mb-3">
        <label for="course_name" class="form-label">Course Name</label>
        <input type="text"
            class="form-control <?= isset($validation['course_name']) ? 'is-invalid' : '' ?>"
            id="course_name" name="course_name" value="<?= old('course_name') ?>">
        <?php if (isset($validation['course_name'])): ?>
            <div class="invalid-feedback">
                <?= $validation['course_name'] ?>
            </div>
        <?php endif; ?>
    </div>

    <div class="mb-3">
        <label for="credits" class="form-label">Credits</label>
        <input type="number" maxlength="1"
            class="form-control <?= isset($validation['credits']) ? 'is-invalid' : '' ?>"
            id="credits" name="credits" value="<?= old('credits') ?>">
        <?php if (isset($validation['credits'])): ?>
            <div class="invalid-feedback">
                <?= $validation['credits'] ?>
            </div>
        <?php endif; ?>
    </div>

    <!-- Tombol -->
    <div class="d-flex justify-content-end">
        <button type="reset" class="btn btn-secondary me-2">Reset</button>
        <button type="submit" class="btn btn-success">Add Course</button>
    </div>
</form>


<?= $this->endSection() ?>