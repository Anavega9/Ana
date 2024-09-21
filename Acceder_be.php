<?php
// Iniciar la sesión
session_start();

// Incluir la conexión a la base de datos
include 'Conexion.php'; // Asegúrate de que este archivo tenga la conexión a la base de datos

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los datos del formulario
    $Correo_electronico = $_POST['Correo_electronico'];
    $Contrasena = $_POST['Contrasena'];

    // Preparar la consulta para seleccionar el usuario
    $sql = "SELECT * FROM crear_cuenta WHERE Correo_electronico = ?";

    if ($stmt = $Conexion->prepare($sql)) {
        // Vincular los parámetros (correo electrónico)
        $stmt->bind_param("s", $Correo_electronico);

        // Ejecutar la consulta
        $stmt->execute();

        // Obtener el resultado
        $result = $stmt->get_result();

        // Verificar si se encontró el usuario
        if ($result->num_rows == 1) {
            // Obtener los datos del usuario
            $usuario = $result->fetch_assoc();

            // Verificar la contraseña
            if (password_verify($Contrasena, $usuario['Contrasena'])) {
                // Guardar datos en la sesión
                $_SESSION['usuario_id'] = $usuario['Id'];
                $_SESSION['Nombres'] = $usuario['Nombres'];
                $_SESSION['rol'] = $usuario['rol'];

                // Redirigir según el rol
                switch ($usuario['rol']) {
                    case 'admin':
                        header("Location: admin_dashboard.php");
                        break;
                    case 'desarrollador':
                        header("Location: desarrollador_dashboard.php");
                        break;
                    case 'usuario':
                        header("Location: usuario_dashboard.php");
                        break;
                    default:
                        // Si no hay un rol válido
                        echo "Error: Rol no válido.";
                        break;
                }

                exit();
            } else {
                echo "Contraseña incorrecta.";
            }
        } else {
            echo "No se encontró una cuenta con ese correo electrónico.";
        }

        // Cerrar el statement
        $stmt->close();
    } else {
        echo "Error en la consulta a la base de datos.";
    }

    // Cerrar la conexión a la base de datos
    $Conexion->close();
}
?>
