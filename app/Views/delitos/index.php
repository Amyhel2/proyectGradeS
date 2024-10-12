<?= $this->extend('layout/templateStart'); ?>

<?= $this->section('content'); ?>

<div class="container">
    <hr>
    <div class="d-flex justify-content-between align-items-center my-3">
        <h3 id="titulo">DELITOS</h3>
        <div>
            <a href="<?= base_url('delitos/new') ?>" class="btn btn-success">
                <i class="fas fa-plus"></i> Agregar Delito
            </a>
        </div>
    </div>

    <div class="table-responsive shadow-lg p-3 bg-body rounded">
        <table id="delitosTable" class="table table-striped table-hover table-sm" aria-describedby="titulo">
            <thead class="bg-primary table-dark text-center">
                <tr>
                    <th>ID</th>
                    <th>Tipo</th>
                    <th>Descripción</th>
                    <th>Gravedad</th>
                    <th>Estado</th>
                    <th>Creado en</th>
                    <th>Actualizado en</th>
                    <th>Opciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($delitos as $delito): ?>
                <tr class="text-center <?= $delito['estado'] ? '' : 'table-danger'; ?>">
                    <td><?= esc($delito['idDelito']); ?></td>
                    <td><?= esc($delito['tipo']); ?></td>
                    <td><?= esc($delito['descripcion']); ?></td>
                    <td><?= esc($delito['gravedad']); ?></td>
                    <td>
                        <?= $delito['estado'] ? '<span class="badge badge-success">Activo</span>' : '<span class="badge badge-danger">Inactivo</span>'; ?>
                    </td>
                    <td><?= esc($delito['creado_en']); ?></td>
                    <td><?= esc($delito['actualizado_en']); ?></td>
                    <td class="d-flex justify-content-center">
                        <a href="<?= base_url('delitos/' . $delito['idDelito'] . '/edit'); ?>" class="btn btn-warning btn-sm mx-1">
                            <i class="fas fa-edit"></i> Editar
                        </a>
                        <button type="button" class="btn btn-danger btn-sm mx-1" data-toggle="modal" data-target="#eliminarDelitoModal" data-url="<?= base_url('delitos/' . $delito['idDelito']); ?>">
                            <i class="fas fa-trash"></i> Eliminar
                        </button>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal para eliminar delito -->
<div class="modal fade" id="eliminarDelitoModal" tabindex="-1" role="dialog" aria-labelledby="eliminarDelitoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="eliminarDelitoModalLabel">Eliminar Delito</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>¿Desea eliminar definitivamente este delito?</p>
            </div>
            <div class="modal-footer">
                <form id="form-elimina-delito" action="" method="POST">
                    <?= csrf_field(); ?>
                    <input type="hidden" name="_method" value="DELETE">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-danger">Eliminar</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>

<?= $this->section('script'); ?>
<script>
    $('#eliminarDelitoModal').on('show.bs.modal', function (event) {
        const button = $(event.relatedTarget);
        const url = button.data('url');
        const modal = $(this);
        modal.find('#form-elimina-delito').attr('action', url);
    });
</script>
<?= $this->endSection(); ?>

