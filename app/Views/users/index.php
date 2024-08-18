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
            <th scope="col">Fecha de Nacimiento</th>
            <th scope="col">Sexo</th>
            <th scope="col">Dirección</th>
            <th scope="col">Tipo de Usuario</th>
            <th scope="col">Activo</th>
            <th scope="col">Opciones</th>
        </tr>
    </thead>

    <tbody>
        <?php foreach($usuarios as $usuario): ?>
        <tr>
            <td><?= $usuario['id']; ?></td>
            <td><?= $usuario['nombres'] . ' ' . $usuario['apellido_paterno'] . ' ' . $usuario['apellido_materno']; ?></td>
            <td><?= $usuario['ci']; ?></td>
            <td><?= $usuario['rango']; ?></td>
            <td><?= $usuario['numero_placa']; ?></td>
            <td><?= $usuario['email']; ?></td>
            <td><?= $usuario['celular']; ?></td>
            <td><?= $usuario['fecha_nacimiento']; ?></td>
            <td><?= $usuario['sexo'] == 'M' ? 'Masculino' : 'Femenino'; ?></td>
            <td><?= $usuario['direccion']; ?></td>
            <td><?= $usuario['tipo'] == 'admin' ? 'Admin' : 'Usuario'; ?></td>
            <td><?= $usuario['activo'] == 1 ? 'Sí' : 'No'; ?></td>
            <td>

                <a href="<?= base_url('users/' . $usuario['id']. '/edit'); ?>" class="btn btn-warning btn-sm me-2">Editar</a>

                <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                data-bs-target="#eliminaModal" data-bs-url="<?= base_url('users/' . $usuario['id']); ?>">Eliminar</button>
            </td>

            
        </tr>

        <?php endforeach; ?>

    </tbody>
</table>

<div class="modal fade" id="eliminaModal" tabindex="-1" aria-labelledby="eliminaModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="eliminaModalLabel">Aviso</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>¿Desea eliminar este registro?</p>
                </div>
                <div class="modal-footer">

                    <form id="form-elimina" action="" method="POST">
                    <?= csrf_field(); ?>
            
                        <input type="hidden" name="_method" value="DELETE">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-danger">Eliminar</button>
                    </form>
                </div>
            </div>
        </div>
</div>


<?= $this->endSection(); ?>



<?= $this->section('script');?>

<script>

        const eliminaModal = document.getElementById('eliminaModal')
        if (eliminaModal) {
            eliminaModal.addEventListener('show.bs.modal', event => {
                // Button that triggered the modal
                const button = event.relatedTarget
                // Extract info from data-bs-* attributes
                const url = button.getAttribute('data-bs-url')

                // Update the modal's content.
                const form = eliminaModal.querySelector('#form-elimina')
                form.setAttribute('action', url)
            })
        }
        
</script>

<?= $this->endSection();?>