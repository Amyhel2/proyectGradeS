
<?php echo $this->extend('layout/templateStart'); ?>

<?= $this->section('content'); ?>

<h3 class="my-3">Modificar Usuario</h3>

<?php if(session()->getFlashdata('error')!== null) { ?>
  <div class="alert alert-danger">

    <?= session()->getFlashdata('error'); ?>

  </div>
  
<?php } ?>


                <form method="POST" action="<?= base_url('users/'.$usuario['id']); ?>">

                <input type="hidden" name="_method" value="PUT">
                <input type="hidden" name="id" value="<?= $usuario['id'];?> ">

                  <?= csrf_field(); ?>

                  <div data-mdb-input-init class="form-outline mb-4">
                    <input type="text" value="<?=$usuario['nombres'];?>" id="nombres" class="form-control form-control-lg" name="nombres" required />
                    <label class="form-label" for="form3Example1">Nombres</label>
                  </div>

                  <div data-mdb-input-init class="form-outline mb-4">
                    <input type="text" value="<?=$usuario['apellido_paterno'];?>" id="apellido_paterno" class="form-control form-control-lg" name="apellido_paterno" required />
                    <label class="form-label" for="form3Example2">Apellido Paterno</label>
                  </div>

                  <div data-mdb-input-init class="form-outline mb-4">
                    <input type="text" value="<?=$usuario['apellido_materno'];?>" id="apellido_materno" class="form-control form-control-lg" name="apellido_materno" required />
                    <label class="form-label" for="form3Example3">Apellido Materno</label>
                  </div>

                  <div data-mdb-input-init class="form-outline mb-4">
                    <input type="text" value="<?=$usuario['ci'];?>" id="ci" class="form-control form-control-lg" name="ci" required />
                    <label class="form-label" for="form3Example4">Número de CI</label>
                  </div>

                  <div data-mdb-input-init class="form-outline mb-4">
                    <input type="text" value="<?=$usuario['rango'];?>" id="rango" class="form-control form-control-lg" name="rango" required />
                    <label class="form-label" for="form3Example5">Rango</label>
                  </div>

                  <div data-mdb-input-init class="form-outline mb-4">
                    <input type="text" value="<?=$usuario['numero_placa'];?>" id="numero_placa" class="form-control form-control-lg" name="numero_placa" required />
                    <label class="form-label" for="form3Example6">Número de Placa</label>
                  </div>

                  <div data-mdb-input-init class="form-outline mb-4">
                    <input type="date" value="<?=$usuario['fecha_nacimiento'];?>" id="fecha_nacimiento" class="form-control form-control-lg" name="fecha_nacimiento" required />
                    <label class="form-label" for="form3Example7">Fecha de Nacimiento</label>
                  </div>

                  <div data-mdb-input-init class="form-outline mb-4">
                    <input type="text" value="<?=$usuario['direccion'];?>" id="direccion" class="form-control form-control-lg" name="direccion" required />
                    <label class="form-label" for="form3Example8">Dirección</label>
                  </div>

                  <div data-mdb-input-init class="form-outline mb-4">
                    <input type="text" value="<?=$usuario['celular'];?>" id="celular" class="form-control form-control-lg" name="celular" required />
                    <label class="form-label" for="form3Example9">Celular</label>
                  </div>

                  <div data-mdb-input-init class="form-outline mb-4">
                    <input type="email" value="<?=$usuario['email'];?>" id="email" class="form-control form-control-lg" name="email" required />
                    <label class="form-label" for="form3Example10">Correo Electrónico</label>
                  </div>
                  
                  <div data-mdb-input-init class="form-outline mb-4">
                    <input type="password" value="<?=$usuario['password'];?>" id="password" class="form-control form-control-lg" name="password" required />
                    <label class="form-label" for="password">Contraseña</label>
                  </div>
                  
                  <div data-mdb-input-init class="form-outline mb-4">
                    <select id="tipo" class="form-control form-control-lg" name="tipo" required>
                      <option value="admin">Administrador</option>
                      <option value="user">Usuario</option>
                    </select>
                    <label class="form-label" for="form3Example12">Tipo</label>
                  </div>

                 <div data-mdb-input-init class="form-outline mb-4">
                    <input type="num" value="<?=$usuario['activo'];?>" id="activo" class="form-control form-control-lg" name="activo" required />
                    <label class="form-label" for="activo">Activo</label>
                  </div>
                  
                  <div class="d-flex justify-content-end pt-3">

                    <div class="col-12">
                      <a href="<?= base_url('users')?>" class="btn btn-secondary">Regresar</a>
                      <button type="submit" data-mdb-button-init data-mdb-ripple-init class="btn btn-warning btn-lg ms-2">
                          Guardar
                      </button>
                    </div>
                    
                  </div>
                
                  
                </form>

                <?php if(session()->getFlashdata('errors')!==null):?>
                    <div class="alert alert-danger my-3" role="alert">
                        <?= session()->getFlashdata('errors');?>
                    </div>
                <?php endif;?>



<?= $this->endSection(); ?>