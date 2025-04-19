<?php
include 'conexion.php';
// isset verifica q un dato no sea null
//alta de empresa
if (isset($_POST['guardar_empresa'])) {
    $denominacion = $_POST['denominacion'];
    $telefono = $_POST['telefono'];
    $horario = $_POST['horario'];
    $quienesSomos = $_POST['quienesSomos'];
    $latitud = $_POST['latitud'];
    $longitud = $_POST['longitud'];
    $domicilio = $_POST['domicilio'];
    $email = $_POST['email'];

    $sql = "INSERT INTO empresa (Denominacion,Telefono,HorariodeAtencion,QuienesSomos,Latitud,Longitud,Domicilio,Email)
    VALUES ('$denominacion','$telefono','$horario','$quienesSomos','$latitud','$longitud','$domicilio','$email')";
    if ($conn->query($sql) === TRUE) {
        echo "la empresa se guardo correctamente";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
//baja de empresa
if (isset($_POST['eliminar_empresa'])) {
    $id = $_GET['eliminar_empresa'];
    $sql = "DELETE FROM empresa WHERE Id =$id";
    if ($conn->query($sql) === TRUE) {
        echo "la empresa fue eliminada correctamente";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
//Modificar empresa
if (isset($_POST['modificar_empresa'])) {
    $id = $_POST['id'];
    $denominacion = $_POST['denominacion'];
    $telefono = $_POST['telefono'];
    $horario = $_POST['horario'];
    $quienesSomos = $_POST['quienesSomos'];
    $latitud = $_POST['latitud'];
    $longitud = $_POST['longitud'];
    $domicilio = $_POST['domicilio'];
    $email = $_POST['email'];

    $sql = "UPDATE Empresa SET Denominacion= '$denominacion',Telefono= '$telefono',
        HorariodeAtencion='$horario',QuienesSomos='$quienesSomos',
        Latitud='$latitud',Longitud='$longitud',Domicilio='$domicilio',Email='$email' WHERE Id = $id";
    if ($conn->query($sql) === TRUE) {
        echo "empresa modificada correctamente";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
// Consulta de empresas
$sql = "SELECT * FROM Empresa";
$result = $conn->query($sql);
