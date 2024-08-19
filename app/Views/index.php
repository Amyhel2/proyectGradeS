<?php echo $this->extend('layout/templateStart'); ?>

<?= $this->section('content'); ?>
<p>Bienvenido al sistema</p>
<a href="<?=base_url('logout');?>">Cerrar secion</a>
<?= $this->endSection(); ?>