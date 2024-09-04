<?php if (isset($imagen)): ?>
    <h2>Imagen Capturada</h2>
    <img src="<?= $imagen ?>" alt="Imagen Capturada">
<?php elseif (isset($error)): ?>
    <p><?= $error ?></p>
<?php endif; ?>
