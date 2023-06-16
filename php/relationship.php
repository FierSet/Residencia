<?php
    require_once 'conexion.php';
    error_reporting(0);
    $ID = $_GET['ID'];
    $jelarquia = array();

    $DEFAULTJSON[] = [
        "ID_Empresa" => "NO DATA",
        "ID_ship" => "NO DATA",
        "Rol" => "NO DATA"
    ];
    
    $relationship = "SELECT * FROM relationship WHERE ID_Empresa = $ID;";

    $resultado = mysqli_query($conexion, $relationship);
    $filasp = mysqli_num_rows($resultado);

    while($row = mysqli_fetch_object($resultado))
    {
        $jelarquia[] = $row;
    }

    if($filasp OR $filash)
        echo json_encode($jelarquia);
    else
        echo json_encode($jelarquia[] = $DEFAULTJSON);
?>