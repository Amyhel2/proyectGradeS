<!-- jQuery -->
<script src="<?php echo base_url();?>/assets/plugins/jquery/jquery.min.js"></script>

<!-- Bootstrap Bundle (usa Bootstrap 5 o 4, dependiendo de tu proyecto) -->
<script src="<?php echo base_url() ?>/assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- AdminLTE App -->
<script src="<?php echo base_url();?>/assets/dist/js/adminlte.min.js"></script>

<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- Demo scripts (si es necesario, aunque generalmente no es recomendable en producción) -->
<script src="<?php echo base_url() ?>/assets/dist/js/demo.js"></script>

<!-- DataTables & Plugins -->
<script src="<?php echo base_url() ?>/assets/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url() ?>/assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="<?php echo base_url() ?>/assets/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="<?php echo base_url() ?>/assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="<?php echo base_url() ?>/assets/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="<?php echo base_url() ?>/assets/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="<?php echo base_url() ?>/assets/plugins/jszip/jszip.min.js"></script>
<script src="<?php echo base_url() ?>/assets/plugins/pdfmake/pdfmake.min.js"></script>
<script src="<?php echo base_url() ?>/assets/plugins/pdfmake/vfs_fonts.js"></script>
<script src="<?php echo base_url() ?>/assets/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="<?php echo base_url() ?>/assets/plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="<?php echo base_url() ?>/assets/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>

<!-- DataTables initialization -->
<script>
  $(function () {
    // Para la tabla #example1 con botones y control de columnas
    $("#example1").DataTable({
      "responsive": true,
      "lengthChange": false,
      "autoWidth": false,
      "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"] // Añade colVis para controlar visibilidad
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');

    // Tabla #example2 básica sin botones
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
    });
  });
</script>

<!-- Sección de scripts personalizados -->
<?php echo $this->renderSection('script'); ?>
