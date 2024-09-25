<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
   
</head>

<body>
<div class="container-fluid">
<h3 class="my-3">Configuración de Usuario</h3>

<div class="card mb-4">
    <div class="card-header bg-primary text-white">Cambiar Contraseña</div>
    <div class="card-body">
        <form action="<?= base_url('change-password') ?>" method="POST">
            <?= csrf_field(); ?>

            <div class="mb-3">
                <label for="current_password" class="form-label">Contraseña Actual</label>
                <input type="password" class="form-control" id="current_password" name="current_password" required>
            </div>

            <div class="mb-3">
                <label for="new_password" class="form-label">Nueva Contraseña</label>
                <input type="password" class="form-control" id="new_password" name="new_password" required>
            </div>

            <div class="mb-3">
                <label for="confirm_password" class="form-label">Confirmar Nueva Contraseña</label>
                <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
            </div>

            <button type="submit" class="btn btn-success">Actualizar Contraseña</button>

            <!-- Errores adicionales -->
<?php if(session()->getFlashdata('errors') !== null): ?>
        <div class="alert alert-danger my-3" role="alert">
          <?= session()->getFlashdata('errors'); ?>
        </div>
      <?php endif; ?>
        </form>
    </div>

   
    

</div>

<div class="card mb-4">
    <div class="card-header bg-secondary text-white">Cerrar Sesión</div>
    <div class="card-body">
        <a href="<?= base_url('logout') ?>" class="btn btn-danger">Cerrar Sesión</a>
    </div>
</div>

<!-- Opcional: Actualización de Información Personal -->

</div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous">
    </script>

</body>
</html>






