<?= $this->extend('layout') ?>

<?= $this->section('title') ?>
Detail Course
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="mb-5">
    <h2 class="fw-bold">Detail Course</h2>
    <p class="text-muted">Detail of course data</p>
    <a href="<?= base_url("course") ?>" class="btn btn-secondary">Back</a>
</div>

<h6 class="fw-bold mb-3">Course Data</h6>
<table class="table table-bordered table-striped">
    <tbody>
        <tr>
            <th style="width: 200px;">Course Name</th>
            <td><?= esc($course['course_name']) ?></td>
        </tr>
        <tr>
            <th>Credits</th>
            <td><?= esc($course['credits']) ?></td>
        </tr>
    </tbody>
</table>

<?= $this->endSection() ?>