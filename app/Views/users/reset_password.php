

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
   <link href="<?=base_url('css/estiloResetPassword.css');?>" rel="stylesheet">
</head>

<body>
    
    <div class="container-fluid">


    <div class="container d-flex justify-content-center align-items-center vh-100">
    <div class="card shadow-lg border-0 rounded-3 w-100" style="max-width: 450px; background-color: #f9f9f9;">
        <div class="card-body p-4 p-sm-5">
            <h1 class="fs-4 card-title fw-bold mb-4 text-center">Restablecer la Contraseña</h1>
            <form method="POST" action="<?= base_url('password/reset'); ?>" autocomplete="off">
                <?= csrf_field(); ?>
                <input type="hidden" name="token" value="<?= $token; ?>">

                <div class="mb-4">
                    <label for="password" class="form-label">Nueva Contraseña</label>
                    <input type="password" class="form-control form-control-lg" name="password" id="password" placeholder="Ingresa tu nueva contraseña" required autofocus>
                </div>

                <div class="mb-4">
                    <label for="repassword" class="form-label">Confirmar Contraseña</label>
                    <input type="password" class="form-control form-control-lg" name="repassword" id="repassword" placeholder="Confirma tu nueva contraseña" required>
                </div>

                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary btn-lg rounded-pill">
                        Restablecer Contraseña
                    </button>
                </div>
            </form>

            <?php if (session()->getFlashdata('errors') !== null): ?>
                <div class="alert alert-danger mt-4" role="alert">
                    <?= session()->getFlashdata('errors'); ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>


    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous">
    </script>

</body>
</html>







