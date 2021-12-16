<?php
require 'Database/conection.php';
$message = '';

if (!empty($_POST['email']) && !empty($_POST['contrasena']) && !empty($_POST['nombre']) && !empty($_POST['apellido'])) {
    $sql = 'INSERT INTO usuarios (email, nombre, apellido, contrasena) VALUES (:email, :nombre, :apellido, :contrasena)';
    $stmt = $conection->prepare($sql);
    $stmt->bindParam(':email', $_POST['email']);
    $stmt->bindParam(':nombre', $_POST['nombre']);
    $stmt->bindParam(':apellido', $_POST['apellido']);
    $contrasena = password_hash($_POST['contrasena'], PASSWORD_BCRYPT);
    $stmt->bindParam(':contrasena', $contrasena);

    if ($stmt->execute()) {
        $message = 'Usuario creado correctamente';
    } else {
        $message = 'Ha ocurrido un error';
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css" />
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">




    <title>Registro</title>
</head>

<body>
    <nav>
        <div class="nav-items">
            <!-- Izquierda -->
            <a href="home.php"><i class="fas fa-home"></i>Home</a>
        </div>
        <div class="nav-items">
            <!-- Derecha -->
            <a onclick="iniciarSesion()" id="iniciarsesion" class="button"><i class="fas fa-sign-in-alt"></i>Iniciar Sesion</a>
            <a href="signup.php" id="registro" class="button"><i class="fas fa-user-check"></i>Registrate</a>
        </div>
    </nav>


    <!-- Pop Up -->
    <div class="pop-up-container" id="pop-up">

        <a href="#" onclick="cerrar()"> <i class="fas fa-times"></i></a>

        <div class="form-pop-up">
            <h2>Log In</h2>
            <form action="home.php" method="post">
                <div class="form-pop-up-input">
                    <input class="input" type="text" name="emailLogIn" placeholder="ejemplo@correo.com" required>
                </div>
                <div class="form-pop-up-input">
                    <input class="input" type="password" name="passwordLogIn" placeholder="Contrasena" required>
                </div>
                <div class="form-pop-up-input">
                <button class="button reg"><i class="fas fa-sign-in-alt"></i>Iniciar Sesion </button>
                </div>
            </form>
        </div>
    </div>

    <div class="pop-up" onclick="cerrar()" id="pop-up2"></div>



    <!-- Formulario de Registro -->
    <div class="registro">
        <h3>Ingresa tus datos para poder registrarte</h3>
        <div class="form-registro">
            <form action="signup.php" method="POST">
                <div class="cont">
                    <label for="">Direccion de correo electronico</label>
                    <input type="text" name="email" class="input" placeholder="ejemplo@correo.com" style="margin: 2px;" required>
                    <small class="form-text text-muted">No lo usaremos para acosarte ;)</small>

                </div>

                <div class="cont"> <input style="width: 49.5%;" type="text" name="nombre" class="input" placeholder="Nombre" required>
                    <input style="width: 49.5%;" type="text" name="apellido" class="input" placeholder="Apellido" required>
                </div>
                <div class="cont">
                    <input style="width: 49.5%;"  type="password" name="contrasena" class="input" placeholder="Contrasena" required>
                    <input style="width: 49.5%;"  type="password" class="input" placeholder="Confirmar contrasena" required>
                </div>

                <button class="button reg"><i class="fas fa-user-check"></i>Registrate</button>
            </form>
            <label for="">Ya esta registrado?</label>
            <a onclick="iniciarSesion()" class="button"><i class="fas fa-sign-in-alt"></i>Iniciar Sesion</a>
        </div>
    </div>


    <?php if (!empty($message)) : ?>
        <script>
            console.log(<?php echo 'mensaje: ' . $message ?>);
        </script>
    <?php endif; ?>

    <!-- Scripts -->
    <script src="main.js"></script>
    <script> 
   if(window.outerWidth <=623){

       console.log("hecho")
       document.getElementById('iniciarsesion').innerHTML='<i class="fas fa-sign-in-alt">';
       document.getElementById('registro').innerHTML='<i class="fas fa-user-check">';
   }
   
   console.log("La resolución de tu pantalla es: " + window.outerWidth);


</script>

</body>

</html>