<?php
    $db_server = 'localhost';
    $db_user = 'lisaavrb_anton';
    $db_password = 'Sunderland@411';
    $db = 'lisaavrb_tnt';

    // make pdo connection
    try {
        $pdo = new PDO("mysql:host=".$db_server.";dbname=".$db, $db_user, $db_password);
        // set the PDO error mode to exception
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch(PDOException $e) {
        echo "Connection failed: " . $e->getMessage();

    }


