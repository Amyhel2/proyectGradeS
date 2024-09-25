<?php echo $this->extend('layout/templateStart'); ?>

<?= $this->section('content'); ?>

<div class="container">
  <hr>
     <div class="d-flex justify-content-between align-items-center my-3">
        <h3  id="titulo">AGREGAR USUARIO</h3>
    </div>
  <!-- Card del formulario -->
  <div class="card shadow-lg">
    
    <div class="card-body p-5">
      <!-- Mensaje de error -->
      <?php if(session()->getFlashdata('error') !== null) { ?>
        <div class="alert alert-danger">
          <?= session()->getFlashdata('error'); ?>
        </div>
      <?php } ?>

      <!-- Formulario -->
      <form method="POST" action="<?= base_url('users'); ?>" class="mx-auto">
        <?= csrf_field(); ?>

        <div class="row g-4">
          <!-- Columna izquierda -->
          <div class="col-md-6">
            <div class="mb-3">
              <label for="nombres" class="form-label">Nombres</label>
              <input type="text" value="<?= set_value('nombres'); ?>" id="nombres" class="form-control" name="nombres" required />
            </div>

            <div class="mb-3">
              <label for="apellido_paterno" class="form-label">Apellido Paterno</label>
              <input type="text" value="<?= set_value('apellido_paterno'); ?>" id="apellido_paterno" class="form-control" name="apellido_paterno" required />
            </div>

            <div class="mb-3">
              <label for="ci" class="form-label">Número de CI</label>
              <input type="text" value="<?= set_value('ci'); ?>" id="ci" class="form-control" name="ci" required />
            </div>

            <div class="mb-3">
              <label for="fecha_nacimiento" class="form-label">Fecha de Nacimiento</label>
              <input type="date" value="<?= set_value('fecha_nacimiento'); ?>" id="fecha_nacimiento" class="form-control" name="fecha_nacimiento" required />
            </div>

            <div class="mb-3">
              <label for="rango" class="form-label">Rango</label>
              <input type="text" value="<?= set_value('rango'); ?>" id="rango" class="form-control" name="rango" required />
            </div>

            <div class="mb-3">
              <label for="numero_placa" class="form-label">Número de Placa</label>
              <input type="text" value="<?= set_value('numero_placa'); ?>" id="numero_placa" class="form-control" name="numero_placa" required />
            </div>
          </div>

          <!-- Columna derecha -->
          <div class="col-md-6">
            <div class="mb-3">
              <label for="apellido_materno" class="form-label">Apellido Materno</label>
              <input type="text" value="<?= set_value('apellido_materno'); ?>" id="apellido_materno" class="form-control" name="apellido_materno" required />
            </div>

            <div class="mb-3">
              <label for="direccion" class="form-label">Dirección</label>
              <input type="text" value="<?= set_value('direccion'); ?>" id="direccion" class="form-control" name="direccion" required />
            </div>

            <div class="mb-3">
              <label for="celular" class="form-label">Celular</label>
              <input type="text" value="<?= set_value('celular'); ?>" id="celular" class="form-control" name="celular" required />
            </div>

            <div class="mb-3">
              <label for="email" class="form-label">Correo Electrónico</label>
              <input type="email" value="<?= set_value('email'); ?>" id="email" class="form-control" name="email" required />
            </div>

            <div class="mb-3">
              <label for="user" class="form-label">Usuario</label>
              <input type="text" value="<?= set_value('user'); ?>" id="user" class="form-control" name="user" required />
            </div>

            <div class="mb-3">
              <label for="password" class="form-label">Contraseña</label>
              <input type="password" id="password" class="form-control" name="password" required />
            </div>

            <div class="mb-3">
              <label for="repassword" class="form-label">Confirmar Contraseña</label>
              <input type="password" id="repassword" class="form-control" name="repassword" required />
            </div>
          </div>
        </div>

        <div class="row g-4 mt-4">
          <div class="col-md-6">
            <div class="mb-3">
              <label for="tipo" class="form-label">Tipo de Usuario</label>
              <select id="tipo" class="form-select" name="tipo" required>
                <option value="admin">Administrador</option>
                <option value="user">Usuario</option>
              </select>
            </div>
          </div>

          <div class="col-md-6">
            <h6 class="mb-2">Género:</h6>
            <div class="d-flex">
              <div class="form-check me-3">
                <input class="form-check-input" type="radio" name="sexo" id="sexoM" value="M" required />
                <label class="form-check-label" for="sexoM">Hombre</label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="radio" name="sexo" id="sexoF" value="F" required />
                <label class="form-check-label" for="sexoF">Mujer</label>
              </div>
            </div>
          </div>
        </div>

        <div class="d-flex justify-content-end mt-5">
          <a href="<?= base_url('users') ?>" class="btn btn-warning mx-1">Regresar</a>
          <button type="submit" class="btn btn-success  mx-1">Registrar</button>
        </div>
      </form>

      <!-- Errores adicionales -->
      <?php if(session()->getFlashdata('errors') !== null): ?>
        <div class="alert alert-danger my-3" role="alert">
          <?= session()->getFlashdata('errors'); ?>
        </div>
      <?php endif; ?>
    </div>
  </div>
</div>

<?= $this->endSection(); ?>

