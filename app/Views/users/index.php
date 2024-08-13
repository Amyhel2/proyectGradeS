

<?php echo $this->extend('layout/templateStart'); ?>

<?= $this->section('content'); ?>

<h3 class="my-3" id="titulo">Usuarios</h3>

<a href="<?= base_url('users/new')?>" class="btn btn-success">Agregar Nuevo Usuario</a>

<table class="table table-hover table-bordered my-3" aria-describedby="titulo">
    <thead class="table-dark">
        <tr>
            <th scope="col">ID</th>
            <th scope="col">Nombre Completo</th>
            <th scope="col">CI</th>
            <th scope="col">Rango</th>
            <th scope="col">Número de Placa</th>
            <th scope="col">Correo Electrónico</th>
            <th scope="col">Celular</th>
            <!-- Nuevos campos añadidos -->
            <th scope="col">Fecha de Nacimiento</th>
            <th scope="col">Sexo</th>
            <th scope="col">Dirección</th>
            <th scope="col">Tipo de Usuario</th>
            <th scope="col">Activo</th>
            <th scope="col">Opciones</th>
        </tr>
    </thead>

    <tbody>
        <!-- Datos de prueba -->
        <tr>
            <td>1</td>
            <td>JUAN PÉREZ GÓMEZ</td>
            <td>12345678</td>
            <td>Oficial</td>
            <td>ABC123</td>
            <td>juan.perez@example.com</td>
            <td>123456789</td>
            <td>1980-01-01</td>
            <td>Masculino</td>
            <td>Calle Falsa 123</td>
            <td>Admin</td>
            <td>Sí</td>
            <td>
                <a href="<?= base_url('users/edit/1')?>" class="btn btn-warning btn-sm me-2">Editar</a>
                <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" 
                        data-bs-target="#eliminaModal" data-bs-id="1">Eliminar</button>
            </td>
        </tr>
        <tr>
            <td>2</td>
            <td>ANA MARTÍNEZ RAMOS</td>
            <td>87654321</td>
            <td>Sargento</td>
            <td>XYZ789</td>
            <td>ana.martinez@example.com</td>
            <td>987654321</td>
            <td>1990-05-15</td>
            <td>Femenino</td>
            <td>Avenida Siempre Viva 742</td>
            <td>Usuario</td>
            <td>No</td>
            <td>
                <a href="<?= base_url('users/edit/2')?>" class="btn btn-warning btn-sm me-2">Editar</a>
                <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" 
                        data-bs-target="#eliminaModal" data-bs-id="2">Eliminar</button>
            </td>
        </tr>
    </tbody>
</table>

<?= $this->endSection(); ?>
