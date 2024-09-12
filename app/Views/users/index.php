<?= $this->extend('layout/templateStart'); ?>

<?= $this->section('content'); ?>

<h3 class="my-3" id="titulo">Usuarios</h3>

<a href="<?= base_url('users/new')?>" class="btn btn-success mb-3">Agregar</a>

<div class="table-responsive">
    <table id="usersTable" class="table table-hover table-bordered" aria-describedby="titulo">
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
                
                <td class="d-flex flex-column">
                    <a href="<?= base_url('users/' . $usuario['id'] . '/edit'); ?>" class="btn btn-warning btn-sm mb-2">Editar</a>

                    <button type="button" class="btn btn-danger btn-sm mb-2" data-bs-toggle="modal" data-bs-target="#eliminaModal" data-bs-url="<?= base_url('users/' . $usuario['id']); ?>">Eliminacion física</button>

                    <button type="button" class="btn btn-secondary btn-sm" data-bs-toggle="modal" data-bs-target="#borradoLogicoModal" data-bs-url="<?= base_url('users/' . $usuario['id'] . '/soft-delete'); ?>">Eliminacion lógica</button>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<!-- Modal de eliminación física -->
<div class="modal fade" id="eliminaModal" tabindex="-1" aria-labelledby="eliminaModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="eliminaModalLabel">Aviso</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>¿Desea eliminar definitivamente este registro de la base de datos?</p>
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

<!-- Modal de eliminación lógica -->
<div class="modal fade" id="borradoLogicoModal" tabindex="-1" aria-labelledby="borradoLogicoModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="borradoLogicoModalLabel">Aviso</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>¿Desea deshabilitar este registro?</p>
            </div>
            <div class="modal-footer">
                <form id="form-borrado-logico" action="" method="POST">
                    <?= csrf_field(); ?>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-warning">Borrar Lógicamente</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>

<?= $this->section('script');?>

<script>
const eliminaModal = document.getElementById('eliminaModal');
const borradoLogicoModal = document.getElementById('borradoLogicoModal');

if (eliminaModal) {
    eliminaModal.addEventListener('show.bs.modal', event => {
        const button = event.relatedTarget;
        const url = button.getAttribute('data-bs-url');
        const form = eliminaModal.querySelector('#form-elimina');
        form.setAttribute('action', url);
    });
}

if (borradoLogicoModal) {
    borradoLogicoModal.addEventListener('show.bs.modal', event => {
        const button = event.relatedTarget;
        const url = button.getAttribute('data-bs-url');
        const form = borradoLogicoModal.querySelector('#form-borrado-logico');
        form.setAttribute('action', url);
    });
}

$(document).ready(function() {
    $('#usersTable').DataTable({
        "responsive": true,
        "autoWidth": false,
        "order": [],
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.11.5/i18n/Spanish.json"
        }
    });
});
</script>

<?= $this->endSection(); ?>

