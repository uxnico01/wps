<?php
    require("./clsfunction.php");

    $nid = setID((int)getLastGradeID() + 1, 3);

    echo json_encode(array('nid' => array($nid)));
?>