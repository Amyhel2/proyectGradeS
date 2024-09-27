<?php echo $this->extend('layout/templateStart'); ?>

<?= $this->section('content'); ?>

<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h2>INICIO</h2>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item active">
                        <?= date('Y/m/d H:i:s'); ?>
                    </li>
                </ol>
            </div>
        </div>
    </div>
</section>

<?php if(session()->get('success')): ?>
    <div class="alert alert-success">
        <?= session()->get('success') ?>
    </div>
<?php endif; ?>

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <!-- Criminales Registrados -->
            <div class="col-lg-3 col-6">
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3><?= esc($totalCriminales); ?></h3>
                        <p>Criminales Registrados</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-person"></i>
                    </div>
                    <a href="<?= base_url('criminals'); ?>" class="small-box-footer">Ver más <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- Detecciones Realizadas -->
            <div class="col-lg-3 col-6">
                <div class="small-box bg-warning">
                    <div class="inner">
                        <h3><?= esc($totalDetecciones); ?></h3>
                        <p>Detecciones Realizadas</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-eye"></i>
                    </div>
                    <a href="<?= base_url('detections'); ?>" class="small-box-footer">Ver más <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- Notificaciones Enviadas -->
            <div class="col-lg-3 col-6">
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3><?= esc($totalNotificaciones); ?></h3>
                        <p>Notificaciones Enviadas</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-notifications"></i>
                    </div>
                    <a href="<?= base_url('notifications'); ?>" class="small-box-footer">Ver más <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- Oficiales Registrados -->
            <div class="col-lg-3 col-6">
                <div class="small-box bg-danger">
                    <div class="inner">
                        <h3><?= esc($totalOficiales); ?></h3>
                        <p>Oficiales Registrados</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-person-add"></i>
                    </div>
                    <a href="<?= base_url('users'); ?>" class="small-box-footer">Ver más <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
        </div>

        <!-- Sección de Gráficos -->
        <div class="row">
            <!-- Detecciones por Mes -->
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Detecciones por Mes</h3>
                    </div>
                    <div class="card-body">
                        <canvas id="deteccionesPorMes"></canvas>
                    </div>
                </div>
            </div>

            <!-- Criminales por Tipo -->
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Criminales por Tipo</h3>
                    </div>
                    <div class="card-body">
                        <canvas id="criminalesPorTipo"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Notificaciones Enviadas y Leídas + Actividad Reciente -->
        <div class="row">
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Notificaciones Enviadas y Leídas</h3>
                    </div>
                    <div class="card-body">
                        <canvas id="notificacionesChart"></canvas>
                    </div>
                </div>
            </div>

            
        </div>
    </div>

    <!-- Botón de Cerrar Sesión -->
    <div class="container-fluid text-center mt-4">
        <a href="<?= base_url('logout'); ?>" class="btn btn-primary">Cerrar sesión</a>
    </div>
</section>

<?= $this->endSection(); ?>



<!-- Scripts para los gráficos -->
<?= $this->section('script'); ?>

<script>
    var ctx = document.getElementById('deteccionesPorMes').getContext('2d');
    var deteccionesPorMesChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
            datasets: [{
                label: 'Detecciones',
                data: <?= json_encode(array_column($deteccionesPorMes, 'total')); ?>,
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>

<script>
    var ctx = document.getElementById('criminalesPorTipo').getContext('2d');
    var criminalesPorTipoChart = new Chart(ctx, {
        type: 'pie',
        data: {
            labels: <?= json_encode(array_column($criminalesPorTipo, 'tipo')); ?>,
            datasets: [{
                label: 'Criminales',
                data: <?= json_encode(array_column($criminalesPorTipo, 'total')); ?>,
                backgroundColor: ['rgba(255, 99, 132, 0.2)', 'rgba(54, 162, 235, 0.2)', 'rgba(255, 206, 86, 0.2)', 'rgba(75, 192, 192, 0.2)'],
                borderColor: ['rgba(255, 99, 132, 1)', 'rgba(54, 162, 235, 1)', 'rgba(255, 206, 86, 1)', 'rgba(75, 192, 192, 1)'],
                borderWidth: 1
            }]
        }
    });
</script>

<script>
    var ctx = document.getElementById('notificacionesChart').getContext('2d');
    var notificacionesChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['Enviadas', 'Leídas'],
            datasets: [{
                label: 'Notificaciones',
                data: <?= json_encode(array_column($notificacionesEnviadasLeidas, 'total')); ?>,
                backgroundColor: 'rgba(153, 102, 255, 0.2)',
                borderColor: 'rgba(153, 102, 255, 1)',
                borderWidth: 1
            }]
        }
    });
</script>

<?= $this->endSection(); ?>
