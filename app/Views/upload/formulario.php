<?php echo $this->extend('layout/templateStart'); ?>

<?= $this->section('content'); ?>
<h1>Subir archivos</h1>
<form action="<?php base_url('upload');?>" method="POST" enctype="multipart/form-data">
    
    <?= csrf_field(); ?>

    <p>
        <label for="archivo">Selecciona un archivo</label>
        <input type="file" name="archivo" id="archivo" accept="image/jpg, image/png">
        <button type="submit">Subir archivo</button>
    </p>
</form>

<?= $this->endSection(); ?>