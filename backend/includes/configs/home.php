<?php
    // tours query
    $tours = $pdo->query("SELECT * FROM `tours` LIMIT 6");
    $home_gallary = $pdo->query("SELECT * FROM `gallery` WHERE `media_type` = 'image' ORDER BY `id` DESC LIMIT 12");
    $feedbacks = $pdo->query("SELECT * FROM `feed_back` ORDER BY `id` DESC LIMIT 5");
    $team = $pdo->query('SELECT * FROM `team`');
    $services = $pdo->query("SELECT * FROM `services`");
