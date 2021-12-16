<?php 
session_start();
require 'conexion.php';
//DELETE GASTOS
//Variable get de eliminar
$idGas=$_GET['idLocalGas'];

$deleteGas="DELETE FROM gastos WHERE localId =$idGas";
$resGas=mysqli_query($conexion,$deleteGas);
header("location: /Gastos/index.php");

//DELETE INGRESOS
$idIng=$_GET['idLocalIng'];

$deleteIng="DELETE FROM ingresos WHERE localId =$idIng";
$resIng=mysqli_query($conexion,$deleteIng);
header("location: /Gastos/index.php");

echo 'user id: '.$_SESSION['user_id'];

echo ' tipo: '.$_POST['tipoIng'];
echo ' descripcion'.$_POST['descIng'];
echo ' fecha'.$_POST['fechaIng'];
echo ' dinero'.$_POST['dineroIng'];
require 'conection.php';

//INSERT GASTOS
if (!empty($_POST['descGas']) && !empty($_POST['fechaGas']) && !empty($_POST['tipoGas'])  && !empty($_POST['dineroGas'])) {
    $sqlGas = "INSERT INTO gastos (id,descripcion, fecha, tipo, gasto) VALUES (:idGas, :descGas, :fechaGas, :tipoGas, :dineroGas)";
    $stmtGas = $conection->prepare($sqlGas);
    $stmtGas->bindParam(':idGas', $_SESSION['user_id']);
    $stmtGas->bindParam(':descGas', $_POST['descGas']);
    $stmtGas->bindParam(':tipoGas',$_POST['tipoGas']);
    $stmtGas->bindParam(':fechaGas', $_POST['fechaGas']);
    $stmtGas->bindParam(':dineroGas', $_POST['dineroGas']);
    if ($stmtGas->execute()) {
      echo '<script>alert("Registro Exitoso");</script>';
    } else {
      
        echo '<script>alert("Ha ocurrido un error'.print_r($stmtGas->errorInfo()).'");</script>';
    }
  }

  //INSERT INGRESOS
  if (!empty($_POST['descIng']) && !empty($_POST['fechaIng']) && !empty($_POST['tipoIng'])  && !empty($_POST['dineroIng'])) {
    $sqlIng = "INSERT INTO ingresos (id,descripcion, fecha, tipo, ingreso) VALUES (:idIng, :descIng, :fechaIng, :tipoIng, :dineroIng)";
    $stmtIng = $conection->prepare($sqlIng);
    $stmtIng->bindParam(':idIng', $_SESSION['user_id']);
    $stmtIng->bindParam(':descIng', $_POST['descIng']);
    $stmtIng->bindParam(':tipoIng',$_POST['tipoIng']);
    $stmtIng->bindParam(':fechaIng', $_POST['fechaIng']);
    $stmtIng->bindParam(':dineroIng', $_POST['dineroIng']);
    if ($stmtIng->execute()) {
      echo '<script>alert("Registro Exitoso");</script>';
    } else {
       
        echo '<script>alert("Ha ocurrido un error'.print_r($stmtIng->errorInfo()).'");</script>';
    }
  }