<?php
    @!session_start();

    if(isset($_SESSION['login']))
    {
        $login = 'yes';
    }
    else
    {
        $login = 'no';
    }

    if(!isset($_SESSION['module']))
    {
        $_SESSION['module'] = 'trip';
    }

    if(!isset($_SESSION['view']))
    {
        $_SESSION['view'] = 'view';
    }

    $module = $_SESSION['module'];
    $view = $_SESSION['view'];

    if($module == 'trip')
    {
        $stage = get_session('stage');
    }

