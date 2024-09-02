
<?= $this->extend('layout/templateStart'); ?>

<?= $this->section('content'); ?>

<h3 class="my-3">Agregar Nuevo Criminal</h3>

<?php if (session()->getFlashdata('errors') !== null): ?>
    <div class="alert alert-danger">
        <?= session()->getFlashdata('errors'); ?>
    </div>
<?php endif; ?>

<form method="POST" action="<?= base_url('criminals'); ?>" enctype="multipart/form-data">
    <?= csrf_field(); ?>

    <div class="form-outline mb-4">
        <input type="text" id="nombre" class="form-control" name="nombre" value="<?= old('nombre'); ?>" required />
        <label class="form-label" for="nombre">Nombres</label>
    </div>

    <div class="form-outline mb-4">
        <input type="text" id="alias" class="form-control" name="alias" value="<?= old('alias'); ?>" required />
        <label class="form-label" for="alias">Alias</label>
    </div>

    <div class="form-outline mb-4">
        <input type="text" id="ci" class="form-control" name="ci" value="<?= old('ci'); ?>" required />
        <label class="form-label" for="ci">Número de CI</label>
    </div>

    <div class="mb-4">
        <label class="form-label" for="foto">Foto</label>
        <input type="file" id="foto" class="form-control" name="foto" required />
        <small class="text-muted">Formatos permitidos: JPG, JPEG, PNG. Tamaño máximo: 2MB.</small>
    </div>

    <div class="form-outline mb-4">
        <textarea id="delitos" class="form-control" name="delitos" rows="3" required><?= old('delitos'); ?></textarea>
        <label class="form-label" for="delitos">Delitos</label>
    </div>

    <div class="form-outline mb-4">
        <textarea id="razon_busqueda" class="form-control" name="razon_busqueda" rows="3" required><?= old('razon_busqueda'); ?></textarea>
        <label class="form-label" for="razon_busqueda">Razón de Búsqueda</label>
    </div>

    <div class="d-flex justify-content-end">
        <a href="<?= base_url('criminals'); ?>" class="btn btn-secondary me-2">Regresar</a>
        <button type="submit" class="btn btn-success">Guardar</button>
    </div>
</form>

<?= $this->endSection(); ?>
