<?php
    require("./clsfunction.php");

    $db = openDB();

    $id = trim(mysqli_real_escape_string($db, $_POST["id"]));
    $type = trim(mysqli_real_escape_string($db, $_POST["type"]));

    $kode = "x";

    if(strcasecmp($type,"1") == 0)
        setTrmVerif($id, getTrmID($id)[11], $kode);
    else if(strcasecmp($type,"2") == 0)
        setCutVerif($id, getCutID($id)[6], $kode);
    else if(strcasecmp($type,"3") == 0)
        setVacVerif($id, getVacID($id)[11], $kode);
    else if(strcasecmp($type,"4") == 0)
        setSawVerif($id, getSawID($id)[9], $kode);
    else if(strcasecmp($type,"5") == 0)
        setTTVerif($id, getTTID($id)[12], $kode);
    else if(strcasecmp($type,"6") == 0)
        setPjmVerif($id, getPjmID($id)[11], $kode);
    else if(strcasecmp($type,"7") == 0)
        setKirimVerif($id, getKirimID($id)[9], $kode);
    else if(strcasecmp($type,"8") == 0)
        setMPVerif($id, getMPID($id)[2], $kode);
    else if(strcasecmp($type,"9") == 0)
        setWdVerif($id, getWdID($id)[8], $kode);

    closeDB($db);

    echo json_encode(array('err' => array(1)));
?>