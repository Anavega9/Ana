<?php
include "Conexion.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $zona = $_POST['zona'];
    $tipo_incidente = $_POST['tipo_incidente'];
    $descripcion = $_POST['descripcion'];
    $fecha = $_POST['fecha'];
    $anonimo = isset($_POST['anonimo']) ? 1 : 0;
    $imagen = $_FILES['imagen']['name'];

    // Subir imagen
    if ($imagen) {
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($imagen);
        move_uploaded_file($_FILES['imagen']['tmp_name'], $target_file);
    }


    // Insertar reporte
    $sql = "INSERT INTO reportes (usuarioID, zona, tipo_incidente, descripcion, fecha, anonimo, imagen)
            VALUES (1, '$zona', '$tipo_incidente', '$descripcion', '$fecha', $anonimo, '$target_file')"; // Supongamos que el usuario_id es 1.

    if ($Conexion->query($sql) === TRUE) {
        echo '<script>
        alert ("Reporte creado exitosamente.");
        window.location = "../alertaurbana/Paginaprincipal.html";
        </script>';
    } else {
        echo "Error: " . $sql . "<br>" . $Conexion->error;
    }

    // Actualizar el mapa de calor
    /*$sql_mapa = "UPDATE mapa_calor SET reportes_count = reportes_count + 1 WHERE zona = '$zona'";
    $Conexion->query($sql_mapa);

    $Conexion->close();*/
}
?>