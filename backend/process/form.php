<?php

    require '../includes/core.php';





    if($_SERVER['REQUEST_METHOD'] === 'POST')
    {
        if(isset($_POST['function']))
        {
            $func = post('function');
            if ($func === 'set_session') // switch session
            {
                $session_d = htmlentities($_POST['session_data']);
                // slip each session data
                $session_data = explode(',',$session_d);

                if(count($session_data) > 0)
                {
                    // explode data
                    foreach ($session_data as $index => $data)
                    {
                        if(count(explode('=',$data)) === 2)
                        {
                            $var = explode('=',$data)[0];
                            $val = explode('=',$data)[1];
                            set_session((string)$var, (string)$val);


                        }
                    }
                    echo 'done';
                }
            }

            elseif ($func === 'event_text') // new event text
            {
                $title = post('title');
                $description = post('description');
                $star_date = post('star_date');
                $star_time = post('star_time');
                $end_date = post('end_date');
                $end_time = post('end_time');
                $uni = md5($title.$description.$star_date.$end_time.$star_date);

                // test trip duration
                $trip_days = dateDifference((string)$star_date, (string)$end_date);
                $trip_hours = dateDifference($star_time,$end_time,'%i');
                if((int)$trip_days > 0 || (int)$trip_hours > 1)
                {

                    // set sessions
                    set_session("title", (string)$title);
                    set_session("description", (string)$description);
                    set_session("star_date", (string)$star_date);
                    set_session("star_time", (string)$star_time);
                    set_session("end_date", (string)$end_date);
                    set_session("end_time", (string)$end_time);
                    set_session('stage','packages');
                    set_session('uni',$uni);
                    echo "done%%Done setting text";

                }
                else
                {
                    echo "err%%Tour Duration must be more than a day or a minute";
                }


            }

            elseif ($func === 'packages') // set packages
            {
                $adult = post('adult');
                $couple = post('couple');
                $kids = post('kids');

                if(strlen($adult) > 0)
                {
                    set_session('adult',number_format($adult,2));
                }
                if(strlen($couple) > 0)
                {
                    set_session('couple',number_format($couple,2));
                }
                if(strlen($kids) > 0)
                {
                    set_session('kids',number_format($kids,2));
                }


                set_session('stage','media');

                echo 'done%%';

            }

            elseif ($func === 'media') // upload media and finalise adding event
            {

                // get sessions
                $title = get_session('title');
                $description = get_session('description');
                $star_date = get_session('star_date');
                $star_time = get_session('star_time');
                $end_date = get_session('end_date');
                $end_time = get_session('end_time');
                $uni = get_session('uni');
                $path = '../../../asssets/events/';

                if(isset($_FILES['cover_image']))
                {
                    $cover_image = post_file('cover_image');
                    // validate file type
                    if($cover_image['type'] != 'image/jpeg')
                    {
                        echo "err%%File Should be JPG format";
                        die();
                    }

                    // upload tour image
                    $ext = pathinfo($cover_image['name'],PATHINFO_EXTENSION);
                    // create event folder
                    if (@!mkdir($concurrentDirectory = $path . $uni) && !is_dir($concurrentDirectory)) {
                        throw new \RuntimeException(sprintf('Directory "%s" was not created', $concurrentDirectory));
                    }


                    $cover_file = "$path$uni/cover.$ext";
                    // move cover
                    move_uploaded_file($cover_image['tmp_name'],$cover_file);

                }

                if(isset($_FILES['gall_images']))
                {
                    if(!empty(array_filter($_FILES['gall_images']['name'])))
                    {
                        foreach ($_FILES['gall_images']['tmp_name'] as $key => $value)
                        {
                            $file_tmp_name = $_FILES['gall_images']['tmp_name'][$key];
                            $file_name = htmlentities($_FILES['gall_images']['name'][$key]);
                            $file_size = $_FILES['gall_images']['size'][$key];
                            $calc_file_size = file_size($file_size);
                            $act_file_ext = pathinfo($file_name, PATHINFO_EXTENSION);
                            $file_ext = strtolower($act_file_ext);

                            // upload files to gallary
                            $new_file_name = md5($file_name).".$act_file_ext";
                            $new_path = "$path$uni/$new_file_name";

                            $sql = "INSERT INTO `gallery` (`id`, `event`, `media_type`, `media_name`, `title`, `description`, `owner`, `date_added`) 
                                   VALUES 
                                   (NULL, '$uni', 'image', '$new_file_name', '$title', '$description', 'none', current_timestamp())";

                            if((rowsOf('gallery', "`media_name` = '$new_file_name'", $pdo) < 1) && move_uploaded_file($file_tmp_name, "$new_path")) {

                                $pdo->exec($sql);
                            }

                        }

                    }
                }

                // insert event
                $event_sql = "INSERT INTO `tours` (`touy_id`, `tour_uni`, `title`, `description`, `start_date`, `start_time`, `end_date`, `end_time`, `owner`, `date_created`) VALUES 
                                                  (NULL, '$uni', '$title', '$description', '$star_date', '$star_time', '$end_date', '$end_time', '00', current_timestamp())";

                if((rowsOf('tours', "`tour_uni` = '$uni'", $pdo) < 1) && $pdo->exec($event_sql)) {
                    if(isset($_SESSION['adult']))
                    {

                        // enter adult package
                        $adult = get_session('adult');
                        if(rowsOf('tour_packages',"`event` = '$uni' AND `target` = '$adult'",$pdo) < 1)
                        {
                            $sql = "INSERT INTO `tour_packages` (`id`, `event`, `p_type`, `target`, `description`, `value`) VALUES 
                                                                (NULL, '$uni', 'c', 'adult', 'cost', '$adult')";
                            $pdo->exec($sql);
                        }
                    }

                    if(isset($_SESSION['couple']))
                    {

                        // enter adult package
                        $couple = get_session('couple');
                        if(rowsOf('tour_packages',"`event` = '$uni' AND `target` = '$couple'",$pdo) < 1)
                        {
                            $sql = "INSERT INTO `tour_packages` (`id`, `event`, `p_type`, `target`, `description`, `value`) VALUES 
                                                                (NULL, '$uni', 'c', 'couple', 'cost', '$couple')";
                            $pdo->exec($sql);
                        }
                    }

                    if(isset($_SESSION['kids']))
                    {

                        // enter adult package
                        $kids = get_session('kids');
                        if(rowsOf('tour_packages',"`event` = '$uni' AND `target` = '$kids'",$pdo) < 1)
                        {
                            $sql = "INSERT INTO `tour_packages` (`id`, `event`, `p_type`, `target`, `description`, `value`) VALUES 
                                                                (NULL, '$uni', 'c', 'kids', 'cost', '$kids')";
                            $pdo->exec($sql);
                        }
                    }
                }

                set_session('view','all');
                // unset sessions
                unset_session('kids,couple,adults'); // session package
                unset_session("title,description,star_date,star_time,end_date,end_time,uni"); // text



                echo 'done%%';

            }

            elseif ($func === 'general_event') // one time upload
            {



                // get text values
                $error = 0;
                $title = post('title');
                $description = post('description');
                $star_date = post('star_date');
                $star_time = post('star_time');
                $end_date = post('end_date');
                $end_time = post('end_time');
                $uni = md5($title.$description.$star_date.$end_time.$star_date);
                $path = '../../../lisadel_pub/asssets/events/';

                // packages
                $adult = post('adult');
                $couple = post('couple');
                $kids = post('kids');

                $event_sql = "INSERT INTO `tours` (`touy_id`, `tour_uni`, `title`, `description`, `start_date`, `start_time`, `end_date`, `end_time`, `owner`, `date_created`) VALUES 
                                                  (NULL, '$uni', '$title', '$description', '$star_date', '$star_time', '$end_date', '$end_time', '00', current_timestamp())";

                if((rowsOf('tours', "`tour_uni` = '$uni'", $pdo) < 1))
                {
                    // media
                    if(isset($_FILES['cover_image']))
                    {
                        $cover_image = post_file('cover_image');
                        $cover_tmp = $cover_image['tmp_name'];

                        // create folder
                        $ext = pathinfo($cover_image['name'],PATHINFO_EXTENSION);
                        // create event folder
                        if (@!mkdir($concurrentDirectory = $path . $uni) && !is_dir($concurrentDirectory)) {
                            throw new \RuntimeException(sprintf('Directory "%s" was not created', $concurrentDirectory));
                        }

                        $thumbnail_dir = "$path$uni/thumbs";
                        if (!mkdir($thumbnail_dir) && !is_dir($thumbnail_dir)) {
                            throw new \RuntimeException(sprintf('Directory "%s" was not created', $thumbnail_dir));
                        }



                        $cover_file = "$path$uni/cover.$ext";
                        if(!compress_image($cover_tmp,$cover_file,10))
                        {
                            $error = 1;
                        }


                    }

                    if($error < 1)
                    {
                        // add event to events
                        if((rowsOf('tours', "`tour_uni` = '$uni'", $pdo) < 1) && $pdo->exec($event_sql))
                        {
                            // packages
                            if(isset($_POST['adult']))
                            {

                                // enter adult package
                                if(rowsOf('tour_packages',"`event` = '$uni' AND `target` = '$adult'",$pdo) < 1)
                                {
                                    $sql = "INSERT INTO `tour_packages` (`id`, `event`, `p_type`, `target`, `description`, `value`) VALUES 
                                                                (NULL, '$uni', 'c', 'adult', 'cost', '$adult')";
                                    $pdo->exec($sql);
                                }
                            }

                            if(isset($_POST['couple']))
                            {

                                // enter adult package;
                                if(rowsOf('tour_packages',"`event` = '$uni' AND `target` = '$couple'",$pdo) < 1)
                                {
                                    $sql = "INSERT INTO `tour_packages` (`id`, `event`, `p_type`, `target`, `description`, `value`) VALUES 
                                                                (NULL, '$uni', 'c', 'couple', 'cost', '$couple')";
                                    $pdo->exec($sql);
                                }
                            }

                            if(isset($_POST['kids']))
                            {

                                // enter adult package
                                if(rowsOf('tour_packages',"`event` = '$uni' AND `target` = '$kids'",$pdo) < 1)
                                {
                                    $sql = "INSERT INTO `tour_packages` (`id`, `event`, `p_type`, `target`, `description`, `value`) VALUES 
                                                                (NULL, '$uni', 'c', 'kids', 'cost', '$kids')";
                                    $pdo->exec($sql);
                                }
                            }

                            //echo 'done%%';
                        }
                    }
                    else
                    {
                        echo 'err%%';
                    }
                    set_session('view','all');
                    echo 'done%%';
                }
                else
                {
                    set_session('err','There was an issues processing event');
                }

//                header("Location:".$_SERVER['HTTP_REFERER']);
//
//                die();
            }

            elseif ($func === 'upload_images_after') // add images to gallary
            {
                if(isset($_FILES['gall_images']))
                {
                    if(!empty(array_filter($_FILES['gall_images']['name'])))
                    {
                        $uni = get_session('event');
                        $path = $events_image_path;
                        foreach ($_FILES['gall_images']['tmp_name'] as $key => $value)
                        {
                            $file_tmp_name = $_FILES['gall_images']['tmp_name'][$key];
                            $file_name = htmlentities($_FILES['gall_images']['name'][$key]);
                            $file_size = $_FILES['gall_images']['size'][$key];
                            $calc_file_size = file_size($file_size);
                            $act_file_ext = pathinfo($file_name, PATHINFO_EXTENSION);
                            $file_ext = strtolower($act_file_ext);
                            $title = fetchFunc('tours',"`tour_uni` = '$uni'",$pdo)['title'];
                            $description = fetchFunc('tours',"`tour_uni` = '$uni'",$pdo)['title'];

                            // upload files to gallary
                            $new_file_name = md5($file_name).".$act_file_ext";
                            $new_path = "$path$uni/$new_file_name";

                            $sql = "INSERT INTO `gallery` (`id`, `event`, `media_type`, `media_name`, `title`, `description`, `owner`, `date_added`) 
                                   VALUES 
                                   (NULL, '$uni', 'image', '$new_file_name', '$title', '$description', 'none', current_timestamp())";

                            if(rowsOf('gallery', "`media_name` = '$new_file_name'", $pdo) > 0)
                            {
                                deleteRow('gallery', "`media_name` = '$new_file_name'", $pdo);
                            }

                            if(compress_image($file_tmp_name, (string)$new_path,10)) {


                                if($pdo->exec($sql))
                                {
                                    // create thumbnail
                                    $thumbnail = "$path$uni"."thumbs/$new_file_name";
                                    echo $uni;
                                    die();
                                    // compress thumbnail
                                    compress_image($new_path,$thumbnail,2);
                                    set_session('err','thumb uploaded');
                                }
                            }
                            else
                            {
                                set_session('err','failed compressing and upload');
                            }



                        }

//                        echo get_session('err');
//                        die();


//                        set_session('err',"Uploaded");
//                        set_session('view','all');
//                        header("Location:".$_SERVER['HTTP_REFERER']);

                    }
                }
                set_session('view','all');
                unset_session('event');
                echo 'done%%';
            }

            elseif ($func === 'delete_event') // delete event
            {
                $event = post('event');

                // delete from db
                deleteRow('tours',"`tour_uni` = '$event'",$pdo);
                // delete gallery
                deleteRow('gallery',"`event` = '$event'",$pdo);
                // delete packages
                deleteRow('gallery',"`event` = '$event'",$pdo);
                // deletes images
                $path = '/home/stuffs/dev/PHP/lisadel_pub/asssets/events/';

                $thumbs = "$path$event/thumbs/";
                $thumbs_globe = glob($thumbs.'*');
                foreach($thumbs_globe as $file) {

                    if(is_file($file))
                    {
                        // Delete the given file
                        unlink($file);
                    }
                }
                // deleted thumbs folder
                if(is_dir($thumbs))
                {
                    rmdir($thumbs);
                }

                $images = "$path$event/";
                $images_globe = glob($images.'*');
                foreach($images_globe as $file) {

                    if(is_file($file))
                    {
                        // Delete the given file
                        unlink($file);
                    }
                }
                // deleted thumbs folder
                if(is_dir($images))
                {
                    rmdir($images);
                }


                echo 'done%%';


            }

            elseif ($func === 'update_event') // update event
            {


                // get text values
                $error = 0;
                $title = post('title');
                $description = post('description');
                $star_date = post('star_date');
                $star_time = post('star_time');
                $end_date = post('end_date');
                $end_time = post('end_time');
                $uni = get_session('event');
                $path = '../../../lisadel_pub/asssets/events/';

                // update
                $update_sql = "UPDATE `tours` SET 
                   `title`='$title',
                   `description`='$description',
                   `start_date`='$star_date',
                   `start_time`='$star_time',
                   `end_date`='$end_date',
                   `end_time`='$end_time',
                   `owner`='$owner' WHERE `tour_uni` = '$uni'";



                try {

                    $pdo->exec($update_sql);

                    // cover image
                    if(isset($_FILES['cover_image'])) // upload cover image
                    {

                        $cover_image = post_file('cover_image');
                        if($cover_image['error'] === 0)
                        {
                            $cover_tmp = $cover_image['tmp_name'];

                            // create folder
                            $ext = pathinfo($cover_image['name'],PATHINFO_EXTENSION);


                            $cover_file = "$path$uni/cover.$ext";
                            !compress_image($cover_tmp,$cover_file,50);
                        }



                    }

                    // packages
                    if(isset($_POST['adult'])) // adult packages
                    {
                        $adult = post('adult');
                        // enter adult package
                        $pdo->exec("UPDATE `tour_packages` SET `value` = '$adult' WHERE `event` = '$uni' AND `target` = 'adult'");

                    }

                    if(isset($_POST['couple'])) // couple package
                    {
                        $couple = post('couple');
                        // enter adult package
                        $pdo->exec("UPDATE `tour_packages` SET `value` = '$couple' WHERE `event` = '$uni' AND `target` = 'couple'");

                    }

                    if(isset($_POST['kids'])) // kids package
                    {
                        $kids = post('kids');
                        // enter adult package
                        $pdo->exec("UPDATE `tour_packages` SET `value` = '$kids' WHERE `event` = '$uni' AND `target` = 'kids'");

                    }

                    set_session('view','all');
                    echo 'done%%';
                } catch (PDOException $exception)
                {
                    echo $exception->getMessage();
                }

            }

            elseif ($func === 'update_event_v2') // update event 2
            {

//                print_r($_FILES);
//                die();
                $title = post('title');

                $country = post('country');
                $city = post('city');
                $type = post('type');
                $group_size = post('group_size');

                $star_date = post('star_date');
                $star_time = post('star_time');
                //$star_time = date("g:i a", strtotime((string)$s_time));
                $end_date = post('end_date');
                $end_time = post('end_time');
                //$end_time = date("g:i a", strtotime((string)$e_time));
                $overview = base64_encode(post('details'));

                $highlights = post('overview');
                $schedule = post('schedule');
                $packages = post('packages');
                $uni = get_session('event');
                $path = $events_image_path;
                if(empty($overview))
                {
                    err('submit_again');
                    die();
                }



                // delete packages and add
                deleteRow('tour_packages',"`event` = '$uni'",$pdo);
                // add packages
                $text = trim($packages);
                $textAr = explode("\n", $text);
                $textAr = array_filter($textAr, 'trim'); // remove any extra \r characters left behind
                foreach ($textAr as $line) {
                    // explode each package
                    $pack_explode = explode(':',$line);
                    if(count($pack_explode) === 2)
                    {
                        $target = $pack_explode[0];
                        $value = $pack_explode[1];

                        // insert into packages
                        if(rowsOf('tour_packages',"`event` = '$uni' AND `target` = '$target'",$pdo) < 1)
                        {
                            $sql = "INSERT INTO `tour_packages` (`id`, `event`, `p_type`, `target`, `description`, `value`) VALUES 
                                                                (NULL, '$uni', 'c', '$target', 'cost', '$value')";
                            $pdo->exec($sql);
                        }

                    }
                    // processing here.
//                            if(rowsOf("highlights","`event` = '$uni' AND `light` = '$line'",$pdo) < 1)
//                            {
//                                $sql = $pdo->exec("INSERT INTO `highlights` (`id`, `event`, `light`) VALUES (NULL, '$uni', '$line')");
//                            }

                }

                // delete highlight
                deleteRow('highlights',"`event` = '$uni'",$pdo);
                // add highlights
                $text = trim($highlights);
                $textAr = explode("\n", $text);
                $textAr = array_filter($textAr, 'trim'); // remove any extra \r characters left behind
                foreach ($textAr as $line) {
                        // processing here.
                        if(rowsOf("highlights","`event` = '$uni' AND `light` = '$line'",$pdo) < 1)
                        {
                            $sql = $pdo->exec("INSERT INTO `highlights` (`id`, `event`, `light`) VALUES (NULL, '$uni', '$line')");
                        }

                    }

                // schedule
                deleteRow('tour_scedule',"`event` = '$uni'",$pdo);
                // add schedule
                $text = trim($schedule);
                $textAr = explode("\n", $text);
                $textAr = array_filter($textAr, 'trim'); // remove any extra \r characters left behind
                foreach ($textAr as $line) {

                    // explode schedule
                    $sch_explode = explode('^',$line);
                    if(count($sch_explode) === 5)
                    {
                        $date = $sch_explode[0];
                        $time = $sch_explode[1];
                        $title_m = $sch_explode[2];
                        $details = $sch_explode[4];
                        $location = $sch_explode[3];


                        // insert into schedules
                        $sql = "INSERT INTO `tour_scedule` (`event`, `date`, `time`, `location`, `title`, `description`) VALUES 
                                                                    ('$uni', '$date', '$time', '$location', '$title_m', '$details')";
                        if(rowsOf('tour_scedule',"`event` = '$uni' AND `location` = '$location' AND `description` = '$details'",$pdo) < 1)
                        {
                            $pdo->exec($sql);
                        }
                    }

                }


                // change cover image
                if(isset($_FILES['cover_image']))
                {
                    // upload file
                    $error = $_FILES['cover_image']['error'];

                    if($error == '0')
                    {
                        $cover_image = post_file('cover_image');
                        $cover_tmp = $cover_image['tmp_name'];

                        // create folder
                        $ext = pathinfo($cover_image['name'],PATHINFO_EXTENSION);
                        // create event folder
                        if (@!mkdir($concurrentDirectory = $path . $uni) && !is_dir($concurrentDirectory)) {
                            throw new \RuntimeException(sprintf('Directory "%s" was not created', $concurrentDirectory));
                        }

                        $thumbnail_dir = "$path$uni/thumbs";
                        if(!is_dir($thumbnail_dir) && !mkdir($thumbnail_dir) && !is_dir($thumbnail_dir)) {
                            throw new \RuntimeException(sprintf('Directory "%s" was not created', $thumbnail_dir));
                        }

                        $cover_file = "$path$uni/cover.$ext";
                        if(!compress_image($cover_tmp,$cover_file,10))
                        {
//                            err("Could not upload image");
//                            exit();
                        } else
                        {
                            done("image uploaded to $cover_file");
                        }
                    }
                    else
                    {
                        err("there is image error");
                    }



                }

                // update record
                $tour_sql_update = "UPDATE `tours` SET 
                   `title`='$title',
                   `overview`='$overview',
                   `start_date`='$star_date',
                   `start_time`='$star_time',
                   `end_date`='$end_date',
                   `end_time`='$end_time',
                   `country`='$country',
                   `city`='$city',
                   `type`='$type',
                   `group_size`='$group_size' WHERE `tour_uni` = '$uni'";



                try {
                    $pdo->exec($tour_sql_update);
                    set_session('view','all');
                    done();
                } catch (PDOException $e)
                {
                    $msg = $e->getMessage();
                    err($msg);
                }
                       





            }

            elseif($func === 'add_service') // add service
            {


                $error = 1;
                $title = post('title');
                $description = post('description');
                if(empty($_POST['description']))
                {
                    err('submit_again');
                    die();
                }
                if(isset($_FILES['cover_image']))
                {

                    $cover_file = post_file('cover_image');
                    $file_name = $cover_file['name'];
                    $tmp_name = $cover_file['tmp_name'];
                    $ext = pathinfo($file_name, PATHINFO_EXTENSION);
                    $path = $services_path;
                    // upload image
                    $new_file_name = md5($file_name.$path.$tmp_name);
                    $new_img = "$new_file_name.$ext";
                    $new_file = "$path/$new_img";

                    // upload image
                    if(compress_image($tmp_name,$new_file,10))
                    {

                        $error = 0;

                    }
                    else
                    {
                        err('cant upload image');
                    }
                }
                else
                {
                    err("No Image");
                }

                if($error === 0)
                {
                    // add it to db
                    if($pdo->exec("INSERT INTO `services`(`title`, `description`, `img`, `owner`) VALUES ('$title','$description','$new_img','$owner')"))
                    {
                        set_session('service','all');
                        echo 'done%%';
                    }
                    else
                    {
                        err('cant insert into db');
                    }
                }
            }

            elseif($func === 'edit_service') // edit service
            {


                $title = post('title');
                $description = post('description');
//                echo $description;
//                die();
                if(empty($_POST['description']))
                {
                    err('submit_again');
                    die();
                }

                if(isset($_FILES['cover_image']) && !empty($_FILES['cover_image']['name']))
                {
                    $cover_file = post_file('cover_image');
                    $file_name = $cover_file['name'];
                    $tmp_name = $cover_file['tmp_name'];
                    $ext = pathinfo($file_name, PATHINFO_EXTENSION);
                    $path = $services_path;
                    // upload image
                    $new_file_name = md5($file_name.$path.$tmp_name);
                    $new_img = post('image');
                    $new_file = "$path$new_img";
                    //echo $path;

                    // upload image
                    if(!compress_image($tmp_name,$new_file,50))
                    {
                        err("Image Not Uploaded");
                    }
                }
                else
                {
                    err("NO IMAGE");
                }
                $id = get_session('srv');

                // add it to db
                try {
                    $pdo->exec("UPDATE `services` SET `title`='$title',`description`='$description' WHERE `id` = $id");
                    set_session('service','all');
                    echo 'done%%';
                } catch (PDOException $e)
                {

                    echo 'err%%'.$e->getMessage();
                }
            }

            elseif ($func === 'general_event_v2')
            {

                $title = post('title');

                $country = post('country');
                $city = post('city');
                $type = post('type');
                $group_size = post('group_size');

                $star_date = post('star_date');
                $star_time = post('star_time');
                //$star_time = date("g:i a", strtotime((string)$s_time));
                $end_date = post('end_date');
                $end_time = post('end_time');
                //$end_time = date("g:i a", strtotime((string)$e_time));
                $overview = base64_encode(post('details'));

                $highlights = base64_encode(post('details'));
                $schedule = post('schedule');
                $packages = post('packages');
                $uni = md5($title.$overview.$star_date.$end_time.$star_date);
                if(empty($overview))
                {
                    err('submit_again');
                    die();
                }




                $path = $events_image_path;


                if((rowsOf('tours', "`tour_uni` = '$uni'", $pdo) < 1))
                {
                    // if there is cover image
                    if(isset($_FILES['cover_image']))
                    {
                        // upload file
                        $cover_image = post_file('cover_image');
                        $cover_tmp = $cover_image['tmp_name'];

                        // create folder
                        $ext = pathinfo($cover_image['name'],PATHINFO_EXTENSION);
                        // create event folder
                        if (@!mkdir($concurrentDirectory = $path . $uni) && !is_dir($concurrentDirectory)) {
                            throw new \RuntimeException(sprintf('Directory "%s" was not created', $concurrentDirectory));
                        }

                        $thumbnail_dir = "$path$uni/thumbs";
                        if(!is_dir($thumbnail_dir) && !mkdir($thumbnail_dir) && !is_dir($thumbnail_dir)) {
                            throw new \RuntimeException(sprintf('Directory "%s" was not created', $thumbnail_dir));
                        }

                        $cover_file = "$path$uni/cover.$ext";
                        if(!compress_image($cover_tmp,$cover_file,30))
                        {
                            err("Could not upload image");
                            exit();
                        }
                        else{
                        }

                    }
                    else
                    {
                        err("Please image is required");
                        exit();
                    }

                    $tour_sql = "INSERT INTO `tours` (`touy_id`, `tour_uni`, `title`, `overview`, `start_date`, `start_time`, `end_date`, `end_time`, `owner`, `date_created`,`country`,`city`,`type`,`group_size`) VALUES 
                                                     (NULL, '$uni', '$title', '$overview', '$star_date', '$star_time', '$end_date', '$end_time', '$owner', current_timestamp(),'$country','$city','$type','$group_size')";


                    // add highlights
                    $text = trim($highlights);
                    $textAr = explode("\n", $text);
                    $textAr = array_filter($textAr, 'trim'); // remove any extra \r characters left behind

                    foreach ($textAr as $line) {
                        // processing here.
                        if(rowsOf("highlights","`event` = '$uni' AND `light` = '$line'",$pdo) < 1)
                        {
                            try {
                                $sql = $pdo->exec("INSERT INTO `highlights` (`id`, `event`, `light`) VALUES (NULL, '$uni', '$line')");

                            } catch (PDOException $e)
                            {
                                err("Could not add highlights \n");
                                echo $e->getMessage()."\n";
                            }
                        }

                    }

                    // add packages
                    $text = trim($packages);
                    $textAr = explode("\n", $text);
                    $textAr = array_filter($textAr, 'trim'); // remove any extra \r characters left behind

                    foreach ($textAr as $line) {
                        // explode each package
                        $pack_explode = explode(':',$line);
                        if(count($pack_explode) === 2)
                        {
                            $target = $pack_explode[0];
                            $value = $pack_explode[1];

                            // insert into packages
                            if(rowsOf('tour_packages',"`event` = '$uni' AND `target` = '$target'",$pdo) < 1)
                            {
                                $sql = "INSERT INTO `tour_packages` (`id`, `event`, `p_type`, `target`, `description`, `value`) VALUES 
                                                                (NULL, '$uni', 'c', '$target', 'cost', '$value')";
                                try {
                                    $pdo->exec($sql);
                                } catch (PDOException $e)
                                {
                                    err("Could not add $value  to packages \n");
                                    $e->getMessage();
                                }
                            }

                        }
                        // processing here.
//                            if(rowsOf("highlights","`event` = '$uni' AND `light` = '$line'",$pdo) < 1)
//                            {
//                                $sql = $pdo->exec("INSERT INTO `highlights` (`id`, `event`, `light`) VALUES (NULL, '$uni', '$line')");
//                            }

                    }

                    // add schedule
                    $text = trim($schedule);
                    $textAr = explode("\n", $text);
                    $textAr = array_filter($textAr, 'trim'); // remove any extra \r characters left behind
                    foreach ($textAr as $line) {

                        // explode schedule
                        $sch_explode = explode('^',$line);


                        if(count($sch_explode) === 5)
                        {
                            $date = $sch_explode[0];
                            $time = $sch_explode[1];
                            $title = $sch_explode[2];
                            $details = $sch_explode[4];
                            $location = $sch_explode[3];


                            // insert into schedules
                            $schedule_sql = "INSERT INTO `tour_scedule` (`event`, `date`, `time`, `location`, `title`, `description`) VALUES 
                                                                    ('$uni', '$date', '$time', '$location', '$title', '$details')";
                            if(rowsOf('tour_scedule',"`event` = '$uni' AND `location` = '$location' AND `description` = '$details'",$pdo) < 1)
                            {
                                try {
                                    $pdo->exec($schedule_sql);
                                } catch (PDOException $e)
                                {
                                    err("Could not add Schedule \n");
                                    echo $e->getMessage()."\n";
                                }
                            }
                        }

                    }


                    $pdo->exec($tour_sql);
                    set_session('view','all');
                    done();



                }
                else
                {
                    err("Event exist");
                }




            }

            elseif ($func === 'login')
            {
                $username = post('username');
                $password = post('password');

//                echo $password;
//                die();

                if(rowsOf('users',"`username` = '$username'",$pdo) > 0)
                {
                    // get user details
                    $user_details = fetchFunc('users',"`username` = '$username'",$pdo);
                    $token = $user_details['password'];

                    // compare token
                    if(password_verify($password,$token))
                    {
                        // login
                        set_session('user_id',$user_details['id']);
                        set_session('username',$username);
                        set_session('login',true);
                        set_session('module','dashboard');
                        set_session('view','home');
                        done();
                    }
                    else
                    {
                        err("Wrong password");
                    }


                }
                else
                {
                    err('user not found');
                    die();
                    exit();
                }
            }

            elseif ($func === 'logout')
            {
                // Unset all of the session variables
                $_SESSION = array();

                // Destroy the session.
                session_destroy();
            }

            elseif ($func === 'new_event') // latest event
            {
                $stage = get_session('event_stage');
                if($stage === 'core') // adding event core details ( first stage )
                {
                    print_r($_POST);

                    $encodedContent = base64_encode(post('details'));
                    // set session
                    set_session('title',post('title'));
                    set_session('country',post('country'));
                    set_session('city',post('city'));
                    set_session('type',post('type'));
                    set_session('group_size',post('group_size'));
                    set_session('star_date',post('star_date'));
                    set_session('end_date',post('end_date'));
                    set_session('star_time',post('star_time'));
                    set_session('end_time',post('end_time'));
                    set_session('details',base64_encode(post('details')));

                    set_session('event_stage','secondary');

                    done();

                }

            }

            elseif ($func === 'youtube_link') // add yourube link
            {
                $title = post('title');
                $link = post('link');
                $event = get_session('event');

                $q = "INSERT INTO `videos` (`title`,`link`,`event`) VALUES ('$title','$link','$event')";
                if(rowsOf('videos',"`link` = '$link'",$pdo) < 1)
                {
                    $pdo->exec($q);
                    done();
                }

            }
        }

    }