<?php 

   include 'Conexion.php';

   $Nombres = $_POST['Nombres'];
   $Apellidos = $_POST['Apellidos'];
   $Correo_electronico = $_POST['Correo_electronico'];
   $Contrasena = $_POST['Contrasena'];
   $rol = $_POST['rol'];

   $query = "INSERT INTO crear_cuenta(Nombres, Apellidos, Correo_electronico, Contrasena, rol) 
             VALUES ('$Nombres', '$Apellidos', '$Correo_electronico', '$Contrasena', '$rol')";

             // No se repitan los datos a la base de datos
             $verificar_Correo_electronico = mysqli_query($Conexion, "SELECT * FROM crear_cuenta WHERE Correo_electronico='$Correo_electronico'");

             if(mysqli_num_rows($verificar_Correo_electronico) > 0){
            echo '
            <script>
                alert("Este correo ya estaregistrado, intenta con otro diferente");
                window.location = "../alertaurbana/Crearcuenta.html";
            </script>
            ';
    exit(); 
            }
             
   $ejecutar = mysqli_query($Conexion, $query);
   
   if($ejecutar){
    echo ' 
    <script>
    alert("Usuario Registrado correctamente");
    window.location = "../alertaurbana/Acceder.html";
    </script>
    ';
   }else {
    echo ' 
    <script>
    alert("Intentelo de nuevo, usuario no almacenado");
    window.location = "../Acceder.html";
    </script>
   ';
}

mysqli_close($conexion);
   ?>