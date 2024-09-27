<?= $this->extend('layout/templateStart'); ?>

<?= $this->section('content'); ?>

<div class="container">
    <hr>
    <div class="d-flex justify-content-between align-items-center my-3">
        <h3 id="titulo">DISPOSITIVOS GAFAS</h3>
        <a href="<?= base_url('gafas/new') ?>" class="btn btn-success">
            <i class="fas fa-plus"></i> Agregar Gafa
        </a>
    </div>

    <div class="table-responsive shadow-lg p-3 bg-body rounded">
        <table id="tablaGafas" class="table table-striped table-hover table-sm" aria-describedby="titulo">
            <thead class="bg-info table-dark text-center">
                <tr>
                    <th>ID</th>
                    <th>ID Oficial</th>
                    <th>ID Dispositivo</th>
                    <th>Opciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($gafas as $gafa): ?>
                <tr class="text-center">
                    <td><?= $gafa['id']; ?></td>
                    <td><?= esc($gafa['oficial_id']); ?></td>
                    <td><?= esc($gafa['device_id']); ?></td>
                    <td class="d-flex justify-content-center">
                        <a href="<?= base_url('gafas/' . $gafa['id'] . '/edit'); ?>" class="btn btn-warning btn-sm mx-1">
                            <i class="fas fa-edit"></i> Editar
                        </a>
                        <button type="button" class="btn btn-danger btn-sm mx-1" data-bs-toggle="modal" data-bs-target="#eliminaModal" data-bs-url="<?= base_url('gafas/' . $gafa['id']); ?>">
                            <i class="fas fa-trash-alt"></i> Eliminar
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
                <h5 class="modal-title" id="eliminaModalLabel">Eliminar Gafa</h5>
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

<?= $this->endSection(); ?>

<?= $this->section('script'); ?>

<script>
$(document).ready(function() {
    $('#tablaGafas').DataTable({
        "responsive": true,
        "autoWidth": false,
        "order": [],
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.11.5/i18n/Spanish.json"
        }
    });
});

const eliminaModal = document.getElementById('eliminaModal');

if (eliminaModal) {
    eliminaModal.addEventListener('show.bs.modal', event => {
        const button = event.relatedTarget;
        const url = button.getAttribute('data-bs-url');
        const form = eliminaModal.querySelector('#form-elimina');
        form.setAttribute('action', url);
    });
}
</script>

<?= $this->endSection(); ?>
