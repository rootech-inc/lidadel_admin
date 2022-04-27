<?php
require 'backend/includes/core.php';
require 'backend/includes/configs/home.php';

?>
<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/font-awesome.css">

    <script src="https://cdn.jsdelivr.net/timepicker.js/latest/timepicker.min.js"></script>
    <link href="https://cdn.jsdelivr.net/timepicker.js/latest/timepicker.min.css" rel="stylesheet"/>

    <!-- jQuery library -->
    <script src="js/jquery.min.js"></script>

    <!-- Popper JS -->
    <script src="js/popper.min.js"></script>

    <!-- Latest compiled JavaScript -->
    <script src="js/bootstrap.min.js"></script>
    <script src="js/cust.js"></script>
    <link rel="shortcut icon" href="../asssets/logo.png" type="image/x-icon">
    <title>Lidadel - Backend</title>



</head>
<body>

    <?php if($login == 'no'): include 'backend/includes/parts/login.php'?>

    <?php endif; ?>

    <?php if($login == 'yes'): ?>
        <main class="container-fluid p-0">
            <div class="row no-gutters overflow-hidden h-100">
                <div class="col-sm-2 p-1 h-100 overflow-auto bg-dark">
                    <header class="">
                        <div class="w-100 h-100 d-flex flex-wrap align-content-center pl-2">
                            <strong class="text-light">Lisadel</strong>
                        </div>
                    </header>
                    <article class="">
                        <button data-toggle="collapse" data-target="#dashboard_items" class="text-left mb-2 w-100 <?php if(get_session('module') === 'dashboard'){echo 'active';} ?> btn rounded-0 btn-outline-light btn-sm">
                            <span class="fa fa-dashboard"></span> Dashboard
                        </button>
                        <div id="dashboard_items" class="collapse">
                            <ul class="nav flex-column">
                                <li class="nav-item">
                                    <a onclick="set_session('module=dashboard,view=bookings')" class="nav-link pointer nav_item">Bookings</a>
                                </li>
                                <li class="nav-item">
                                    <a onclick="set_session('module=dashboard,view=enquiry')" class="nav-link pointer nav_item">Contact</a>
                                </li>
                            </ul>
                        </div>

                        <button onclick="set_session('module=trip,view=all')" class="text-left <?php if(get_session('module') === 'trip'){echo 'active';} ?> mb-2 rounded-0 w-100 btn btn-outline-light btn-sm">
                            <span class="fa fa-plane"></span> Trips
                        </button>
                        <button data-toggle="collapse" data-target="#demo" class="text-left mb-2 rounded-0 <?php if(get_session('module') === 'utilities'){echo 'active';} ?> w-100 btn btn-outline-light btn-sm">
                            <span class="fa fa-cog"></span> Utilities
                        </button>
                        <div id="demo" class="collapse">
                            <ul class="nav flex-column">
                                <li class="nav-item">
                                    <a onclick="set_session('module=utilities,view=letter_head,letter_head=select')" class="nav-link pointer nav_item">Letter Head</a>
                                </li>
                                <li class="nav-item">
                                    <a onclick="set_session('module=utilities,view=services,service=all')" class="nav-link pointer nav_item">Services</a>
                                </li>
                            </ul>
                        </div>
                    </article>
                </div>

                <div class="col-sm-10 h-100 overflow-auto bg-light">

                    <header class="bg-dark">
                        <div class="w-100 h-100 d-flex flex-wrap justify-content-end align-content-center pr-2">
                            <button id="logout" class="btn btn-sm btn-danger">LOGOUT</button>
                        </div>
                    </header>
                    <article class="p-2 overflow-hidden">
                        <?php
                            if($module == 'trip') // trips
                            {
                                if($view == 'all') // view all trips
                                {
                                    // get trips
                                    $trips = $pdo->query("SELECT * FROM `tours` order by `touy_id` DESC ");
                                    $trips_count = $trips->rowCount();
                                    include "backend/includes/parts/trips/all_trips.php";
                                }

                                elseif ($view == 'ytube')
                                {
                                    include "backend/includes/parts/trips/youtube_links.php";
                                }

                                elseif ($view == 'new') // add new event
                                {
                                    if(!isset($_SESSION['event_stage']))
                                    {
                                        set_session('event_stage','core');
                                    }
                                    $event_stage = get_session('event_stage');
                                    include "backend/includes/parts/trips/new3.php";
                                } 

                                elseif ($view == 'add_images') // add images to an event gallery
                                {
                                    $event = get_session('event');
                                    include "backend/includes/parts/trips/upload_images.php";
                                }

                                elseif ($view === 'edit') // edit event
                                {
                                    $event_uni = get_session('event');
                                    $event = fetchFunc('tours',"`tour_uni` = '$event_uni'",$pdo);
                                    $highlight = $pdo->query("SELECT * FROM `highlights` WHERE  `event` = '$event_uni'");
                                    $schedule = $pdo->query("SELECT * FROM `tour_scedule` where `event` = '$event_uni'");
                                    $package = $pdo->query("SELECT * FROM `tour_packages` where `event` = '$event_uni'");

                                    // get packages


                                    // get cover image
                                    $files_path =

                                    include "backend/includes/parts/trips/edit.php";
                                }

                                elseif ($view === 'bookings') // bookings of event
                                {
                                    $event = get_session('event');
                                    $booking_query = $pdo->query("select * from events_booking WHERE `event` = '$event' ORDER BY id DESC");
                                    $booking_count = $booking_query->rowCount();
                                    include 'backend/includes/parts/trips/bookings.php';
                                }

                            }

                            elseif ($module === 'utilities') // utilities
                            {
                                if($view === 'services') // home
                                {
                                    $service = get_session('service');
                                    if($service === 'all')
                                    {
                                        $services = $pdo->query("SELECT * FROM `services`");
                                    }
                                    if ($service === 'single')
                                    {
                                        $services = get_session('srv');
                                        $srv_count = rowsOf('services',"`id` = $services",$pdo);
                                        if($srv_count > 0)
                                        {
                                            $srv = fetchFunc('services',"`id` = $services",$pdo);
                                        }

                                    }
                                    include 'backend/includes/parts/util/services.php';
                                }
                                elseif ($view === 'letter_head') // letter head
                                {
                                    $letter_head = get_session('letter_head');
                                    include 'backend/includes/parts/util/letter_head.php';
                                }
                            }

                            elseif ($module === 'dashboard') // dashboard
                            {
                                if($view === 'bookings') // bookings
                                {
                                    // get bookings
                                    $booking_query = $pdo->query("select * from events_booking ORDER BY id DESC");
                                    $booking_count = $booking_query->rowCount();
                                    include 'backend/includes/parts/dashboard/bookings.php';

                                }
                            }

                        ?>
                    </article>
                </div>

            </div>
        </main>
        <div class="modal fade" id="loader">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body p-2 py-5 pb-2">
                        <div class="spinner-grow text-primary" role="status">
                            <span class="sr-only">Loading...</span>
                        </div>
                        <div class="spinner-grow text-secondary" role="status">
                            <span class="sr-only">Loading...</span>
                        </div>
                        <div class="spinner-grow text-success" role="status">
                            <span class="sr-only">Loading...</span>
                        </div>
                        <div class="spinner-grow text-danger" role="status">
                            <span class="sr-only">Loading...</span>
                        </div>
                        <div class="spinner-grow text-warning" role="status">
                            <span class="sr-only">Loading...</span>
                        </div>
                        <div class="spinner-grow text-info" role="status">
                            <span class="sr-only">Loading...</span>
                        </div>
                        <div class="spinner-grow text-light" role="status">
                            <span class="sr-only">Loading...</span>
                        </div>
                        <div class="spinner-grow text-dark" role="status">
                            <span class="sr-only">Loading...</span>
                        </div>

                        <hr>

                        <div class="w-100 mb-2">
                            <progress style="display: none" class="progress w-100" value="0" max="100"></progress>
                        </div>

                        <i class="text-danger text-center" id="form_err"></i>

                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
</body>
</html>
