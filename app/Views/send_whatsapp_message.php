<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enviar Mensaje de WhatsApp</title>
</head>
<body>
    <h1>Enviar Mensaje de WhatsApp</h1>

    <form action="<?= base_url('whatsapp/send') ?>" method="post">
    <?= csrf_field(); ?>
        <label for="number">Número de WhatsApp (con código de país):</label>
        <input type="text" id="number" name="number" required>
        <br><br>

        <label for="message">Mensaje:</label>
        <textarea id="message" name="message" required></textarea>
        <br><br>

        <button type="submit">Enviar Mensaje</button>
    </form>

    <?php if (isset($result)): ?>
        <p><strong>Resultado:</strong> <?= $result ?></p>
    <?php endif; ?>
</body>
</html>
