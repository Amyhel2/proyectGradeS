
<?php echo $this->extend('layout/templateStart'); ?>

<?= $this->section('content'); ?>

<h3 class="my-3">Modificar Criminal</h3>

<?php if(session()->getFlashdata('error')!== null) { ?>
  <div class="alert alert-danger">

    <?= session()->getFlashdata('error'); ?>

  </div>
  
<?php } ?>


                <form method="POST" action="<?= base_url('criminals/'.$criminal['idCriminal']); ?>">

                <input type="hidden" name="_method" value="PUT">
                <input type="hidden" name="id" value="<?= $criminal['idCriminal'];?> ">

                  <?= csrf_field(); ?>

                  <div data-mdb-input-init class="form-outline mb-4">
                    <input type="text" value="<?=$criminal['nombre'];?>" id="nombre" class="form-control form-control-lg" name="nombre" required />
                    <label class="form-label" for="form3Example1">Nombres</label>
                  </div>

                  

                  <div data-mdb-input-init class="form-outline mb-4">
                    <input type="text" value="<?=$criminal['alias'];?>" id="alias" class="form-control form-control-lg" name="alias" required />
                    <label class="form-label" for="form3Example3">Alias</label>
                  </div>

                  <div data-mdb-input-init class="form-outline mb-4">
                    <input type="text" value="<?=$criminal['ci'];?>" id="ci" class="form-control form-control-lg" name="ci" required />
                    <label class="form-label" for="form3Example4">Número de CI</label>
                  </div>

                  <div data-mdb-input-init class="form-outline mb-4">
                    <input type="text" value="<?=$criminal['foto'];?>" id="foto" class="form-control form-control-lg" name="foto" required />
                    <label class="form-label" for="form3Example5">Foto</label>
                  </div>

                  
                  <div data-mdb-input-init class="form-outline mb-4">
                    <input type="text" value="<?=$criminal['delitos'];?>" id="delitos" class="form-control form-control-lg" name="delitos" required />
                    <label class="form-label" for="form3Example8">Delitos</label>
                  </div>

                  <div data-mdb-input-init class="form-outline mb-4">
                    <input type="text" value="<?=$criminal['razon_busqueda'];?>" id="razon_busqueda" class="form-control form-control-lg" name="razon_busqueda" required />
                    <label class="form-label" for="form3Example8">Razon de la busqueda</label>
                  </div>

                 <div data-mdb-input-init class="form-outline mb-4">
                    <input type="num" value="<?=$criminal['activo'];?>" id="activo" class="form-control form-control-lg" name="activo" required />
                    <label class="form-label" for="activo">Activo</label>
                  </div>
                  
                  <div class="d-flex justify-content-end pt-3">

                    <div class="col-12">
                      <a href="<?= base_url('criminals')?>" class="btn btn-secondary">Regresar</a>
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