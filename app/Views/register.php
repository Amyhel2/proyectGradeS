<?= $this->extend('layout/templateRegister'); ?>

<?= $this->section('content'); ?>

<section class="h-100">
  <div class="container py-5 h-100">
    <div class="row d-flex justify-content-center align-items-center h-100">
      <div class="col">
        <div id="card-e" class="card card-registration my-4">
          <div class="row g-0">
            <div class="col-xl-6 d-none d-xl-block">
              <img src="<?= base_url('img/rec1.png'); ?>" alt="Imagen de ejemplo" class="custom-img" style="border-top-left-radius: .25rem; border-bottom-left-radius: .25rem;" />
              <img src="<?= base_url('img/rec3.jpg'); ?>" alt="Imagen de ejemplo" class="custom-img" style="border-top-left-radius: .25rem; border-bottom-left-radius: .25rem;" />
            </div>
            <div class="col-xl-6">
              <div class="card-body p-md-5 text-black">

                <h3 class="mb-5 text-uppercase">Formulario de Registro</h3>

                <?= csrf_field();?>
                <form method="POST" action="<?= base_url('register'); ?>">
                  <?= csrf_field(); ?>
                  <div data-mdb-input-init class="form-outline mb-4">
                    <input type="text" value="<?=set_value('nombres');?>" id="nombres" class="form-control form-control-lg" name="nombres" required />
                    <label class="form-label" for="form3Example1">Nombres</label>
                  </div>
                  <div data-mdb-input-init class="form-outline mb-4">
                    <input type="text" id="apellido_paterno" class="form-control form-control-lg" name="apellido_paterno" required />
                    <label class="form-label" for="form3Example2">Apellido Paterno</label>
                  </div>
                  <div data-mdb-input-init class="form-outline mb-4">
                    <input type="text" id="apellido_materno" class="form-control form-control-lg" name="apellido_materno" required />
                    <label class="form-label" for="form3Example3">Apellido Materno</label>
                  </div>
                  <div data-mdb-input-init class="form-outline mb-4">
                    <input type="text" id="ci" class="form-control form-control-lg" name="ci" required />
                    <label class="form-label" for="form3Example4">Número de CI</label>
                  </div>
                  <div data-mdb-input-init class="form-outline mb-4">
                    <input type="text" id="rango" class="form-control form-control-lg" name="rango" required />
                    <label class="form-label" for="form3Example5">Rango</label>
                  </div>
                  <div data-mdb-input-init class="form-outline mb-4">
                    <input type="text" id="numero_placa" class="form-control form-control-lg" name="numero_placa" required />
                    <label class="form-label" for="form3Example6">Número de Placa</label>
                  </div>
                  <div data-mdb-input-init class="form-outline mb-4">
                    <input type="date" id="fecha_nacimiento" class="form-control form-control-lg" name="fecha_nacimiento" required />
                    <label class="form-label" for="form3Example7">Fecha de Nacimiento</label>
                  </div>
                  <div class="d-md-flex justify-content-start align-items-center mb-4 py-2">
                    <h6 class="mb-0 me-4">Género</h6>
                    <div class="form-check form-check-inline mb-0 me-4">
                      <input class="form-check-input" type="radio" name="genero" id="maleGender" value="M" required />
                      <label class="form-check-label" for="maleGender">Hombre</label>
                    </div>
                    <div class="form-check form-check-inline mb-0 me-4">
                      <input class="form-check-input" type="radio" name="genero" id="femaleGender" value="F" required />
                      <label class="form-check-label" for="femaleGender">Mujer</label>
                    </div>
                  </div>
                  <div data-mdb-input-init class="form-outline mb-4">
                    <input type="text" id="direccion" class="form-control form-control-lg" name="direccion" required />
                    <label class="form-label" for="form3Example8">Dirección</label>
                  </div>
                  <div data-mdb-input-init class="form-outline mb-4">
                    <input type="text" id="celular" class="form-control form-control-lg" name="celular" required />
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
                    <button type="submit" data-mdb-button-init data-mdb-ripple-init class="btn btn-warning btn-lg ms-2">Registrarr</button>
                  </div>
                </form>

                <?php if(session()->getFlashdata('errors')!==null):?>
                    <div class="alert alert-danger my-3" role="alert">
                        <?= session()->getFlashdata('errors');?>
                    </div>
                <?php endif;?>


              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<?= $this->endSection(); ?>
