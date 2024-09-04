<?php
$url = 'http://192.168.100.16/proyectgrades/camara/upload';
$imagePath = 'public/img/rec2.jpg'; // Cambia esta ruta a una imagen existente en tu sistema

$cfile = new CURLFile($imagePath, 'image/jpeg');
$data = array('image' => $cfile);

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$response = curl_exec($ch);
curl_close($ch);

echo $response;
