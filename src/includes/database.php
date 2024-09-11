<?php
define('DB_HOST', 'mysql-kinz.alwaysdata.net');
define('DB_USER', 'kinz');
define('DB_PASS', 'passer25');
define('DB_NAME', 'kinz_4');


try {
    $pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connection échoué: " . $e->getMessage();
}
