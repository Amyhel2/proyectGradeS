
<?php echo $this->extend('layout/templateStart'); ?>

<?= $this->section('content'); ?>

<h3 class="my-3">Nuevo Criminal</h3>

<?php if(session()->getFlashdata('error')!== null) { ?>
  <div class="alert alert-danger">

    <?= session()->getFlashdata('error'); ?>

  </div>
  
<?php } ?>

                <form method="POST" action="<?= base_url('criminals'); ?>">

                  <?= csrf_field(); ?>

                  <div data-mdb-input-init class="form-outline mb-4">
                    <input type="text" value="<?=set_value('nombre');?>" id="nombre" class="form-control form-control-lg" name="nombre" required />
                    <label class="form-label" for="form3Example1">Nombre completo</label>
                  </div>

                  <div data-mdb-input-init class="form-outline mb-4">
                    <input type="text" value="<?=set_value('alias');?>" id="alias" class="form-control form-control-lg" name="alias" required />
                    <label class="form-label" for="form3Example5">Alias</label>
                  </div>

                  
                  <div data-mdb-input-init class="form-outline mb-4">
                    <input type="text" value="<?=set_value('ci');?>" id="ci" class="form-control form-control-lg" name="ci" required />
                    <label class="form-label" for="form3Example4">Número de CI</label>
                  </div>

                  

                  <div data-mdb-input-init class="form-outline mb-4">
                    <input type="text" value="<?=set_value('foto');?>" id="foto" class="form-control form-control-lg" name="foto" required />
                    <label class="form-label" for="form3Example8">Foto</label>
                  </div>

                  

                  <div data-mdb-input-init class="form-outline mb-4">
                    <input type="text" value="<?=set_value('delitos');?>" id="delitos" class="form-control form-control-lg" name="delitos" required />
                    <label class="form-label" for="user">Delitos</label>
                  </div>

                  <div data-mdb-input-init class="form-outline mb-4">
                    <input type="text" value="<?=set_value('razon_busqueda');?>" id="razon_busqueda" class="form-control form-control-lg" name="razon_busqueda" required />
                    <label class="form-label" for="user">Razon de la busqueda</label>
                  </div>


                  <div class="d-flex justify-content-end pt-3">

                    <div class="col-12">
                      <a href="<?= base_url('criminals')?>" class="btn btn-secondary">Regresar</a>
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