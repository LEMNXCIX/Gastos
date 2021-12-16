<?php
session_start();

if (isset($_SESSION['user_id'])) {
    header('Location: /Gastos/home.php');
}
require 'Database/conection.php';

if (!empty($_POST['emailLogIn']) && !empty($_POST['passwordLogIn'])) {
    $records = $conection->prepare('SELECT id, email, contrasena FROM usuarios WHERE email =:email');
    $records->bindParam(':email', $_POST['emailLogIn']);
    $records->execute();
    $results = $records->fetch(PDO::FETCH_ASSOC);

    $message = '';

    if (count($results) > 0 && password_verify($_POST['passwordLogIn'], $results['contrasena'])) {
        $_SESSION['user_id'] = $results['id'];
        header("Location: /Gastos/index.php");
    } else {
        echo '<script>Error, Intente de nuevo</script>';
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



    <title>Home</title>
</head>
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
<body>
   


    <!-- Pop Up -->
    <div class="pop-up-container" id="pop-up">

        <a href="#" onclick="cerrar()"> <i class="fas fa-times"></i></a>

        <div class="form-pop-up">
            <h2>Log In</h2>
            <form action="home.php" method="POST">
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

    <?php if (!empty($message)) :
        echo $mensaje ?>

    <?php endif; ?>
    <div class="slideshow-conatainer">
        <!-- Slide 1 -->
        <div class="mySlides fade">
            <div class="info-slide">
                <div class="slide-img1">
                    <div class="slide-text">
                        <h2>Aplicacion Web para el control de gastos</h2>
                        <p>La finalidad de esta applicacion es la de ofrecer una herramienta para poder visualizar los principales gastos e ingresos de una persona</p>


                    </div>
                </div>

            </div>
        </div>
        <!-- Slide 2 -->
        <div class="mySlides fade">
            <div class="info-slide">


                <div class="slide-img2">
                    <div class="slide-text">
                        <h2>Importancia de control de gastos</h2><p>El control de los gastos mensuales permite obtener información relevante sobre la rentabilidad y el desempeño de las actividades empresariales. Además, ayuda también en la planificación y en la toma de decisiones sobre inversiones futuras.</p>
                    </div>
                </div>
            </div>
        </div>
        <!-- COntroles Slide -->
        <!-- <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
        <a class="next" onclick="plusSlides(1)">&#10095;</a> -->
    </div>


    <!-- Scripts -->
    <script src="main.js"></script>
    <script>
        if (window.outerWidth <= 623) {

            console.log("hecho")
            document.getElementById('iniciarsesion').innerHTML = '<i class="fas fa-sign-in-alt">';
            document.getElementById('registro').innerHTML = '<i class="fas fa-user-check">';
        }

        console.log("La resolución de tu pantalla es: " + window.outerWidth);
    </script>


</body>

</html>