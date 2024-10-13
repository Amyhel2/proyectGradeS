<?= $this->extend('layout/templateStart'); ?>

<?= $this->section('content'); ?>

<div class="container">
    <hr>
    <h3 id="titulo">UBICACION DE LA DETECCION</h3>
    <hr>
    <div id="map" style="height: 500px; width: 100%;"></div> <!-- Aquí se carga el mapa -->
    <hr>
</div>

<?= $this->endSection(); ?>

<?= $this->section('script'); ?>

<!-- Cargar la API de Google Maps -->
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDNM2US7zU1EIcyntDeXnwXXV9fLFyiU-4"></script>
<script>
    // Función para inicializar el mapa
    function initMap() {
        // Definir la ubicación con las coordenadas recibidas
        var location = {
            lat: parseFloat("<?= esc($lat); ?>"), 
            lng: parseFloat("<?= esc($long); ?>")
        };
        
        // Crear el mapa centrado en la ubicación
        var map = new google.maps.Map(document.getElementById('map'), {
            zoom: 15,
            center: location
        });

        // Agregar un marcador en la ubicación
        var marker = new google.maps.Marker({
            position: location,
            map: map
        });
    }

    // Asegurarse de que la función initMap se ejecute cuando se cargue la página
    window.onload = initMap;
</script>

<?= $this->endSection(); ?>
