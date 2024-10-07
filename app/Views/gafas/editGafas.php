<?= $this->extend('layout/templateStart'); ?>

<?= $this->section('content'); ?>

<div class="container">
  <hr>
  <div class="d-flex justify-content-between align-items-center my-3">
    <h3 id="titulo">MODIFICAR DISPOSITIVO</h3>
  </div>

  <!-- Card del formulario -->
  <div class="card shadow-lg">
    <div class="card-body p-5">

      <!-- Mensaje de error -->
      <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger">
          <?= session()->getFlashdata('error'); ?>
        </div>
      <?php endif; ?>

      <!-- Formulario -->
      <form method="POST" action="<?= base_url('gafas/' . $gafas['id']); ?>" enctype="multipart/form-data" class="mx-auto">
        <input type="hidden" name="_method" value="PUT">
        <input type="hidden" name="id" value="<?= esc($gafas['id']); ?>">

        <?= csrf_field(); ?>

        <div class="row g-4">
          <!-- Columna izquierda -->
          <div class="col-md-6">
            <div class="mb-3">
              <label for="oficial_id" class="form-label">ID del Oficial</label>
              <input type="text" value="<?= esc($gafas['oficial_id']); ?>" id="oficial_id" class="form-control" name="oficial_id" required />
            </div>

            <div class="mb-3">
              <label for="device_id" class="form-label">ID del Dispositivo</label>
              <input type="text" value="<?= esc($gafas['device_id']); ?>" id="device_id" class="form-control" name="device_id" required />
            </div>
          </div>
        </div>

        <div class="d-flex justify-content-end mt-5">
          <a href="<?= base_url('gafas') ?>" class="btn btn-warning mx-1">Regresar</a>
          <button type="submit" class="btn btn-success mx-1">Guardar</button>
        </div>
      </form>

      <!-- Errores adicionales -->
      <?php if (session()->getFlashdata('errors')): ?>
        <div class="alert alert-danger my-3" role="alert">
          <?= session()->getFlashdata('errors'); ?>
        </div>
      <?php endif; ?>

    </div>
  </div>
</div>

<?= $this->endSection(); ?>
