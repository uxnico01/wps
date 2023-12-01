<?php
    require("./clsfunction.php");

    $db = openDB();
    $set = getSett();

    //UPDATE TBHDLL PENERIMAAN
    $sql = "UPDATE prterima2 P2
            SET TBHDLL = (SELECT TBHDLL FROM prterima WHERE ID = P2.ID)/(SELECT COUNT(prterima2) WHERE ID = P2.ID)";

    mysqli_query($db, $sql) or die("Error F(x) GHRGA - 1 : ".mysqli_error($db));

    //INPUT DATA HARGA CUTTING PRODUK
    $sql = "SELECT DISTINCT ID, (SELECT SUM(T2.WEIGHT*T2.PRICE+T2.TBHDLL) FROM prterima2 T2 INNER JOIN prcut2 C2 ON T2.ID = C2.IDTERIMA && T2.IDPRODUK = C2.IDPRODUK && T2.URUT = C2.URUTTRM WHERE C2.ID = C3.ID) FROM prcut3 C3 ORDER BY ID";

    $result = mysqli_query($db, $sql) or die("Error F(x) GHRGA - 2 : ".mysqli_error($db));

    while($row = mysqli_fetch_array($result, MYSQLI_NUM)){
        
    }

    //INPUT DATA HARGA CUTTING NON PRODUK

    //INPUT DATA HARGA VACUUM DARI CUTTING
    $sql = "SELECT ";


    closeDB($db);
?>