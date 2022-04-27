<?php
    @!session_start();
    require 'db.php';

    function get_client_ip()
    {
        $ipaddress = '';
        if (isset($_SERVER['HTTP_CLIENT_IP'])) {
            $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
        } else if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else if (isset($_SERVER['HTTP_X_FORWARDED'])) {
            $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
        } else if (isset($_SERVER['HTTP_FORWARDED_FOR'])) {
            $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
        } else if (isset($_SERVER['HTTP_FORWARDED'])) {
            $ipaddress = $_SERVER['HTTP_FORWARDED'];
        } else if (isset($_SERVER['REMOTE_ADDR'])) {
            $ipaddress = $_SERVER['REMOTE_ADDR'];
        } else {
            $ipaddress = 'UNKNOWN';
        }

        return $ipaddress;
    }

    function get_location($ip)
    {
        $PublicIP = get_client_ip();
        $json     = file_get_contents("http://ipinfo.io/$ip/geo");
        return json_decode($json, true);
    }

    function generateRandomString($length = 10) {
        $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    function srcData($path)
    {
        // Read image path, convert to base64 encoding
        $imageData = base64_encode(file_get_contents($path));

        // Format the image SRC:  data:{mime};base64,{data};
        return 'data: '.mime_content_type($path).';base64,'.$imageData;
    }



    function checkPermission(array $permission)
    {
        $access_granted = 0;
        foreach ($permission as $key => $value)
        {
            if (isset($_SESSION[$value]) && $_SESSION[$value] === true)
            {
                $access_granted ++;
            }

            if ($access_granted > 0)
            {
                return true;
            }
            else
            {
                return false;
            }
        }
    }


    ##FUNCTION TO COUNT NUMBER OF ROWS
    function rowsOf($table , $condition , $connection)
    {
        if ($condition === 'none')
        {
            $rcSql = "SELECT * FROM $table";

        }
        else
        {
            $rcSql = "SELECT * FROM `$table` WHERE $condition";
        }
        $rcStmt = $connection->prepare($rcSql);
        $rcStmt->execute();
        return $rcStmt->rowCount();
    }

    ##date difference
    function dateDifference($date_1 , $date_2 , $differenceFormat = '%a' )
    {

        //////////////////////////////////////////////////////////////////////
        //PARA: Date Should In YYYY-MM-DD Format
        //RESULT FORMAT:
        // '%y Year %m Month %d Day %h Hours %i Minute %s Seconds'        =>  1 Year 3 Month 14 Day 11 Hours 49 Minute 36 Seconds
        // '%y Year %m Month %d Day'                                    =>  1 Year 3 Month 14 Days
        // '%m Month %d Day'                                            =>  3 Month 14 Day
        // '%d Day %h Hours'                                            =>  14 Day 11 Hours
        // '%d Day'                                                        =>  14 Days
        // '%h Hours %i Minute %s Seconds'                                =>  11 Hours 49 Minute 36 Seconds
        // '%i Minute %s Seconds'                                        =>  49 Minute 36 Seconds
        // '%h Hours                                                    =>  11 Hours
        // '%a Days                                                        =>  468 Days
        //////////////////////////////////////////////////////////////////////

        $datetime1 = date_create($date_1);
        $datetime2 = date_create($date_2);

        $interval = date_diff($datetime1, $datetime2);

        return $interval->format($differenceFormat);

    }

    ## time difference
    function timeDifference($start , $end)
    {
        $time1 = strtotime($start);
        $time2 = strtotime($end);
        return round(abs($time2 - $time1) / 3600,2);
    }

    ##fetch from table
    function fetchFunc($table , $condition, $connection)
    {
        if($condition === "none")
        {
            $sql = "SELECT * FROM $table LIMIT 1";
        }
        else
        {
            $sql = "SELECT * FROM $table WHERE $condition LIMIT 1";
        }
        $stmt = $connection->prepare($sql);
        $stmt->execute();
        return $result = $stmt->fetch(PDO::FETCH_ASSOC);
    }

    ##execute


    ##column sum
    function getSumOfColumn($table , $column , $condition  , $connection , $currency = 0)
    {
        if ($condition != 'none')
        {
            $sql = "select SUM($column) from $table WHERE $condition";
        }
        else
        {
            $sql = "SELECT SUM($column) from `$table`";
        }
        $stmt  = $connection->prepare($sql);
        $stmt->execute();
        $stmt_res = $stmt->fetch(PDO::FETCH_ASSOC);
        $result = $stmt_res['SUM('.$column.')'];
        if ($result === NULL)
        {
            $x = number_format(0.00);
        }
        else
        {
            //explode result
            $x = number_format($result,2);

        }

        if ($currency === 0)
        {
            return $x;
        }
        else
        {
            return $_SESSION['currency'].' '.$x;
        }

    }

    ##CHECK IF RECORD EXIST
    function ifRecordExist($table , $column , $record , $connection)
    {
        $ifRecordExistsql = "SELECT * FROM `$table` WHERE `$column` = $record";
        $ifRecordExiststmt = $connection->prepare($ifRecordExistsql);
        $ifRecordExiststmt->execute();

        if ($ifRecordExiststmt->rowCount() > 0)
        {
            return true;
        }
        else
        {
            return false;
        }

    }



    ##SET SESSION INFO
    function info($info)
    {
        $_SESSION['info'] = $info;
    }

    ##insert into database
    function insertIntoDatabase($table , $culumns , $values , $connection)
    {
        $sql = "INSERT INTO `$table` ($culumns) VALUES ($values)";
        $stmt = $connection->prepare($sql);
        if ($stmt->execute())
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    ##update_record
    function updateRecord ($table , $set , $condition , $conn)
    {
        if ($condition === 'none')
        {
            $updateSql = "UPDATE `$table` SET $set";
        }
        else
        {
            $updateSql = "UPDATE `$table` SET $set WHERE $condition";
        }

        $updateStmt = $conn->prepare($updateSql);
        if($updateStmt->execute())
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    ##get next function
    function nextPrevious($table , $condition , $conn)
    {
        $sql = "SELECT * FROM `$table` WHERE $condition LIMIT 1";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        if ($stmt->rowCount() > 0)
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    ##is condition true
    function isConditionTrue ($table , $column , $condition , $tcolumn , $connection)
    {
        $sql = "SELECT `$column` FROM $table WHERE $condition";
        $stmt = $connection->prepare($sql);
        $stmt->execute();
        $stmt_result = $stmt->fetch(PDO::FETCH_ASSOC);
        $result = $stmt_result[$tcolumn];
        return $result;
    }

    ## delete row
    function deleteRow($table , $condition , $connection)
    {
        $sql = "DELETE FROM $table WHERE $condition";
        $stmt = $connection->prepare($sql);
        if ($stmt->execute())
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    ##mavigate url
    function gb()
    {
        header("Location:".$_SERVER['HTTP_REFERER']);
    }
    function redirect($url)
    {
        header("Location:".$url);
    }

    ##check user task
    function task($username,$conn)
    {
        try
        {
            $sql = "SELECT * FROM `user_task` WHERE `user` = ? AND `task_status` = '1' LIMIT 1";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$username]);
            return $task_res = $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $error)
        {
            echo $error->getMessage();
        }
    }

    ##password validate
    function validateKey($user_id , $key , $connection)
    {
        $sql = "SELECT `password` FROM `users` WHERE `id` = $user_id";
        $stmt = $connection->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $hashed_password = $result['password'];
        if (password_verify($key, $hashed_password))
        {
            return true;
        }
        else
        {
            return false;
        }
    }


    function done($message="Complete")
    {
        echo "done%%$message";
    }

    function reload()
    {
        echo '<script>location.reload()</script>';
    }

    function err($message = 'We are having trouble processing')
    {
        echo "err%%$message";
    }

    ## go back
    function back()
    {
        header("Location:".$_SERVER['HTTP_REFERER']);
    }

    function error($message)
    {
        $_SESSION['error'] = $message;
    }

    function alert($message)
    {
        echo "<script>alert('".$message."')</script>";
    }


    ##logout
    function logout()
    {
        // Unset all of the session variables
        $_SESSION = array();

        // Destroy the session.
        session_destroy();


        // Redirect to login page
        header("location: ../../");
        exit;
    }

    # get file type
    function file_type($ext)
    {
        $file_ext = strtolower($ext);
        //if file is document
        if  (
            $file_ext === 'doc' || $file_ext === 'docx' || $file_ext === 'odt' ||
            $file_ext === 'pdf' || $file_ext === 'rtf' || $file_ext === 'tex' ||
            $file_ext === 'txt' || $file_ext === 'wpd' || $file_ext === 'ods' ||
            $file_ext === 'xls' || $file_ext === 'xlsm' || $file_ext === 'xlsx' ||
            $file_ext === 'c' || $file_ext === 'csv' || $file_ext === 'pl' ||
            $file_ext === 'class' || $file_ext === 'cpp' || $file_ext === 'cs' ||
            $file_ext === 'h' || $file_ext === 'java' || $file_ext === 'php' ||
            $file_ext === 'css' || $file_ext === 'js' || $file_ext === 'py' ||
            $file_ext === 'swift' || $file_ext === 'sh' || $file_ext === 'vb' ||
            $file_ext === 'key' || $file_ext === 'odp' || $file_ext === 'pps' ||
            $file_ext === 'ppt' || $file_ext === 'pptx' || $file_ext === 'xhtml' ||
            $file_ext === 'rss' || $file_ext === 'part' || $file_ext === 'jsp' ||
            $file_ext === 'cer' || $file_ext === 'cfm' || $file_ext === 'htm' ||
            $file_ext === 'dat' || $file_ext === 'db' || $file_ext === 'dbf' ||
            $file_ext === 'log' || $file_ext === 'mdb' || $file_ext === 'sav' ||
            $file_ext === 'sql' || $file_ext === 'xml'
        )
        {

            $dir = 'Documents';

        }

        //If File is Audio
        elseif (
            $file_ext === 'aif' || $file_ext === 'cda' || $file_ext === 'mid' ||
            $file_ext === 'midi' || $file_ext === 'mpa' || $file_ext === 'mp3' ||
            $file_ext === 'ogg' || $file_ext === 'wav' || $file_ext === 'wma' ||
            $file_ext === 'wpl'|| $file_ext === 'MP3'
        ) {
            $dir = 'Music';
        }

        //if file is compressed
        elseif (
            $file_ext === '7z' || $file_ext === 'arj' || $file_ext === 'pkg' ||
            $file_ext === 'rar' || $file_ext === 'zip' || $file_ext === 'tar' ||
            $file_ext === 'tar.gz' || $file_ext === 'gz' || $file_ext === 'iso'
        ) {
            $dir = 'Compressed';
        }

        //if file is Picture
        elseif (
            $file_ext === 'png' || $file_ext === 'ai' || $file_ext === 'gif' ||
            $file_ext === 'jpg' || $file_ext === 'jpeg' || $file_ext === 'ico' ||
            $file_ext === 'svg' || $file_ext === 'psd' || $file_ext === 'ps' ||
            $file_ext === 'tif' || $file_ext === 'tiff'
        )
        {
            $dir = 'Pictures';
        }

        //if file is an app
        elseif ($file_ext === 'exe' || $file_ext === 'rmp' || $file_ext === 'msi')
        {
            $dir = 'Applications';
        }

        // if file is video
        elseif (
            $file_ext === 'webm' || $file_ext === 'mpg' || $file_ext === 'mp2' ||
            $file_ext === 'mpeg' || $file_ext === 'mpv' || $file_ext === 'ogg' ||
            $file_ext === 'mp4' || $file_ext === 'm4p' || $file_ext === 'mv4' ||
            $file_ext === 'avi' || $file_ext === 'wmv' || $file_ext === 'mov' ||
            $file_ext === 'qt' || $file_ext === 'flv' || $file_ext === 'sqf' || $file_ext === 'avchd'
        )
        {
            $dir = 'Video';
        }

        else
        {
            $dir = 'Unknown';
        }
        return $dir;
    }

    ##file size
    function file_size($bytes)
    {



        if ($bytes >= 1073741824)
        {
            $bytes = number_format($bytes / 1073741824, 2) . ' GB';
        }
        elseif ($bytes >= 1048576)
        {
            $bytes = number_format($bytes / 1048576, 2) . ' MB';
        }
        elseif ($bytes >= 1024)
        {
            $bytes = number_format($bytes / 1024, 2) . ' KB';
        }
        elseif ($bytes > 1)
        {
            $bytes = $bytes . ' bytes';
        }
        elseif ($bytes == 1)
        {
            $bytes = $bytes . ' byte';
        }
        else
        {
            $bytes = '0 bytes';
        }

        return $bytes;
    }

    // get form post data
    function post($post_var)
    {
        if(isset($_POST[(string)$post_var]))
        {
            return htmlentities($_POST[(string)$post_var]);
        }

        return null;
    }

    // get form post data
    function get($get_var)
    {
        if(isset($_GET[(string)$get_var]))
        {
            return htmlentities($_GET[(string)$get_var]);
        }

        return null;
    }

    // set session
    function set_session($var, $val)
    {
        $_SESSION["$var"] = $val;
        if(isset($_SESSION["$var"]))
        {
            return true;
        }

        return false;
    }
    // get session
    function get_session($var)
    {
        if(isset($_SESSION[(string)$var]))
        {
            return $_SESSION[(string)$var];
        }
        return false;
    }

    // get post file
    function post_file($var)
    {
        if(isset($_FILES[$var]))
        {
            return $_FILES[$var];
        }
        else
        {
            return false;
        }
    }

    // unset sessions
    function unset_session($data)
    {
        $d_exp = explode(',',$data);
        foreach ($d_exp as $item=>$value)
        {
            if(isset($_SESSION[$value]))
            {
                unset($_SESSION[$value]);
            }
        }
    }

    function compress_image($source_url, $destination_url, $quality)
    {
        $info = getimagesize($source_url);
        if ($info['mime'] == 'image/jpeg') $image = imagecreatefromjpeg($source_url);
        elseif ($info['mime'] == 'image/gif') $image = imagecreatefromgif($source_url);
        elseif ($info['mime'] == 'image/png') $image = imagecreatefrompng($source_url);
        if(imagejpeg($image, $destination_url, $quality))
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    function thumbnail($img,$width,$height,$destination)
    {
        $image = $img;
        $filename = $destination;

        $thumb_width = $width;
        $thumb_height = $height;

        $width = imagesx($image);
        $height = imagesy($image);

        $original_aspect = $width / $height;
        $thumb_aspect = $thumb_width / $thumb_height;

        if ( $original_aspect >= $thumb_aspect )
        {
            // If image is wider than thumbnail (in aspect ratio sense)
            $new_height = $thumb_height;
            $new_width = $width / ($height / $thumb_height);
        }
        else
        {
            // If the thumbnail is wider than the image
            $new_width = $thumb_width;
            $new_height = $height / ($width / $thumb_width);
        }

        $thumb = imagecreatetruecolor( $thumb_width, $thumb_height );

// Resize and crop
        imagecopyresampled($thumb,
            $image,
            0 - ($new_width - $thumb_width) / 2, // Center the image horizontally
            0 - ($new_height - $thumb_height) / 2, // Center the image vertically
            0, 0,
            $new_width, $new_height,
            $width, $height);
        imagejpeg($thumb, $filename, 30);

    }

