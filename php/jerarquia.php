<?php
    require_once 'conexion.php';
    error_reporting(0);
    $ID = $_GET['ID'];
    $jelarquia = array();

    $DEFAULTJSON[] = [
        "ID_padre" => "NO DATA",
        "ID_hijo" => "NO DATA"
    ];
    
    $jelarquia_PADRE = "SELECT * FROM jelarquia WHERE ID_padre = $ID;";
    $jelarquia_HIJO = "SELECT * FROM jelarquia WHERE ID_hijo = $ID;";

    $resultado_p = mysqli_query($conexion, $jelarquia_PADRE);
    $filasp = mysqli_num_rows($resultado_p);

    while($row = mysqli_fetch_object($resultado_p))
    {
        $jelarquia[] = $row;
    }

    $resultado_h = mysqli_query($conexion, $jelarquia_HIJO);
    $filash = mysqli_num_rows($resultado_h);

    while($row = mysqli_fetch_object($resultado_h))
    {
        $jelarquia[] = $row;
    }

    if($filasp OR $filash)
        echo json_encode($jelarquia);
    else
        echo json_encode($jelarquia[] = $DEFAULTJSON);
?>