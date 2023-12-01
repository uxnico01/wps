<?php
    require("./clsfunction.php");

    $nid = setID((int)getLastSKateID() + 1, 3);

    echo json_encode(array('nid' => array($nid)));
?>