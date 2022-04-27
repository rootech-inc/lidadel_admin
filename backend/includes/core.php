<?php

    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    require 'db.php';
    require 'functions.php';
    require 'session.php';
    $host = $_SERVER['HTTP_HOST'];
    $root_addr = "http://$host/";
    $assets = $_SERVER['ASSETS_PATH'];
    $owner = 'anton';

    $client_ip = '154.160.20.146'; //get_client_ip();




    if($host === 'backend.lisadeltravelandtours.com')
    {
        $events_image_path = '/home/lisaavrb/public_html/asssets/events/';
        $services_path = '/home/lisaavrb/public_html/asssets/services/';
    }
    else
    {
        $events_image_path = '/home/stuffs/dev/PHP/lisadel_pub/asssets/events/';
        $services_path = '/home/stuffs/Development/PHP/lidadel_admin/assets/services/';
    }

//    echo $events_image_path;
//
//    die();
