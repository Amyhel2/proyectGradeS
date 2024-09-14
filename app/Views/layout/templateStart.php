<?= $this->include('dashboard/header') ?> <!-- Incluye el encabezado -->

<?= $this->include('dashboard/menu') ?> <!-- Incluye el menú -->

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper ">
       
      <?php echo $this->renderSection('content');?>

  </div>
  <!-- /.content-wrapper -->

  <?= $this->include('dashboard/footer') ?> <!-- Incluye el pie de página -->
  