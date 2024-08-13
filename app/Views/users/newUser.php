
<?php echo $this->extend('layout/templateStart'); ?>

<?= $this->section('content'); ?>

<h3 class="my-3">Nuevo Usuario</h3>
<?php if(session()->getFlashdata('errors')!==null){?>

<?php }?>

<form action="<?= base_url('users');?>" class="row g-3" method="post" autocomplete="off">
    <div class="col-md-6">
        <label for="nombres" class="form-label">Nombres</label>
        <input type="text" class="form-control" id="nombres" name="nombres" required autofocus>
    </div>

    <div class="col-md-6">
        <label for="apellido_paterno" class="form-label">Apellido Paterno</label>
        <input type="text" class="form-control" id="apellido_paterno" name="apellido_paterno" required>
    </div>

    <div class="col-md-6">
        <label for="apellido_materno" class="form-label">Apellido Materno</label>
        <input type="text" class="form-control" id="apellido_materno" name="apellido_materno" required>
    </div>

    <div class="col-md-6">
        <label for="ci" class="form-label">CI</label>
        <input type="text" class="form-control" id="ci" name="ci" required>
    </div>

    <div class="col-md-6">
        <label for="rango" class="form-label">Rango</label>
        <input type="text" class="form-control" id="rango" name="rango" required>
    </div>

    <div class="col-md-6">
        <label for="numero_placa" class="form-label">Número de Placa</label>
        <input type="text" class="form-control" id="numero_placa" name="numero_placa" required>
    </div>

    <div class="col-md-6">
        <label for="fecha_nacimiento" class="form-label">Fecha de Nacimiento</label>
        <input type="date" class="form-control" id="fecha_nacimiento" name="fecha_nacimiento" required>
    </div>

    <div class="col-md-6">
        <label for="sexo" class="form-label">Sexo</label>
        <select class="form-select" id="sexo" name="sexo" required>
            <option value="">Seleccionar</option>
            <option value="M">Masculino</option>
            <option value="F">Femenino</option>
        </select>
    </div>

    <div class="col-md-6">
        <label for="direccion" class="form-label">Dirección</label>
        <input type="text" class="form-control" id="direccion" name="direccion">
    </div>

    <div class="col-md-6">
        <label for="celular" class="form-label">Celular</label>
        <input type="text" class="form-control" id="celular" name="celular">
    </div>

    <div class="col-md-6">
        <label for="email" class="form-label">Correo Electrónico</label>
        <input type="email" class="form-control" id="email" name="email" required>
    </div>

    <div class="col-md-6">
        <label for="user" class="form-label">Nombre de Usuario</label>
        <input type="text" class="form-control" id="user" name="user" required>
    </div>

    <div class="col-md-6">
        <label for="password" class="form-label">Contraseña</label>
        <input type="password" class="form-control" id="password" name="password" required>
    </div>

    <div class="col-md-6">
        <label for="tipo" class="form-label">Tipo de Usuario</label>
        <select class="form-select" id="tipo" name="tipo" required>
            <option value="">Seleccionar</option>
            <option value="admin">Administrador</option>
            <option value="user">Usuario</option>
        </select>
    </div>

    <div class="col-12">
        <a href="<?= base_url('users');?>" class="btn btn-secondary">Regresar</a>
        <button type="submit" class="btn btn-primary">Guardar</button>
    </div>
</form>



<?= $this->endSection(); ?>