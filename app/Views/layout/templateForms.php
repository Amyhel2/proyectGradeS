<!-- Incluye el encabezado -->
<?= $this->include('dashboard/header') ?>

<!-- Incluye el menú -->
<?= $this->include('dashboard/menu') ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <!-- Aquí puedes agregar contenido específico del encabezado -->
      </div>
    </div><!-- /.container-fluid -->
  </section>

  <!-- Main content -->
  <section class="content">
    <?php echo $this->renderSection('content'); ?>
    <!-- Aquí se renderiza la sección de contenido principal -->
  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<!-- Incluye el pie de página -->
<?= $this->include('dashboard/footer') ?>
