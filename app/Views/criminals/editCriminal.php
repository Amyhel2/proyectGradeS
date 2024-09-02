<?= $this->extend('layout/templateStart'); ?>

<?= $this->section('content'); ?>

<h3 class="my-3">Modificar Criminal</h3>

<?php if (session()->getFlashdata('error')): ?>
    <div class="alert alert-danger">
        <?= session()->getFlashdata('error'); ?>
    </div>
<?php endif; ?>

<form method="POST" action="<?= base_url('criminals/' . $criminal['idCriminal']); ?>" enctype="multipart/form-data">
    <input type="hidden" name="_method" value="PUT">
    <input type="hidden" name="id" value="<?= esc($criminal['idCriminal']); ?>">

    <?= csrf_field(); ?>

    <div data-mdb-input-init class="form-outline mb-4">
        <input type="text" value="<?= esc($criminal['nombre']); ?>" id="nombre" class="form-control form-control-lg" name="nombre" required />
        <label class="form-label" for="nombre">Nombres</label>
    </div>

    <div data-mdb-input-init class="form-outline mb-4">
        <input type="text" value="<?= esc($criminal['alias']); ?>" id="alias" class="form-control form-control-lg" name="alias" required />
        <label class="form-label" for="alias">Alias</label>
    </div>

    <div data-mdb-input-init class="form-outline mb-4">
        <input type="text" value="<?= esc($criminal['ci']); ?>" id="ci" class="form-control form-control-lg" name="ci" required />
        <label class="form-label" for="ci">Número de CI</label>
    </div>

    <!-- Sección de la foto actual -->
    <div data-mdb-input-init class="form-outline mb-4">
        <label class="form-label" for="foto_actual">Foto Actual</label>
        <div>
            <img src="<?= base_url('images/' . esc($criminal['foto'])); ?>" alt="Foto actual" width="150">
        </div>
    </div>

    <!-- Campo para subir una nueva foto -->
    <div data-mdb-input-init class="form-outline mb-4">
        <label class="form-label" for="foto">Nueva Foto (opcional)</label>
        <input type="file" id="foto" class="form-control form-control-lg" name="foto" />
    </div>

    <div data-mdb-input-init class="form-outline mb-4">
        <input type="text" value="<?= esc($criminal['delitos']); ?>" id="delitos" class="form-control form-control-lg" name="delitos" required />
        <label class="form-label" for="delitos">Delitos</label>
    </div>

    <div data-mdb-input-init class="form-outline mb-4">
        <input type="text" value="<?= esc($criminal['razon_busqueda']); ?>" id="razon_busqueda" class="form-control form-control-lg" name="razon_busqueda" required />
        <label class="form-label" for="razon_busqueda">Razón de la búsqueda</label>
    </div>

    <div data-mdb-input-init class="form-outline mb-4">
        <label class="form-label" for="activo">Activo</label>
        <select id="activo" class="form-control form-control-lg" name="activo" required>
            <option value="1" <?= $criminal['activo'] == 1 ? 'selected' : ''; ?>>Sí</option>
            <option value="0" <?= $criminal['activo'] == 0 ? 'selected' : ''; ?>>No</option>
        </select>
    </div>

    <div class="d-flex justify-content-end pt-3">
        <div class="col-12">
            <a href="<?= base_url('criminals') ?>" class="btn btn-secondary">Regresar</a>
            <button type="submit" data-mdb-button-init data-mdb-ripple-init class="btn btn-warning btn-lg ms-2">
                Guardar
            </button>
        </div>
    </div>
</form>

<?php if (session()->getFlashdata('error')): ?>
    <div class="alert alert-danger my-3" role="alert">
        <?= session()->getFlashdata('error'); ?>
    </div>
<?php endif; ?>

<?= $this->endSection(); ?>
