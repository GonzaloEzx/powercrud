<?php
// genera_hash.php
$password = '2429'; // Cambia esto por la clave que quieras
$hash = password_hash($password, PASSWORD_DEFAULT);
echo $hash;
