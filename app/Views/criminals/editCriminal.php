<?= $this->extend('layout/templateStart'); ?>

<?= $this->section('content'); ?>

<div class="container">
    <hr>
    <div class="d-flex justify-content-between align-items-center my-3">
        <h3 id="titulo">MODIFICAR CRIMINAL</h3>
    </div>

    <div class="card shadow-lg">
        <div class="card-body p-5">

            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger">
                    <?= session()->getFlashdata('error'); ?>
                </div>
            <?php endif; ?>

            <form method="POST" action="<?= base_url('criminals/' . $criminal['idCriminal']); ?>" enctype="multipart/form-data" class="mx-auto">
                <input type="hidden" name="_method" value="PUT">
                <input type="hidden" name="id" value="<?= esc($criminal['idCriminal']); ?>">

                <?= csrf_field(); ?>

                <div class="row g-4">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="nombre" class="form-label">Nombres</label>
                            <input type="text" value="<?= esc($criminal['nombre']); ?>" id="nombre" class="form-control" name="nombre" required />
                        </div>

                        <div class="mb-3">
                            <label for="alias" class="form-label">Alias</label>
                            <input type="text" value="<?= esc($criminal['alias']); ?>" id="alias" class="form-control" name="alias" required />
                        </div>

                        <div class="mb-3">
                            <label for="ci" class="form-label">Número de CI</label>
                            <input type="text" value="<?= esc($criminal['ci']); ?>" id="ci" class="form-control" name="ci" required />
                        </div>

                        <!-- Mostrar la foto actual si está disponible -->
                        <?php if (!empty($criminal['foto'])) : ?>
                            <div class="mb-3 text-center">
                                <label class="form-label">Foto Actual:</label>
                                <div class="d-flex justify-content-center">
                                    <img src="<?= esc($criminal['foto']) ?>" alt="Foto de <?= esc($criminal['nombre']) ?>" class="rounded img-thumbnail shadow-sm" style="max-width: 200px; object-fit: cover;">
                                </div>
                            </div>
                        <?php endif; ?>

                        <!-- Campo para cambiar la foto -->
                        <div class="mb-3">
                            <label for="foto" class="form-label">Nueva Foto (opcional)</label>
                            <input type="file" id="foto" class="form-control" name="foto" />
                        </div>
                    </div>

                    <div class="col-md-6">

                        <!-- Selección múltiple de delitos -->
                        <!-- Selección múltiple de delitos -->
<div class="mb-3">
    <label for="delitos" class="form-label">Delitos</label>
    <select name="delitos[]" multiple class="form-control">
        <?php foreach ($todosLosDelitos as $delito): ?>
            <option value="<?= esc($delito['idDelito']); ?>"
                <?= in_array($delito['idDelito'], array_column($delitos, 'delito_id')) ? 'selected' : ''; ?>>
                <?= esc($delito['tipo']); ?>
            </option>
        <?php endforeach; ?>
    </select>
</div>


                        <div class="mb-3">
                            <label for="razon_busqueda" class="form-label">Razón de la búsqueda</label>
                            <input type="text" value="<?= esc($criminal['razon_busqueda']); ?>" id="razon_busqueda" class="form-control" name="razon_busqueda" required />
                        </div>

                        <!-- Selección de estado activo o inactivo -->
                        <div class="mb-3">
                            <label for="activo" class="form-label">Activo</label>
                            <select id="activo" class="form-select" name="activo" required>
                                <option value="1" <?= $criminal['activo'] == 1 ? 'selected' : ''; ?>>Sí</option>
                                <option value="0" <?= $criminal['activo'] == 0 ? 'selected' : ''; ?>>No</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-end mt-5">
                    <a href="<?= base_url('criminals') ?>" class="btn btn-warning mx-1">Regresar</a>
                    <button type="submit" class="btn btn-success mx-1">Guardar</button>
                </div>
            </form>

            <!-- Mostrar los errores si existen -->
            <?php if (session()->getFlashdata('errors') !== null): ?>
                <div class="alert alert-danger my-3" role="alert">
                    <?= session()->getFlashdata('errors'); ?>
                </div>
            <?php endif; ?>

        </div>
    </div>
</div>

<?= $this->endSection(); ?>
