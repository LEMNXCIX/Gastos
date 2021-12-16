<?php
session_start();
require 'Database/conection.php';

if (isset($_SESSION['user_id'])) {
    $records = $conection->prepare('SELECT id, email, contrasena, nombre, apellido FROM usuarios WHERE id = :id');
    $records->bindParam(':id', $_SESSION['user_id']);
    $records->execute();
    $results = $records->fetch(PDO::FETCH_ASSOC);

    //SELECT GASTOS
    $selectGas = $conection->prepare('SELECT id, localId, descripcion, fecha, gasto, tipo FROM gastos WHERE id = :id');
    $selectGas->bindParam(':id', $_SESSION['user_id']);
    $selectGas->execute();
    $gasto = $selectGas->fetchAll();
    //SELECT INGRESOS   
    $selectIng = $conection->prepare('SELECT id, localId, descripcion, fecha, ingreso, tipo FROM ingresos WHERE id = :id');
    $selectIng->bindParam(':id', $_SESSION['user_id']);
    $selectIng->execute();
    $ingreso = $selectIng->fetchAll();

    $user = null;
    $gastos = null;
    $ingresos = null;
    if (count($results) > 0) {
        $user = $results;
    }
    if (count($gasto) > 0) {
        $gastos = $gasto;
    }
    if (count($ingreso) > 0) {
        $ingresos = $ingreso;
    }
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Index</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css" />
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">


</head>
<nav>
        <?php if (!empty($user)) : ?>


            <div class="nav-items">

                <p>Bienvenido: <?= $user['nombre']; ?> <?= $user['apellido'] ?></p>
            </div>
            <div class="nav-items">
                <a href="logout.php" id="logout" class="button"><i class="fas fa-sign-out-alt"></i>Cerrar sesion</a>
            </div>

    </nav>
<body>
    
    <div class="grid">
        <!-- Forulario de Ingresos -->
        <div class="grid-item">

            <h2 class="h2">Ingresos</h2>
            <table cellspacing="0" class="">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Descripcion</th>
                        <th scope="col">Fecha</th>
                        <th scope="col">Tipo</th>
                        <th scope="col">DInero</th>
                        <th scope="col">Accion</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <form action="../Gastos/Database/querry.php" method="POST">
                            <th></th>
                            <th><input class="input-form" type="text" name="descIng" id=""></th>
                            <th><input class="input-form" type="date" name="fechaIng" id="fcha"value="<?php echo date("Y-m-d");?>" min="<?php echo date("Y-m-01")?>" max="<?php echo date("Y-m-31")?>"></th>
                            <th><select class="input-form" name="tipoIng" id="">
                                    <option selected value="Sueldo Basico">Sueldo Basico</option>
                                    <option value="Otros Ingresos">Otros Ingresos</option>
                                    <option value="Ingresos Extraordinarios">Ingresos Extraordinarios</option>

                                </select></th>
                            <th><input class="input-form" name="dineroIng" type="number"></th>
                            <th><button class="button" style="color: rgb(50, 190, 20); font-size: 15px;" type="submit"><i class="fas fa-plus"></i></button></th>
                        </form>
                    </tr>

                    <?php

                    $tipoIng = "";
                    $auxIng = 0;
                    $sumaSBU = 0;
                    $sumaOG = 0;
                    $sumaIE = 0;

                    //inicializar array
                    foreach ($ingreso as $ingresos) {
                        # code...
                        echo '<tr>';
                        echo '<td> ' . $ingresos['localId'] . '</td>';
                        echo '<td>' . $ingresos['descripcion'] . '</td>';
                        echo '<td>' . $ingresos['fecha'] . '</td>';
                        echo '<td>' . $ingresos['tipo'] . '</td>';
                        echo '<td>' . number_format($ingresos['ingreso'], 2, '.', ',') . '</td>';
                        echo " <td><a class='button' style ='color: red; font-size: 15px' name='eliminar' href='/Gastos/Database/querry.php?idLocalIng=" . $ingresos['localId'] . "'><i class='fas fa-trash-alt'></i></a></td>";
                        echo '</tr>';
                        $auxIng = $ingresos['ingreso'];
                        settype($auxIng, "integer");


                        $tipoIng = $ingresos['tipo'];

                        switch ($tipoIng) {

                            case 'Sueldo Basico':

                                $sumaSBU += $auxIng;

                                break;
                            case 'Otros Ingresos';
                                $sumaOG += $auxIng;

                                break;
                            case 'Ingresos Extraordinarios';
                                $sumaIE += $auxIng;

                                break;
                        }
                    }

                    ?>


                </tbody>
            </table>
        </div>
        <div class="grid-item">
            <h2 class="h2">Grafico</h2>

            <canvas style="width: 100%;" id="chart"></canvas>


        </div>
        <!-- Formulario de Gastros -->
        <div class="grid-item">
            <h2 class="h2">Gastos</h2>
            <table cellspacing='0'>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Descripcion</th>
                        <th>Fecha</th>
                        <th>Tipo</th>
                        <th>Dinero</th>
                        <th>Accion</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <form action="../Gastos/Database/querry.php" method="POST">
                            <th></th>
                            <th><input class="input-form" type="text" name="descGas" id=""></th>
                            <th><input class="input-form" type="date" name="fechaGas" id="fecha" value="<?php echo date("Y-m-d");?>" min="<?php echo date("Y-m-01")?>" max="<?php echo date("Y-m-31")?>"></th>
                            <th><select class="input-form" name="tipoGas" id="">
                                    <option selected value="Alimentacion">Alimentacion</option>
                                    <option value="Salud">Salud</option>
                                    <option value="Educacion">Educacion</option>
                                    <option value="Vivienda">Vivienda</option>
                                    <option value="Servicios Basicos">Sercicios Basicos</option>
                                    <option value="Otros Gastos">Otros Gastos</option>
                                </select></th>
                            <th><input class="input-form" name="dineroGas" type="number"></th>
                            <th><button class="button" style="color: rgb(50, 190, 20); font-size: 15px;" type="submit"><i class="fas fa-plus"></i></button></th>
                        </form>
                    </tr>

                    <?php
                    $auxGas = 0;
                    $tipoGas = "";
                    $sumaOtro = 0;
                    $sumaAli = 0;
                    $sumaSal = 0;
                    $sumaEdu = 0;
                    $sumaViv = 0;
                    $sumaSB = 0;

                    $valores = array(); //inicializar array
                    foreach ($gasto as $gastos) {
                        # code...
                        echo '<tr>';
                        echo '<td> ' . $gastos['localId'] . '</td>';
                        echo '<td>' . $gastos['descripcion'] . '</td>';
                        echo '<td>' . $gastos['fecha'] . '</td>';
                        echo '<td>' . $gastos['tipo'] . '</td>';
                        echo '<td>' . number_format($gastos['gasto'], 2, '.', ',') . '</td>';
                        echo " <td><a class='button' style='color: red; font-size: 15px' name='eliminar' href='/Gastos/Database/querry.php?idLocalGas=" . $gastos['localId'] . "'><i class='fas fa-trash-alt'></i></a></td>";
                        echo '</tr>';
                        $auxGas = $gastos['gasto'];
                        settype($aux, "integer");


                        // echo "aux" . $aux;
                        $tipoGas = $gastos['tipo'];

                        switch ($tipoGas) {

                            case 'Otros Gastos':

                                $sumaOtro += $auxGas;

                                break;
                            case 'Alimentacion';
                                $sumaAli += $auxGas;

                                break;
                            case 'Salud';
                                $sumaSal += $auxGas;

                                break;
                            case 'Educacion';
                                $sumaEdu += $auxGas;

                                break;
                            case 'Vivienda';
                                $sumaViv += $auxGas;


                                break;
                            case 'Servicios Basicos';
                                $sumaSB += $auxGas;

                                break;
                        }
                    }
                    ?>


                </tbody>
            </table>
        </div>
        <div class="grid-item">
            <h2 class="h2">Grafico</h2>

            <canvas style="width: 100%;" id="myChart"></canvas>


        </div>


    </div>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>

    <script>
        Chart.defaults.global.defaultFontColor = "#fff"; //Para forzar poner todo el texto en blanco
        // For a pie chart
        var ctx = document.getElementById('myChart').getContext('2d');
        var chart = new Chart(ctx, {
            // The type of chart we want to create
            type: 'bar',

            // The data for our dataset
            data: {
                labels: ['Alimentacion', 'Salud', 'Educacion', 'Vivienda', 'Servicios Basicos', 'Otros Gastos'],
                datasets: [{
                    label: ['Alimentacion'],
                    backgroundColor: ['#c0e218', '#6699cc', '#ff3c38', "#fff275", '#ff8c42', '#a23e48'],
                    borderColor: ['#c0e218', '#6699cc', '#ff3c38', "#fff275", '#ff8c42', '#a23e48'],
                    data: ['<?php echo $sumaAli ?>', '<?php echo $sumaSal ?>', '<?php echo $sumaEdu ?>', '<?php echo $sumaViv ?>', '<?php echo $sumaSB ?>', '<?php echo $sumaOtro ?>']
                }],
            },
            // Configuration options go here
            options: {
                legend: {
                    labels: {
                        // This more specific font property overrides the global property
                        fontColor: 'White',
                        fontFamily: 'Poppins',
                        fontSize: 16,
                    },
                    tittle: {
                        fontcolor: 'White'
                    }

                }
            }

        });
        var ctx = document.getElementById('chart').getContext('2d');
        var chart = new Chart(ctx, {
            // The type of chart we want to create
            type: 'doughnut',

            // The data for our dataset
            data: {
                labels: ['Sueldo Basico', 'Otros Ingresos', 'Imgresos Extraordinarios'],
                datasets: [{
                    label: ['Alimentacion'],
                    backgroundColor: ['rgb(255, 99, 132)', 'rgb(54, 162, 235)', 'rgb(255, 205, 86)'],
                    borderColor: ['rgb(255, 99, 132)', 'rgb(54, 162, 235)', 'rgb(255, 205, 86)'],
                    data: ['<?php echo $sumaSBU ?>', '<?php echo $sumaOG ?>', '<?php echo $sumaIE ?>']
                }],
            },

            // Configuration options go here
            options: {
                legend: {
                    labels: {
                        // This more specific font property overrides the global property
                        fontColor: 'White',
                        fontFamily: 'Poppins',
                        fontSize: 16,
                    },

                }
            }

        });
    </script>
    <script>
        if (window.outerWidth <= 623) {

            console.log("hecho")
            document.getElementById('logout').innerHTML = '<i class="fas fa-sign-out-alt"></i>';
         
        }

       
    </script>

<?php else : ?>
    <div class="nav-items">No haz iniciado sesion correctamente, vuelve a <a href="home.php">HOME</a> e intentalo nuevamente</div>
<?php endif; ?>

</body>

</html>