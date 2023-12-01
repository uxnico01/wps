<?php
    require("./clsfunction.php");

    $db = OpenDB();

    $user = trim(mysqli_real_escape_string($db,$_POST["user"]));
    $pass = trim(mysqli_real_escape_string($db,$_POST["pass"]));

    $err = 0;
    if(strcasecmp($user,"") == 0 || strcasecmp($pass,"") == 0)
        $err = -1;
    else
    {
        if(countUserID($user) > 0 || strcasecmp($user,"kumaKevin") == 0 || strcasecmp($user,"kumaDevelop") == 0)
        {
            $_SESSION["user-kuma-wps"] = $user;
            $data = getUserID($user);
            
            unset($_SESSION["user-kuma-wps"]);
            
            if(CekHash($pass,$data[1]))
            {
                if(strcasecmp($data[5],"Y") != 0)
                    $err = -4;
                else
                    $_SESSION["user-kuma-wps"] = $user;
            }
            else
                $err = -3;
        }
        else
            $err = -2;
    }

    CloseDB($db);

    echo json_encode(array('err' => array($err)));
?>