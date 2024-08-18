<?= $this->include('dashboard/header') ?> <!-- Incluye el encabezado -->

<?= $this->include('dashboard/menu') ?> <!-- Incluye el menú -->

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            
         
            
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">

    
      <?php echo $this->renderSection('content');?>

      

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <?= $this->include('dashboard/footer') ?> <!-- Incluye el pie de página -->