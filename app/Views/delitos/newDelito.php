<?= $this->extend('layout/templateStart'); ?>

<?= $this->section('content'); ?>

<div class="container">
  <hr>
  <div class="d-flex justify-content-between align-items-center my-3">
    <h3 id="titulo">AGREGAR NUEVO DELITO</h3>
  </div>

  <!-- Card del formulario -->
  <div class="card shadow-lg">
    <div class="card-body p-5">

      <!-- Mensaje de error -->
      <?php if (session()->getFlashdata('error') !== null): ?>
        <div class="alert alert-danger">
          <?= session()->getFlashdata('error'); ?>
        </div>
      <?php endif; ?>

      <!-- Formulario -->
      <form method="POST" action="<?= base_url('delitos'); ?>" class="mx-auto">
        <?= csrf_field(); ?>

        <div class="row g-4">
          <!-- Columna izquierda -->
          <div class="col-md-6">
            <div class="mb-3">
              <label for="nombreDelito" class="form-label">Nombre del Delito</label>
              <input type="text" value="<?= old('nombreDelito'); ?>" id="nombreDelito" class="form-control" name="nombreDelito" required />
            </div>

            <div class="mb-3">
              <label for="descripcionDelito" class="form-label">Descripción del Delito</label>
              <textarea id="descripcionDelito" class="form-control" name="descripcionDelito" rows="3" required><?= old('descripcionDelito'); ?></textarea>
            </div>
          </div>

          <!-- Columna derecha -->
          <div class="col-md-6">
            <div class="mb-3">
              <label for="tipoDelito" class="form-label">Tipo de Delito</label>
              <select id="tipoDelito" class="form-control" name="tipoDelito" required>
                <option value="Menor">Menor</option>
                <option value="Grave">Grave</option>
                <option value="Muy Grave">Muy Grave</option>
              </select>
            </div>

            <div class="mb-3">
              <label for="fechaRegistro" class="form-label">Fecha de Registro</label>
              <input type="date" id="fechaRegistro" class="form-control" name="fechaRegistro" value="<?= date('Y-m-d'); ?>" required />
            </div>

            <div class="mb-3">
              <label for="activo" class="form-label">Activo</label>
              <select id="activo" class="form-select" name="activo" required>
                <option value="1">Sí</option>
                <option value="0">No</option>
              </select>
            </div>
          </div>
        </div>

        <div class="d-flex justify-content-end mt-5">
          <a href="<?= base_url('delitos') ?>" class="btn btn-warning mx-1">Regresar</a>
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
