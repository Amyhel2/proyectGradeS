<?= $this->extend('layout/templateLogin'); ?>

<?= $this->section('content'); ?>

<div class="d-flex justify-content-center h-100">
        <div class="card">
            <div class="card-header">
                <h3>Uniciar sesión</h3>
            </div>
            <div class="card-body">
                <form action="<?= base_url('auth') ?>" method="post">
                    <?= csrf_field();?>
                    <div class="input-group form-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-user"></i></span>
                        </div>
                        <input type="text" class="form-control" name="user" placeholder="user" required>
                    </div>
                    <div class="input-group form-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-key"></i></span>
                        </div>
                        <input type="password" class="form-control" name="password" placeholder="password" required>
                    </div>
                    <div class="row align-items-center remember">
                        <input type="checkbox" name="remember">Recuerdame
                    </div>
                    <div class="form-group">
                        <input type="submit" value="Login" class="btn float-right login_btn">
                    </div>
                </form>
                
            </div>
            <div class="card-footer">
                <!--<div class="d-flex justify-content-center links">
                    ¿No tienes una cuenta?<a href="<?= base_url('register'); ?>">Unirte</a>
                </div>-->
                <div class="d-flex justify-content-center">
                    <a href="<?= base_url('password-request'); ?>">¿Olvidaste tu contraseña?</a>

                    
                    <?php if(session()->getFlashdata('errors')!==null):?>
                    <div class="alert alert-danger my-3" role="alert">
                        <?= session()->getFlashdata('errors');?>
                    </div>
                <?php endif;?>
                </div>
                <div class="d-flex justify-content-end social_icon">
                    <span><i class="fab fa-facebook-square"></i></span>
                    <span><i class="fab fa-google-plus-square"></i></span>
                    <span><i class="fab fa-twitter-square"></i></span>
                </div>
            </div>
        </div>
    </div>

<?= $this->endSection(); ?>
