<?= $this->extend('layout/templateStart'); ?>

<?= $this->section('content'); ?>

<h3 class="my-3" id="titulo">Criminales</h3>

<a href="<?= base_url('criminals/new') ?>" class="btn btn-success mb-3">
    <i class="fas fa-user-plus"></i> Agregar
</a>

<div class="table-responsive">
    <table id="tablaCriminales" class="table table-hover table-bordered" aria-describedby="titulo">
        <thead class="table-dark">
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Nombre Completo</th>
                <th scope="col">Alias</th>
                <th scope="col">CI</th>
                <th scope="col">Foto</th>
                <th scope="col">Delitos</th>
                <th scope="col">Razón de búsqueda</th>
                <th scope="col">Activo</th>
                <th scope="col">Opciones</th>
            </tr>
        </thead>

        <tbody>
            <?php foreach($criminales as $criminal): ?>
            <tr>
                <td><?= $criminal['idCriminal']; ?></td>
                <td><?= esc($criminal['nombre']); ?></td>
                <td><?= esc($criminal['alias']); ?></td>
                <td><?= esc($criminal['ci']); ?></td>
                <td>
                    <?php if (!empty($criminal['foto'])): ?>
                        <img src="<?= esc($criminal['foto']); ?>" alt="<?= esc($criminal['nombre']); ?>" class="img-thumbnail" width="100">
                    <?php else: ?>
                        <img src="<?= base_url('images/perfil.jpg'); ?>" alt="Foto por defecto" class="img-thumbnail" width="100">
                    <?php endif; ?>
                </td>
                <td><?= esc($criminal['delitos']); ?></td>
                <td><?= esc($criminal['razon_busqueda']); ?></td>
                <td><?= $criminal['activo'] == 1 ? 'Sí' : 'No'; ?></td>
                <td class="d-flex flex-column">
                    <a href="<?= base_url('criminals/' . $criminal['idCriminal'] . '/edit'); ?>" class="btn btn-warning btn-sm mb-2">
                        <i class="fas fa-edit"></i> Editar
                    </a>

                    <button type="button" class="btn btn-danger btn-sm mb-2" data-bs-toggle="modal" data-bs-target="#eliminaModal" data-bs-url="<?= base_url('criminals/' . $criminal['idCriminal']); ?>">
                        <i class="fas fa-trash-alt"></i> Eliminar
                    </button>

                    <button type="button" class="btn btn-secondary btn-sm" data-bs-toggle="modal" data-bs-target="#borradoLogicoModal" data-bs-url="<?= base_url('criminals/' . $criminal['idCriminal'] . '/soft-delete'); ?>">
                        <i class="fas fa-archive"></i> Deshabilitar
                    </button>
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

<?= $this->section('script'); ?>

<!-- Script para inicializar DataTables -->
<script>
$(document).ready(function() {
    $('#tablaCriminales').DataTable({
        "responsive": true, // Hacer tabla responsiva
        "autoWidth": false, // Evitar que las columnas tengan un ancho predeterminado
        "order": [], // Evitar que se ordene por defecto
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.21/i18n/Spanish.json" // Traducción al español
        }
    });
});

// Manejo de modal para eliminación
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

