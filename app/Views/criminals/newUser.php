
<?php echo $this->extend('layout/templateStart'); ?>

<?= $this->section('content'); ?>

<h3 class="my-3">Nuevo Usuario</h3>

<?php if(session()->getFlashdata('error')!== null) { ?>
  <div class="alert alert-danger">

    <?= session()->getFlashdata('error'); ?>

  </div>
  
<?php } ?>

                <form method="POST" action="<?= base_url('users'); ?>">

                  <?= csrf_field(); ?>

                  <div data-mdb-input-init class="form-outline mb-4">
                    <input type="text" value="<?=set_value('nombres');?>" id="nombres" class="form-control form-control-lg" name="nombres" required />
                    <label class="form-label" for="form3Example1">Nombres</label>
                  </div>

                  <div data-mdb-input-init class="form-outline mb-4">
                    <input type="text" value="<?=set_value('apellido_paterno');?>" id="apellido_paterno" class="form-control form-control-lg" name="apellido_paterno" required />
                    <label class="form-label" for="form3Example2">Apellido Paterno</label>
                  </div>

                  <div data-mdb-input-init class="form-outline mb-4">
                    <input type="text" value="<?=set_value('apellido_materno');?>" id="apellido_materno" class="form-control form-control-lg" name="apellido_materno" required />
                    <label class="form-label" for="form3Example3">Apellido Materno</label>
                  </div>

                  <div data-mdb-input-init class="form-outline mb-4">
                    <input type="text" value="<?=set_value('ci');?>" id="ci" class="form-control form-control-lg" name="ci" required />
                    <label class="form-label" for="form3Example4">Número de CI</label>
                  </div>

                  <div data-mdb-input-init class="form-outline mb-4">
                    <input type="text" value="<?=set_value('rango');?>" id="rango" class="form-control form-control-lg" name="rango" required />
                    <label class="form-label" for="form3Example5">Rango</label>
                  </div>

                  <div data-mdb-input-init class="form-outline mb-4">
                    <input type="text" value="<?=set_value('numero_placa');?>" id="numero_placa" class="form-control form-control-lg" name="numero_placa" required />
                    <label class="form-label" for="form3Example6">Número de Placa</label>
                  </div>

                  <div data-mdb-input-init class="form-outline mb-4">
                    <input type="date" value="<?=set_value('fecha_nacimiento');?>" id="fecha_nacimiento" class="form-control form-control-lg" name="fecha_nacimiento" required />
                    <label class="form-label" for="form3Example7">Fecha de Nacimiento</label>
                  </div>

                  <div class="d-md-flex justify-content-start align-items-center mb-4 py-2">
                    <h6 class="mb-0 me-4">Género</h6>
                    <div class="form-check form-check-inline mb-0 me-4">
                      <input class="form-check-input" type="radio" name="sexo" id="sexo" value="M" required />
                      <label class="form-check-label" for="maleGender">Hombre</label>
                    </div>
                    <div class="form-check form-check-inline mb-0 me-4">
                      <input class="form-check-input" type="radio" name="sexo" id="sexo" value="F" required />
                      <label class="form-check-label" for="femaleGender">Mujer</label>
                    </div>
                  </div>

                  <div data-mdb-input-init class="form-outline mb-4">
                    <input type="text" value="<?=set_value('direccion');?>" id="direccion" class="form-control form-control-lg" name="direccion" required />
                    <label class="form-label" for="form3Example8">Dirección</label>
                  </div>

                  <div data-mdb-input-init class="form-outline mb-4">
                    <input type="text" value="<?=set_value('celular');?>" id="celular" class="form-control form-control-lg" name="celular" required />
                    <label class="form-label" for="form3Example9">Celular</label>
                  </div>

                  <div data-mdb-input-init class="form-outline mb-4">
                    <input type="email" value="<?=set_value('email');?>" id="email" class="form-control form-control-lg" name="email" required />
                    <label class="form-label" for="form3Example10">Correo Electrónico</label>
                  </div>

                  <div data-mdb-input-init class="form-outline mb-4">
                    <input type="text" value="<?=set_value('user');?>" id="user" class="form-control form-control-lg" name="user" required />
                    <label class="form-label" for="user">Usuario</label>
                  </div>

                  <div data-mdb-input-init class="form-outline mb-4">
                    <input type="password" id="password" class="form-control form-control-lg" name="password" required />
                    <label class="form-label" for="password">Contraseña</label>
                  </div>
                  
                  <div data-mdb-input-init class="form-outline mb-4">
                    <input type="password" id="repassword" class="form-control form-control-lg" name="repassword" required />
                    <label class="form-label" for="repassword">confirmar Contraseña</label>
                  </div>

                  <div data-mdb-input-init class="form-outline mb-4">
                    <select id="tipo" class="form-control form-control-lg" name="tipo" required>
                      <option value="admin">Administrador</option>
                      <option value="user">Usuario</option>
                    </select>
                    <label class="form-label" for="form3Example12">Tipo</label>
                  </div>

                  <div class="d-flex justify-content-end pt-3">

                    <div class="col-12">
                      <a href="<?= base_url('users')?>" class="btn btn-secondary">Regresar</a>
                      <button type="submit" data-mdb-button-init data-mdb-ripple-init class="btn btn-warning btn-lg ms-2">
                          Registrar
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