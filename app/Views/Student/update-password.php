<?= $this->extend('layout') ?>

<?= $this->section('title') ?>
Update Password Student
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="mb-5">
    <h2 class="fw-bold">Update Password</h2>
    <p class="text-muted">Form to update student password</p>
    <a href="<?= base_url("student/update/{$student['nim']}") ?>" class="btn btn-secondary">Back</a>
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

<br>
<hr>
<br>

<form action="<?= base_url("student/update/password/{$student['nim']}") ?>" method="post">
    <?= csrf_field() ?>
    <!-- <?= d($validation) ?> -->

    <input type="hidden" name="_method" value="PUT">

    <div class="mb-3">
        <label for="password" class="form-label">Password</label>
        <input type="password"
            class="form-control <?= isset($validation['password']) ? 'is-invalid' : '' ?>"
            id="password" name="password" value="<?= old('password') ?>">
        <?php if (isset($validation['password'])): ?>
            <div class="invalid-feedback">
                <?= $validation['password'] ?>
            </div>
        <?php endif; ?>
    </div>

    <div class="mb-3">
        <label for="repeat-password" class="form-label">Repeat Password</label>
        <input type="password"
            class="form-control <?= isset($validation['repeat-password']) ? 'is-invalid' : '' ?>"
            id="repeat-password" name="repeat-password" value="<?= old('repeat-password') ?>">
        <?php if (isset($validation['repeat-password'])): ?>
            <div class="invalid-feedback">
                <?= $validation['repeat-password'] ?>
            </div>
        <?php endif; ?>
    </div>

    <!-- Tombol -->
    <div class="d-flex justify-content-end">
        <button type="reset" class="btn btn-secondary me-2">Reset</button>
        <button type="submit" class="btn btn-warning">Update Password</button>
    </div>
</form>


<?= $this->endSection() ?>