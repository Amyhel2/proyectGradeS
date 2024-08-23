<?php echo $this->extend('layout/templateStart'); ?>

<?= $this->section('content'); ?>

<h3 class="my-3" id="titulo">Criminales</h3>


<a href="<?= base_url('criminals/new')?>" class="btn btn-success">Agregar Nuevo Criminal</a>

<table class="table table-hover table-bordered my-3" aria-describedby="titulo">
    <thead class="table-dark">
        <tr>
            <th scope="col">ID</th>
            <th scope="col">Nombre Completo</th>
            <th scope="col">Alias</th>
            <th scope="col">CI</th>
            <th scope="col">Foto</th>
            <th scope="col">Delitos</th>
            <th scope="col">Razon de busqueda</th>
            <th scope="col">Activo</th>
            <th scope="col">Opciones</th>
        </tr>
    </thead>

    <tbody>
        <?php foreach($criminales as $criminal): ?>
        <tr>
            <td><?= $criminal['nombre']; ?></td>
            <td><?= $criminal['idCriminal']; ?></td>
            <td><?= $criminal['alias']; ?></td>
            <td><?= $criminal['ci']; ?></td>
            <td>

                <?=
                 $foto=$criminal['foto']; 
                 if($foto!="")
                 {
                    ?>

<img src="<?= base_url('images/perfil.jpg'); ?>" alt="" width="100">


                    <?php
                 }

                 else
                 {
                    ?>
                    <img src="<?= base_url('imagen/' . $foto); ?>" alt="" width="100">

                    <?php

                 }
                 ?>
            </td>
            <td><?= $criminal['delitos']; ?></td>
            <td><?= $criminal['razon_busqueda']; ?></td>
            <td><?= $criminal['activo'] == 1 ? 'Sí' : 'No'; ?></td>
            
            <td>
    <a href="<?= base_url('criminals/' . $criminal['idCriminal'] . '/edit'); ?>" class="btn btn-warning btn-sm me-2">Editar</a>

    <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#eliminaModal" data-bs-url="<?= base_url('criminals/' . $criminal['idCriminal']); ?>">Eliminacion física</button>

    <button type="button" class="btn btn-secondary btn-sm" data-bs-toggle="modal" data-bs-target="#borradoLogicoModal" data-bs-url="<?= base_url('criminals/' . $criminal['idCriminal'] . '/soft-delete'); ?>">Eliminacion lógica</button>
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

<div class="modal fade" id="borradoLogicoModal" tabindex="-1" aria-labelledby="borradoLogicoModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="borradoLogicoModalLabel">Aviso</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>¿Desea desabilitar este registro?</p>
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

const eliminaModal = document.getElementById('eliminaModal')
const borradoLogicoModal = document.getElementById('borradoLogicoModal')

if (eliminaModal) {
    eliminaModal.addEventListener('show.bs.modal', event => {
        const button = event.relatedTarget
        const url = button.getAttribute('data-bs-url')
        const form = eliminaModal.querySelector('#form-elimina')
        form.setAttribute('action', url)
    })
}

if (borradoLogicoModal) {
    borradoLogicoModal.addEventListener('show.bs.modal', event => {
        const button = event.relatedTarget
        const url = button.getAttribute('data-bs-url')
        const form = borradoLogicoModal.querySelector('#form-borrado-logico')
        form.setAttribute('action', url)
    })
}

        
</script>


<?= $this->endSection();?>