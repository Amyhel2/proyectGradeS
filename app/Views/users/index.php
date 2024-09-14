<?= $this->extend('layout/templateStart'); ?>

<?= $this->section('content'); ?>

<div class="container">
    <hr>
    <div class="d-flex justify-content-between align-items-center my-3">
        <h3  id="titulo">USUARIOS</h3>
        <a href="<?= base_url('users/new')?>" class="btn btn-success">
            <i class="fas fa-user-plus"></i> Agregar Usuario
        </a>
    </div>

    <div class="table-responsive shadow-lg p-3 bg-body rounded">
        <table id="exampl" class="table table-striped table-hover table-sm" aria-describedby="titulo">
            <thead class="bg-info table-dark text-center">
                <tr>
                    <th>ID</th>
                    <th>Nombre Completo</th>
                    <th>CI</th>
                    <th>Rango</th>
                    <th>Número de Placa</th>
                    <th>Correo Electrónico</th>
                    <th>Celular</th>
                    <th>Fecha de Nacimiento</th>
                    <th>Sexo</th>
                    <th>Dirección</th>
                    <th>Tipo de Usuario</th>
                    <th>Activo</th>
                    <th>Opciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($usuarios as $usuario): ?>
                <tr class="text-center">
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
                    <td><?= $usuario['activo'] == 1 ? '<span class="badge bg-success">Sí</span>' : '<span class="badge bg-danger">No</span>'; ?></td>
                    <td class="d-flex justify-content-center">
                        <a href="<?= base_url('users/' . $usuario['id'] . '/edit'); ?>" class="btn btn-warning btn-sm mx-1">
                            <i class="fas fa-edit"></i> Editar
                        </a>
                        <button type="button" class="btn btn-danger btn-sm mx-1" data-bs-toggle="modal" data-bs-target="#eliminaModal" data-bs-url="<?= base_url('users/' . $usuario['id']); ?>">
                            <i class="fas fa-trash"></i> Eliminar
                        </button>
                        <button type="button" class="btn btn-secondary btn-sm mx-1" data-bs-toggle="modal" data-bs-target="#borradoLogicoModal" data-bs-url="<?= base_url('users/' . $usuario['id'] . '/soft-delete'); ?>">
                            <i class="fas fa-user-slash"></i> Inactivar
                        </button>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal de eliminación física -->
<div class="modal fade" id="eliminaModal" tabindex="-1" aria-labelledby="eliminaModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="eliminaModalLabel">Eliminar Usuario</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>¿Desea eliminar definitivamente este registro?</p>
            </div>
            <div class="modal-footer">
                <form id="form-elimina" action="" method="POST">
                    <?= csrf_field(); ?>
                    <input type="hidden" name="_method" value="DELETE">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-danger">Eliminar</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal de eliminación lógica -->
<div class="modal fade" id="borradoLogicoModal" tabindex="-1" aria-labelledby="borradoLogicoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-warning text-dark">
                <h5 class="modal-title" id="borradoLogicoModalLabel">Inactivar Usuario</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>¿Desea inactivar este usuario?</p>
            </div>
            <div class="modal-footer">
                <form id="form-borrado-logico" action="" method="POST">
                    <?= csrf_field(); ?>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-warning">Inactivar</button>
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
