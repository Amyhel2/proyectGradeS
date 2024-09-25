<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
   <link href="<?=base_url('css/estiloLinkResPas.css');?>" rel="stylesheet">
</head>

<body>
    
    <div class="container-fluid">


    <div class="container d-flex justify-content-center align-items-center vh-100">
    <div class="card shadow-lg border-0 rounded-3 w-100 w-md-50" style="max-width: 500px;">
        <div class="card-body p-4 p-sm-5">
            <h1 class="fs-4 card-title fw-bold mb-4 text-center">¿Has olvidado tu contraseña?</h1>
            <form method="POST" action="<?= base_url('password-email'); ?>" autocomplete="off">
                <?= csrf_field(); ?>

                <div class="mb-4">
                    <label for="email" class="form-label">Correo Electrónico</label>
                    <input type="email" class="form-control form-control-lg" name="email" id="email" placeholder="Ingresa tu correo electrónico" required autofocus>
                </div>

                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary btn-lg rounded-pill">
                        Enviar Enlace
                    </button>
                </div>
            </form>

            <?php if (session()->getFlashdata('errors') !== null): ?>
                <div class="alert alert-danger my-3" role="alert">
                    <?= session()->getFlashdata('errors'); ?>
                </div>
            <?php endif; ?>
        </div>

        <div class="card-footer py-3 border-0  text-center">
            <a href="<?= base_url(); ?>" class="btn btn-link ac">
                Volver a Iniciar Sesión
            </a>
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





