<?= $this->extend('layout/templateStart'); ?>

<?= $this->section('content'); ?>

<div class="container">
    <hr>
    <h3 id="titulo">DETECCIONES</h3>

    <div class="table-responsive shadow-lg p-3 bg-body rounded">
        <table id="example1" class="table table-striped table-hover table-sm" aria-describedby="titulo">
            <thead class="bg-primary table-dark text-center">
                <tr>
                    <!--<th>ID Detección</th>-->
                    <th>#</th>
                    <th>Criminal</th>
                    <th>Oficial</th>
                    <th>Imagen Capturada</th>
                    <th>Ubicación</th>
                    <th>Nivel de Confianza</th>
                    <th>Fecha Detección</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $contador = 1;
                $ultimaUbicacion = ''; // Almacena la última ubicación encontrada

                foreach($detecciones as $deteccion): ?>
                <tr class="text-center">
                    <!--<td><?= esc($deteccion['idDeteccion']); ?></td>-->
                    <td><?= $contador++; ?></td>
                    <td><?= esc($deteccion['criminal_nombre']); ?></td>
                    <td><?= esc($deteccion['nombre_oficial']); ?></td>
                    <td>
                        <a href="<?= base_url('detection/' . esc($deteccion['idDeteccion']).'/images'); ?>" >Ver Imagen</a>
                    </td>
                    <td>
                        <?php
                            // Verifica si la ubicación está vacía
                            $ubicacion = !empty($deteccion['ubicacion']) ? esc($deteccion['ubicacion']) : $ultimaUbicacion;

                            // Actualiza la última ubicación solo si $ubicacion no está vacía
                            if (!empty($ubicacion)) {
                                $ultimaUbicacion = $ubicacion;
                            }

                            $latLong = explode(',', $ubicacion);
                            $lat = trim($latLong[0]);
                            $long = trim($latLong[1]);
                        ?>
                        <a href="<?= base_url("map/showMap/$lat/$long"); ?>" target="_self">Ver en el mapa</a> <!-- Enlace al mapa -->
                    </td>
                    <td><?= esc($deteccion['confianza']); ?></td>
                    <td><?= esc($deteccion['fecha_deteccion']); ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?= $this->endSection(); ?>
