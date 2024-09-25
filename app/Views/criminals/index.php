<?= $this->extend('layout/templateStart'); ?>

<?= $this->section('content'); ?>

<div class="container ">
    <hr>
    <div class="d-flex justify-content-between align-items-center my-3">
        <h3 id="titulo">CRIMINALES</h3>
        <a href="<?= base_url('criminals/new') ?>" class="btn btn-success">
            <i class="fas fa-user-plus"></i> Agregar Criminal
        </a>
    </div>

    <div class="table-responsive shadow-lg p-3 bg-body  rounded">
        <table id="example2" class="table table-striped table-hover table-sm" aria-describedby="titulo">
            <thead class="bg-info table-dark text-center">
                <tr>
                    <th>ID</th>
                    <th>Nombre Completo</th>
                    <th>Alias</th>
                    <th>CI</th>
                    <th>Foto</th>
                    <th>Delitos</th>
                    <th>Razón de Búsqueda</th>
                    <th>Activo</th>
                    <th>Opciones</th>
                    
                </tr>
            </thead>
            <tbody>
                <?php foreach($criminales as $criminal): ?>
                <tr class="text-center">
                    <td><?= $criminal['idCriminal']; ?></td>
                    <td><?= esc($criminal['nombre']); ?></td>
                    <td><?= esc($criminal['alias']); ?></td>
                    <td><?= esc($criminal['ci']); ?></td>
                    <td>
    <?php if (!empty($criminal['foto'])): ?>
        <img src="<?= esc($criminal['foto']); ?>" alt="<?= esc($criminal['nombre']); ?>" class="img-thumbnail" style="width: 100px; height: 100px; object-fit: cover;">
    <?php else: ?>
        <img src="<?= base_url('images/perfil.jpg'); ?>" alt="Foto por defecto" class="img-thumbnail" style="width: 100px; height: 100px; object-fit: cover;">
    <?php endif; ?>
</td>

                    <td><?= esc($criminal['delitos']); ?></td>
                    <td><?= esc($criminal['razon_busqueda']); ?></td>
                    <td><?= $criminal['activo'] == 1 ? '<span class="badge bg-success">Sí</span>' : '<span class="badge bg-danger">No</span>'; ?></td>
                    <td class="d-flex justify-content-center">
                        <a href="<?= base_url('criminals/' . $criminal['idCriminal'] . '/edit'); ?>" class="btn btn-warning btn-sm mx-1">
                            <i class="fas fa-edit"></i> Editar
                        </a>
                        <button type="button" class="btn btn-danger btn-sm mx-1" data-bs-toggle="modal" data-bs-target="#eliminaModal" data-bs-url="<?= base_url('criminals/' . $criminal['idCriminal']); ?>">
                            <i class="fas fa-trash-alt"></i> Eliminar
                        </button>
                        <button type="button" class="btn btn-secondary btn-sm mx-1" data-bs-toggle="modal" data-bs-target="#borradoLogicoModal" data-bs-url="<?= base_url('criminals/' . $criminal['idCriminal'] . '/soft-delete'); ?>">
                            <i class="fas fa-archive"></i> Deshabilitar
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
                <h5 class="modal-title" id="eliminaModalLabel">Eliminar Criminal</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>¿Desea eliminar definitivamente este registro de la base de datos?</p>
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
                <h5 class="modal-title" id="borradoLogicoModalLabel">Deshabilitar Criminal</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>¿Desea deshabilitar este registro?</p>
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

<?= $this->section('script'); ?>

<script>
$(document).ready(function() {
    $('#tablaCriminales').DataTable({
        "responsive": true,
        "autoWidth": false,
        "order": [],
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.11.5/i18n/Spanish.json"
        }
    });
});

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
</script>

<?= $this->endSection(); ?>

