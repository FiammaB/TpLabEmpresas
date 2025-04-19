<?php
include 'conexion.php'; // Asegúrate de que este archivo configure $conn correctamente con MySQLi

// Obtener todas las empresas
$sql = "SELECT * FROM Empresa";
$result = $conn->query($sql);

// Lógica para crear una empresa
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['crear'])) {
  $denominacion = $_POST['denominacion'];
  $telefono = $_POST['telefono'];
  $horario = $_POST['horario'];
  $quienes = $_POST['quienes'];
  $latitud = $_POST['latitud'];
  $longitud = $_POST['longitud'];
  $domicilio = $_POST['domicilio'];
  $email = $_POST['email'];

  $sql = "INSERT INTO Empresa (Denominacion, Telefono, HorariodeAtencion, QuienesSomos, Latitud, Longitud, Domicilio, Email)
            VALUES ('$denominacion', '$telefono', '$horario', '$quienes', '$latitud', '$longitud', '$domicilio', '$email')";
  if ($conn->query($sql) === TRUE) {
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
  } else {
    echo "Error: " . $sql . "<br>" . $conn->error;
  }
}

// Lógica para editar una empresa
if (isset($_GET['editar'])) {
  $idEditar = $_GET['editar'];
  $sql = "SELECT * FROM Empresa WHERE Id = $idEditar";
  $resultEditar = $conn->query($sql);
  $empresaEditar = $resultEditar->fetch_assoc();
}

// Lógica para eliminar una empresa
if (isset($_GET['eliminar'])) {
  $idEliminar = $_GET['eliminar'];
  $sql = "DELETE FROM Empresa WHERE Id = $idEliminar";
  if ($conn->query($sql) === TRUE) {
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
  } else {
    echo "Error: " . $sql . "<br>" . $conn->error;
  }
}

// Lógica para actualizar una empresa
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['actualizar'])) {
  $id = $_POST['id'];
  $denominacion = $_POST['denominacion'];
  $telefono = $_POST['telefono'];
  $horario = $_POST['horario'];
  $quienes = $_POST['quienes'];
  $latitud = $_POST['latitud'];
  $longitud = $_POST['longitud'];
  $domicilio = $_POST['domicilio'];
  $email = $_POST['email'];

  $sql = "UPDATE Empresa SET 
                Denominacion = '$denominacion', 
                Telefono = '$telefono', 
                HorariodeAtencion = '$horario', 
                QuienesSomos = '$quienes', 
                Latitud = '$latitud', 
                Longitud = '$longitud', 
                Domicilio = '$domicilio', 
                Email = '$email'
            WHERE Id = $id";
  if ($conn->query($sql) === TRUE) {
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
  } else {
    echo "Error: " . $sql . "<br>" . $conn->error;
  }
}
?>

<!DOCTYPE html>
<html>

<head>
  <title>Index</title>
  <link href="css/bootstrap.css" rel="stylesheet">
</head>

<body>
  <nav class="navbar navbar-expand-lg bg-body-tertiary" style="background-color: #21c2f8 ;">
    <div class="container-md">
      <h1>Gestionar de Empresas</h1>
    </div>
  </nav>
  <div class="w-fit mx-auto py-[20px]">
    <div class="flex gap-8">
      <div>
        <!-- Formulario para agregar una nueva empresa -->
        <form method="POST" class="mb-4 p-4 border">
          <h2 class="text-lg font-bold mb-2">Crear Empresa</h2>
          <input type="text" name="denominacion" placeholder="Denominación" required class="block mb-2 p-1 border">
          <input type="text" name="telefono" placeholder="Teléfono" required class="block mb-2 p-1 border">
          <input type="text" name="horario" placeholder="Horario Atención" required class="block mb-2 p-1 border">
          <input type="text" name="quienes" placeholder="Quiénes Somos" required class="block mb-2 p-1 border">
          <input type="text" name="latitud" placeholder="Latitud" required class="block mb-2 p-1 border">
          <input type="text" name="longitud" placeholder="Longitud" required class="block mb-2 p-1 border">
          <input type="text" name="domicilio" placeholder="Domicilio" required class="block mb-2 p-1 border">
          <input type="email" name="email" placeholder="Email" required class="block mb-2 p-1 border">
          <button type="submit" name="crear" class="py-2 px-4 bg-green-400 text-white">Crear Empresa</button>
        </form>
        <!-- Formulario para editar una empresa -->
        <?php if (isset($empresaEditar)): ?>
          <form method="POST" class="mt-4 p-4 border">
            <h2 class="text-lg font-bold mb-2">Editar Empresa</h2>
            <input type="hidden" name="id" value="<?= $empresaEditar['Id'] ?>">
            <input type="text" name="denominacion" value="<?= htmlspecialchars($empresaEditar['Denominacion']) ?>" required class="block mb-2 p-1 border">
            <input type="text" name="telefono" value="<?= htmlspecialchars($empresaEditar['Telefono']) ?>" required class="block mb-2 p-1 border">
            <input type="text" name="horario" value="<?= htmlspecialchars($empresaEditar['HorariodeAtencion']) ?>" required class="block mb-2 p-1 border">
            <input type="text" name="quienes" value="<?= htmlspecialchars($empresaEditar['QuienesSomos']) ?>" required class="block mb-2 p-1 border">
            <input type="text" name="latitud" value="<?= htmlspecialchars($empresaEditar['Latitud']) ?>" required class="block mb-2 p-1 border">
            <input type="text" name="longitud" value="<?= htmlspecialchars($empresaEditar['Longitud']) ?>" required class="block mb-2 p-1 border">
            <input type="text" name="domicilio" value="<?= htmlspecialchars($empresaEditar['Domicilio']) ?>" required class="block mb-2 p-1 border">
            <input type="email" name="email" value="<?= htmlspecialchars($empresaEditar['Email']) ?>" required class="block mb-2 p-1 border">
            <button type="submit" name="actualizar" class="py-2 px-4 bg-blue-400 text-white">Actualizar Empresa</button>
          </form>
        <?php endif; ?>
      </div>
      <table class="table table-hover">
        <nav class="navbar navbar-expand-lg bg-body-tertiary" style="background-color: #21c2f8 ;">
          <div class="container-md">
            <h1>Listado de Empresas</h1>
          </div>
        </nav>
        <tr class="table-primary">
          <th class="table-primary">EMPRESA</th>
          <th class="table-primary">VER PÁGINA</th>
          <th class="table-primary">ACCIONES</th>
          <th class="table-primary">ADMIN NOTICIAS</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()): ?>
          <tr>
            <td><?= htmlspecialchars($row['Denominacion']) ?></td>
            <td><a href="home.php?id=<?= $row['Id'] ?>">Ver Página</a></td>
            <td>
              <a href="?editar=<?= $row['Id'] ?>" class="text-yellow-500">Editar</a> |
              <a href="?eliminar=<?= $row['Id'] ?>" onclick="return confirm('¿Eliminar empresa?')" class="text-red-500">Eliminar</a>
            </td>
            <td>
              <a href="/noticia.php?idEmpresa=<?= $row['Id'] ?>" class="text-yellow-500">Administrar</a>
            </td>
          </tr>
        <?php endwhile; ?>
      </table>
    </div>
  </div>
</body>

</html>