<?php
    require_once 'conexion.php';

    error_reporting(0);

    $data = json_decode(file_get_contents('php://input'), true);

    $ID = $data["ID"];
    $Nombre = $data["Nombre"];
    $Pais = $data["Pais"];
    $Region = $data["Region"];

    $datos = array();

    $DEFAULTJSON = array();

    $DEFAULTJSON[] = [
        "ID" => "NO DATA",
        "nombre" => "NO DATA",
        "Industria" => "NO DATA",
        "Pais" => "NO DATA",
        "Ingresos_local" => "NO DATA",
        "Ingreso_USD" => "NO DATA",
        "Region" => "NO DATA",
        "No_empleados" => "NO DATA",
        "Fecha_actualizacion" => "NO DATA",
        "PaginaWeb" => "NO DATA",
        "Estado" => "NO DATA"
    ];
    
    $consulta = "SELECT * FROM Empresas";

    if($ID or $Nombre or $Pais or $Region)
    {
        $consulta .= " WHERE";

        if($ID)
            $consulta .= " ID = $ID";
        
        if($ID and $Nombre)
            $consulta .= " AND nombre LIKE '%$Nombre%'";
        else if($Nombre)
            $consulta .= " nombre LIKE '%$Nombre%'";
        
        if(($ID or $Nombre) and $Pais)
            $consulta .= " AND Pais LIKE '%$Pais%'";
        else if($Pais)
            $consulta .= " Pais LIKE '%$Pais%'";
        
        if(($ID or $Nombre or $Pais) and $Region)
            $consulta .= " AND Region LIKE '%$Region%'";
        else if($Region)
            $consulta .= " Region LIKE '%$Region%'";
    }
    $consulta .= ";";

    $resultado = mysqli_query($conexion, $consulta);
    $filas = mysqli_num_rows($resultado);

    while($row = mysqli_fetch_object($resultado))
    {
        $datos[] = $row;
    }
    if($filas)
        echo json_encode($datos);
    else
        echo json_encode($datos[] = $DEFAULTJSON);
    
//________________________________________________________________
    
    $Creartabla = "CREATE TABLE Jelarquia (
        ID_padre integer(100),
        ID_hijo integer(100)
    );";

    //_____________________________________Paises
    $Paises = array(
        "Mexico",
        "USA",
        "CANADA",
        "Brasil",
        "COLOMBIA",
        "ARGENTINA"
    );

    $pais = "CREATE TABLE Paises(
        Pais varchar (255)
    );";
    //_____________________________________endPaises

    //_____________________________________________________________________tabla principal
    $paginaweb = "NotAvaliable";
    
    $tabla_principal = "CREATE TABLE Empresas (
        ID integer(100) PRIMARY KEY NOT NULL AUTO_INCREMENT,
        nombre VARCHAR (255),
        Industria varchar (255),
        Pais varchar (255),
        Ingresos_local float,
        Ingreso_USD float,
        Region VARCHAR (255),
        No_empleados INTEGER (255),
        Fecha_actualizacion date,
        PaginaWeb varchar (255),
        Estado  int (1)
    );";
//_____________________________________________________________________endtabla principal
  
//_______________________________________________sheep

    $relationshep = "CREATE TABLE Relationship (
        ID_Empresa integer(100),
    	ID_ship varchar(255),
    	Rol varchar(255)
    );";
    $shep = "CREATE TABLE ship (
        ID_ship varchar(255) PRIMARY KEY NOT NULL,
        Nombre varchar (255),
        pais varchar (255)
    );";

    $ships = array(
        ["E1975", "Martnez", $Paises[0]], 
        ["E1976", "Carrasco", $Paises[0]],
        ["E1168", "Asonte", $Paises[0]],
        ["E1169", "Salvador",  $Paises[0]],

        ["E1970", "Caceres", $Paises[1]],
        ["E1971", "Yauri",  $Paises[1]],
        ["E1972", "Hinojosa",  $Paises[1]],
        ["E1973", "Esteban",  $Paises[1]],

        ["E1075", "Moya",  $Paises[2]],
        ["E7966", "Aranda",  $Paises[2]],
        ["E1816", "Cordova",  $Paises[2]],
        ["E1814", "Luna",  $Paises[2]],

        ["E1968", "Patron",  $Paises[3]],
        ["E1675", "Miller",  $Paises[3]],
        ["E1677", "Levine",  $Paises[3]],
        ["E1793", "Romero",  $Paises[3]],

        ["E1792", "Barton",  $Paises[4]],
        ["E1794", "Quispe",  $Paises[4]],
        ["E1426", "Laura",  $Paises[4]],
        ["E1969", "CarPio",  $Paises[4]],

        ["E1167", "Borja",  $Paises[5]],
        ["E1931", "Berrios",  $Paises[5]],
        ["E1967", "Araujo",  $Paises[5]],
        ["E1968", "Rojas",  $Paises[5]],
    );
//_______________________________________________endsheep
#________________________________________________

    $querys = "INSERT INTO empresas VALUES(NULL, 'NVIDIA Corporate', 'hardware', 'USA', 7192000000, 7192000000, 'California', 22473,'2023-06-015', 'www.nvidia.com', 1);
    INSERT INTO empresas VALUES(NULL, 'NVIDIA', 'hardware', 'Canadá', 0, 0, 'Ontario', 0,'2023-06-015', 'www.nvidia.com', 1);
    INSERT INTO empresas VALUES(NULL, 'NVIDIA', 'hardware', 'USA', 0, 0, 'Alabama', 0,'2023-06-015', 'www.nvidia.com', 1);
    INSERT INTO empresas VALUES(NULL, 'NVIDIA', 'hardware', 'USA', 0, 0, 'California', 0,'2023-06-015', 'www.nvidia.com', 1);
    INSERT INTO empresas VALUES(NULL, 'NVIDIA', 'hardware', 'USA', 0, 0, 'Colorado', 0,'2023-06-015', 'www.nvidia.com', 1);
    INSERT INTO empresas VALUES(NULL, 'NVIDIA', 'hardware', 'USA', 0, 0, 'Illinois', 0,'2023-06-015', 'www.nvidia.com', 1);
    INSERT INTO empresas VALUES(NULL, 'NVIDIA', 'hardware', 'USA', 0, 0, 'Massachusetts', 0,'2023-06-015', 'www.nvidia.com', 1);
    INSERT INTO empresas VALUES(NULL, 'NVIDIA', 'hardware', 'USA', 0, 0, 'Missouri', 0,'2023-06-015', 'www.nvidia.com', 1);
    INSERT INTO empresas VALUES(NULL, 'NVIDIA', 'hardware', 'USA', 0, 0, 'New Jersey', 0,'2023-06-015', 'www.nvidia.com', 1);
    INSERT INTO empresas VALUES(NULL, 'NVIDIA', 'hardware', 'USA', 0, 0, 'New York', 0,'2023-06-015', 'www.nvidia.com', 1);
    INSERT INTO empresas VALUES(NULL, 'NVIDIA', 'hardware', 'USA', 0, 0, 'North Carolina', 0,'2023-06-015', 'www.nvidia.com', 1);
    INSERT INTO empresas VALUES(NULL, 'NVIDIA', 'hardware', 'USA', 0, 0, 'Oregon', 0,'2023-06-015', 'www.nvidia.com', 1);
    INSERT INTO empresas VALUES(NULL, 'NVIDIA', 'hardware', 'USA', 0, 0, 'Pennsylvania', 0,'2023-06-015', 'www.nvidia.com', 1);
    INSERT INTO empresas VALUES(NULL, 'NVIDIA', 'hardware', 'USA', 0, 0, 'Texas', 0,'2023-06-015', 'www.nvidia.com', 1);
    INSERT INTO empresas VALUES(NULL, 'NVIDIA', 'hardware', 'USA', 0, 0, 'Utah', 0,'2023-06-015', 'www.nvidia.com', 1);
    INSERT INTO empresas VALUES(NULL, 'NVIDIA', 'hardware', 'USA', 0, 0, 'Virginia', 0,'2023-06-015', 'www.nvidia.com', 1);
    INSERT INTO empresas VALUES(NULL, 'NVIDIA', 'hardware', 'USA', 0, 0, 'Washington', 0,'2023-06-015', 'www.nvidia.com', 1);
    INSERT INTO jelarquia VALUES (285, 286), (285, 287), (285, 288), (285, 289), (285, 290), (285, 291), (285, 292), (285, 293), (285, 294), (285, 295), (285, 296), (285, 297), (285, 298), (285, 299), (285, 300), (285, 301);
    INSERT INTO relationship VALUES (285, 'E1970', 'Propietario'), (285, 'E1971', 'Sub-Propietario'),(285, 'E1970', 'Cloud manager'),
							 (286, 'E1970', 'Propietario'),
                             (287, 'E1970', 'Propietario'), (287, 'E1971', 'Sub-Propietario'),(287, 'E1970', 'Cloud manager'),
                             (288, 'E1970', 'Propietario'), (288, 'E1971', 'Sub-Propietario'),(288, 'E1970', 'Cloud manager'),
                             (289, 'E1970', 'Propietario'), (289, 'E1971', 'Sub-Propietario'),(289, 'E1970', 'Cloud manager'),
                             (290, 'E1970', 'Propietario'), (290, 'E1971', 'Sub-Propietario'),(290, 'E1970', 'Cloud manager'),
                             (291, 'E1970', 'Propietario'), (291, 'E1971', 'Sub-Propietario'),(291, 'E1970', 'Cloud manager'),
                             (292, 'E1970', 'Propietario'), (289, 'E1971', 'Sub-Propietario'),(282, 'E1970', 'Cloud manager'),
                             (293, 'E1970', 'Propietario'), (293, 'E1971', 'Sub-Propietario'),(293, 'E1970', 'Cloud manager'),
                             (294, 'E1970', 'Propietario'), (294, 'E1971', 'Sub-Propietario'),(294, 'E1970', 'Cloud manager'),
                             (295, 'E1970', 'Propietario'), (295, 'E1971', 'Sub-Propietario'),(295, 'E1970', 'Cloud manager'),
                             (296, 'E1970', 'Propietario'), (296, 'E1971', 'Sub-Propietario'),(296, 'E1970', 'Cloud manager'),
                             (297, 'E1970', 'Propietario'), (297, 'E1971', 'Sub-Propietario'),(297, 'E1970', 'Cloud manager'),
                             (298, 'E1970', 'Propietario'), (298, 'E1971', 'Sub-Propietario'),(298, 'E1970', 'Cloud manager'),
                             (299, 'E1970', 'Propietario'), (299, 'E1971', 'Sub-Propietario'),(299, 'E1970', 'Cloud manager'),
                             (300, 'E1970', 'Propietario'), (300, 'E1971', 'Sub-Propietario'),(300, 'E1970', 'Cloud manager'),
                             (301, 'E1970', 'Propietario'), (301, 'E1971', 'Sub-Propietario'),(301, 'E1970', 'Cloud manager');
                             UPDATE empresas SET nombre ='NVIDIA Corporate inc.', Region = 'California' WHERE ID = 285;
    ";
?>