<?= $this->extend('layout/templateStart'); ?>

<?= $this->section('content'); ?>

<div class="container">
    <hr>
    <div class="d-flex justify-content-between align-items-center my-3">
        <h3 id="titulo">USUARIOS</h3>
        <div>
            <a href="<?= base_url('users/new') ?>" class="btn btn-success">
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
                    <!--<th>ID</th>-->
                    <th>#</th>
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
                <?php
                $contador=1;
                foreach($usuarios as $usuario): ?>
                <tr class="text-center">
                    <!--<td><?= $usuario['id']; ?></td>-->
                    <td><?= $contador++; ?></td>
                    <td><?= esc($usuario['nombres'] . ' ' . $usuario['apellido_paterno'] . ' ' . $usuario['apellido_materno']); ?></td>
                    <td><?= esc($usuario['ci']); ?></td>
                    <td><?= esc($usuario['rango']); ?></td>
                    <td><?= esc($usuario['numero_placa']); ?></td>
                    <td><?= esc($usuario['email']); ?></td>
                    <td><?= esc($usuario['celular']); ?></td>
                    <td><?= esc($usuario['fecha_nacimiento']); ?></td>
                    <td><?= $usuario['sexo'] == 'M' ? 'Masculino' : 'Femenino'; ?></td>
                    <td><?= esc($usuario['direccion']); ?></td>
                    <td><?= $usuario['tipo'] == 'admin' ? 'Admin' : 'Usuario'; ?></td>
                    <td><?= $usuario['activo'] == 1 ? '<span class="badge badge-success">Sí</span>' : '<span class="badge badge-danger">No</span>'; ?></td>
                    <td class="d-flex justify-content-center">
                        <a href="<?= base_url('users/' . $usuario['id'] . '/edit'); ?>" class="btn btn-warning btn-sm mx-1">
                            <i class="fas fa-edit"></i> Editar
                        </a>
                        <button type="button" class="btn btn-danger btn-sm mx-1" data-toggle="modal" data-target="#eliminaModal" data-url="<?= base_url('users/' . $usuario['id']); ?>">
                            <i class="fas fa-trash"></i> Eliminar
                        </button>
                        <button type="button" class="btn btn-secondary btn-sm mx-1" data-toggle="modal" data-target="#borradoLogicoModal" data-url="<?= base_url('users/' . $usuario['id'] . '/soft-delete'); ?>">
                            <i class="fas fa-user-slash"></i> Desactivar
                        </button>
                        <!-- Botón para habilitar usuario -->
                        <?php if ($usuario['activo'] == 0): ?>
                        <button type="button" class="btn btn-success btn-sm mx-1" data-toggle="modal" data-target="#reactivarModal" data-url="<?= base_url('users/' . $usuario['id'] . '/reactivate'); ?>">
                            <i class="fas fa-user-check"></i> Habilitar
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
                <h5 class="modal-title" id="eliminaModalLabel">Eliminar Usuario</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>¿Desea eliminar definitivamente este registro?</p>
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


<!-- Modal de eliminación lógica -->
<div class="modal fade" id="borradoLogicoModal" tabindex="-1" role="dialog" aria-labelledby="borradoLogicoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-warning text-dark">
                <h5 class="modal-title" id="borradoLogicoModalLabel">Inactivar Usuario</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>¿Desea inactivar este usuario?</p>
            </div>
            <div class="modal-footer">
                <form id="form-borrado-logico" action="" method="POST">
                    <?= csrf_field(); ?>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-warning">Inactivar</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal de reactivación -->
<div class="modal fade" id="reactivarModal" tabindex="-1" role="dialog" aria-labelledby="reactivarModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title" id="reactivarModalLabel">Habilitar Usuario</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>¿Desea habilitar este usuario?</p>
            </div>
            <div class="modal-footer">
                <form id="form-reactivar" action="" method="POST">
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
                <h5 class="modal-title" id="verDesactivadosModalLabel">Usuarios Desactivados</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre Completo</th>
                            <th>Correo Electrónico</th>
                            <th>Opciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($desactivados as $usuarioDesactivado): ?>
                        <tr>
                            <td><?= esc($usuarioDesactivado['id']); ?></td>
                            <td><?= esc($usuarioDesactivado['nombres'] . ' ' . $usuarioDesactivado['apellido_paterno']); ?></td>
                            <td><?= esc($usuarioDesactivado['email']); ?></td>
                            <td>
                                <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#reactivarModal" data-url="<?= base_url('users/' . $usuarioDesactivado['id'] . '/reactivate'); ?>">
                                    <i class="fas fa-user-check"></i> Habilitar
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
        const button = $(event.relatedTarget); // Botón que activó el modal
        const url = button.data('url'); // Extraer la URL de datos
        const modal = $(this);
        modal.find('#form-elimina').attr('action', url); // Actualizar la acción del formulario
    });





    // Configuración para el modal de inactivación
    $('#borradoLogicoModal').on('show.bs.modal', function (event) {
        const button = $(event.relatedTarget); // Botón que activó el modal
        const url = button.data('url'); // Extraer la URL de datos
        const modal = $(this);
        const form = modal.find('#form-borrado-logico');
        form.attr('action', url); // Establecer la acción del formulario
    });

    // Configuración para el modal de reactivación
    $('#reactivarModal').on('show.bs.modal', function (event) {
        const button = $(event.relatedTarget); // Botón que activó el modal
        const url = button.data('url'); // Extraer la URL de datos
        const modal = $(this);
        const form = modal.find('#form-reactivar');
        form.attr('action', url); // Establecer la acción del formulario

        // Cerrar el modal de desactivados si está abierto
        $('#verDesactivadosModal').modal('hide');
    });
</script>

<?= $this->endSection(); ?>
