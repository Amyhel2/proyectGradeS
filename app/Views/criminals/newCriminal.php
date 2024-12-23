<?= $this->extend('layout/templateStart'); ?>

<?= $this->section('content'); ?>

<div class="container">
  <hr>
  <div class="d-flex justify-content-between align-items-center my-3">
    <h3 id="titulo">AGREGAR NUEVO CRIMINAL</h3>
  </div>

  <!-- Card del formulario -->
  <div class="card shadow-lg">
    <div class="card-body p-5">

      <!-- Mensaje de error general -->
      <?php if (session()->getFlashdata('error') !== null): ?>
        <div class="alert alert-danger">
          <?= session()->getFlashdata('error'); ?>
        </div>
      <?php endif; ?>

      <!-- Formulario -->
      <form method="POST" action="<?= base_url('criminals'); ?>" enctype="multipart/form-data" class="mx-auto">
        <?= csrf_field(); ?>

        <div class="row g-4">
          <!-- Columna izquierda -->
          <div class="col-md-6">
            <div class="mb-3">
              <label for="nombre" class="form-label">Nombres</label>
              <input type="text" value="<?= old('nombre'); ?>" id="nombre" class="form-control" name="nombre" required />
              <?php if (isset($validation) && $validation->hasError('nombre')): ?>
                <div class="text-danger"><?= $validation->getError('nombre'); ?></div>
              <?php endif; ?>
            </div>

            <div class="mb-3">
              <label for="alias" class="form-label">Alias</label>
              <input type="text" value="<?= old('alias'); ?>" id="alias" class="form-control" name="alias" required />
              <?php if (isset($validation) && $validation->hasError('alias')): ?>
                <div class="text-danger"><?= $validation->getError('alias'); ?></div>
              <?php endif; ?>
            </div>

            <div class="mb-3">
              <label for="ci" class="form-label">Número de CI</label>
              <input type="text" value="<?= old('ci'); ?>" id="ci" class="form-control" name="ci" required />
              <?php if (isset($validation) && $validation->hasError('ci')): ?>
                <div class="text-danger"><?= $validation->getError('ci'); ?></div>
              <?php endif; ?>
            </div>

            <!-- Fotos: múltiple selección -->
            <div class="mb-3">
              <label for="foto" class="form-label">Fotos</label>
              <input type="file" id="foto" class="form-control" name="fotos[]" multiple required />
              <small class="text-muted">Formatos permitidos: JPG, JPEG, PNG. Tamaño máximo: 2MB por foto.</small>
              <?php if (isset($validation) && $validation->hasError('fotos')): ?>
                <div class="text-danger"><?= $validation->getError('fotos'); ?></div>
              <?php endif; ?>
            </div>
          </div>

          <!-- Columna derecha -->
          <div class="col-md-6">
            <div class="mb-3">
              <label for="delitos" class="form-label">Delitos</label>
              <select id="delitos" class="form-control" name="delitos[]" multiple size="3" required>
                <?php foreach ($delitos as $delito): ?>
                  <option value="<?= esc($delito['idDelito']); ?>" <?= in_array($delito['idDelito'], old('delitos', [])) ? 'selected' : ''; ?>>
                    <?= esc($delito['tipo']); ?>
                  </option>
                <?php endforeach; ?>
              </select>
              <small class="text-muted">Puedes seleccionar múltiples delitos usando Ctrl (Cmd en Mac).</small>
              <?php if (isset($validation) && $validation->hasError('delitos')): ?>
                <div class="text-danger"><?= $validation->getError('delitos'); ?></div>
              <?php endif; ?>
            </div>

            <div class="mb-3">
              <label for="razon_busqueda" class="form-label">Razón de Búsqueda</label>
              <textarea id="razon_busqueda" class="form-control" name="razon_busqueda" rows="3" required><?= old('razon_busqueda'); ?></textarea>
              <?php if (isset($validation) && $validation->hasError('razon_busqueda')): ?>
                <div class="text-danger"><?= $validation->getError('razon_busqueda'); ?></div>
              <?php endif; ?>
            </div>

            <div class="mb-3">
              <label for="activo" class="form-label">Activo</label>
              <select id="activo" class="form-select" name="activo" required>
                  <option value="1">Sí</option>
                  <option value="0">No</option>
              </select>
              <?php if (isset($validation) && $validation->hasError('activo')): ?>
                <div class="text-danger"><?= $validation->getError('activo'); ?></div>
              <?php endif; ?>
            </div>
          </div>
        </div>

        <div class="d-flex justify-content-end mt-5">
          <a href="<?= base_url('criminals') ?>" class="btn btn-warning mx-1">Regresar</a>
          <button type="submit" class="btn btn-success mx-1">Guardar</button>
        </div>
      </form>

      <!-- Errores adicionales -->
      <?php if (session()->getFlashdata('errors') !== null): ?>
        <div class="alert alert-danger my-3" role="alert">
          <?= session()->getFlashdata('errors'); ?>
        </div>
      <?php endif; ?>
    </div>
  </div>
</div>

<?= $this->endSection(); ?>
