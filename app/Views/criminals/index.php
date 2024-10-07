<?= $this->extend('layout/templateStart'); ?>

<?= $this->section('content'); ?>

<div class="container">
    <hr>
    <div class="d-flex justify-content-between align-items-center my-3">
        <h3 id="titulo">CRIMINALES</h3>
        <div>
            <a href="<?= base_url('criminals/new') ?>" class="btn btn-success">
                <i class="fas fa-user-plus"></i> Agregar
            </a>
            <button type="button" class="btn btn-info mx-2" data-toggle="modal" data-target="#verDesactivadosModal">
                <i class="fas fa-eye-slash"></i> Ver Desactivados
            </button>
        </div>
    </div>

    <div class="table-responsive shadow-lg p-3 bg-body rounded">
        <table id="example1" class="table table-striped table-hover table-sm" aria-describedby="titulo">
            <thead class="bg-primary table-dark text-center">
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Alias</th>
                    <th>CI</th>
                    <th>Delitos</th>
                    <th>Razon De Busqueda</th>
                    <th>Fotos</th>
                    <th>Activo</th>
                    <th>Opciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($criminales as $criminal): ?>
                <tr class="text-center <?= $criminal['activo'] ? '' : 'table-danger'; ?>">
                    <td><?= esc($criminal['idCriminal']); ?></td>
                    <td><?= esc($criminal['nombre']); ?></td>
                    <td><?= esc($criminal['alias']); ?></td>
                    <td><?= esc($criminal['ci']); ?></td>
                    <td><?= esc($criminal['delitos']); ?></td>
                    <td><?= esc($criminal['razon_busqueda']); ?></td>

                    <td>
    <a href="<?= base_url('criminals/' . $criminal['idCriminal'] . '/images'); ?>" class="btn btn-info btn-sm">
        <i class="fas fa-images"></i> Ver Fotos
    </a>
</td>

                    <td>
                        <?= $criminal['activo'] ? '<span class="badge badge-success">Sí</span>' : '<span class="badge badge-danger">No</span>'; ?>
                    </td>
                    <td class="d-flex justify-content-center">
                        <a href="<?= base_url('criminals/' . $criminal['idCriminal'] . '/edit'); ?>" class="btn btn-warning btn-sm mx-1">
                            <i class="fas fa-edit"></i> Editar
                        </a>
                        <button type="button" class="btn btn-danger btn-sm mx-1" data-toggle="modal" data-target="#eliminaModal" data-url="<?= base_url('criminals/' . $criminal['idCriminal']); ?>">
                            <i class="fas fa-trash"></i> Eliminar
                        </button>
                        <?php if ($criminal['activo']): ?>
                        <button type="button" class="btn btn-secondary btn-sm mx-1" data-toggle="modal" data-target="#deshabilitarModal" data-url="<?= base_url('criminals/' . $criminal['idCriminal'] . '/soft-delete'); ?>">
                            <i class="fas fa-ban"></i> Deshabilitar
                        </button>                                                                                                                                           
                        <?php else: ?>
                        <button type="button" class="btn btn-success btn-sm mx-1" data-toggle="modal" data-target="#habilitarModal" data-url="<?= base_url('criminals/' . $criminal['idCriminal'] . '/habilitar'); ?>">
                            <i class="fas fa-check"></i> Habilitar
                        </button>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal de eliminación física -->
<div class="modal fade" id="eliminaModal" tabindex="-1" role="dialog" aria-labelledby="eliminaModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="eliminaModalLabel">Eliminar</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>¿Desea eliminar definitivamente este criminal?</p>
            </div>
            <div class="modal-footer">
                <form id="form-elimina" action="" method="POST">
                    <?= csrf_field(); ?>
                    <input type="hidden" name="_method" value="DELETE">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-danger">Eliminar</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal para deshabilitar -->
<div class="modal fade" id="deshabilitarModal" tabindex="-1" role="dialog" aria-labelledby="deshabilitarModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-warning text-dark">
                <h5 class="modal-title" id="deshabilitarModalLabel">Deshabilitar</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>¿Desea deshabilitar este criminal?</p>
            </div>
            <div class="modal-footer">
                <form id="form-deshabilitar" action="" method="POST">
                    <?= csrf_field(); ?>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-warning">Deshabilitar</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal para habilitar -->
<div class="modal fade" id="habilitarModal" tabindex="-1" role="dialog" aria-labelledby="habilitarModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title" id="habilitarModalLabel">Habilitar</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>¿Desea habilitar este criminal?</p>
            </div>
            <div class="modal-footer">
                <form id="form-habilitar" action="" method="POST">
                    <?= csrf_field(); ?>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-success">Habilitar</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal para ver desactivados -->
<div class="modal fade" id="verDesactivadosModal" tabindex="-1" role="dialog" aria-labelledby="verDesactivadosModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title" id="verDesactivadosModalLabel">Criminales</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Delitos</th>
                            <th>Opciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($criminalesDeshabilitados as $criminalDeshabilitado): ?>
                        <tr>
                            <td><?= esc($criminalDeshabilitado['idCriminal']); ?></td>
                            <td><?= esc($criminalDeshabilitado['nombre']); ?></td>
                            <td><?= esc($criminalDeshabilitado['delitos']); ?></td>
                            <td>
                                <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#habilitarModal" data-url="<?= base_url('criminals/' . $criminalDeshabilitado['idCriminal'] . '/habilitar'); ?>">
                                    <i class="fas fa-check"></i> Habilitar
                                </button>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>

<?= $this->section('script'); ?>

<script>
    // Configuración para el modal de eliminación
    $('#eliminaModal').on('show.bs.modal', function (event) {
        const button = $(event.relatedTarget);
        const url = button.data('url');
        const modal = $(this);
        modal.find('#form-elimina').attr('action', url);
    });

    // Configuración para el modal de deshabilitar
    $('#deshabilitarModal').on('show.bs.modal', function (event) {
        const button = $(event.relatedTarget);
        const url = button.data('url');
        const modal = $(this);
        modal.find('#form-deshabilitar').attr('action', url);
    });

    // Configuración para el modal de habilitar
    $('#habilitarModal').on('show.bs.modal', function (event) {
        const button = $(event.relatedTarget);
        const url = button.data('url');
        const modal = $(this);
        modal.find('#form-habilitar').attr('action', url);
        // Cerrar el modal de desactivados si está abierto
        $('#verDesactivadosModal').modal('hide');
    });

</script>
<?= $this->endSection(); ?>
