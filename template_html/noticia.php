<?php
include 'conexion.php'; // Asegúrate de que este archivo configure $conn correctamente con MySQLi

// Obtener el idEmpresa desde la URL
$idEmpresa = $_GET['idEmpresa'] ?? null;

if (!$idEmpresa) {
    die("Error: No se ha seleccionado una empresa.");
}

// Lógica para cargar los datos de la noticia a editar
$noticiaEditar = null;
if (isset($_GET['editar_noticia'])) {
    $idNoticia = $_GET['editar_noticia'];
    $sql = "SELECT * FROM Noticia WHERE Id = $idNoticia";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $noticiaEditar = $result->fetch_assoc();
    } else {
        echo "Error: Noticia no encontrada.";
    }
}

// Lógica para crear una noticia
if (isset($_POST['crear_noticia'])) {
    $titulo = $_POST['titulo'];
    $resumen = $_POST['resumen'];
    $contenidoHTML = $_POST['contenidoHTML'];
    $publicada = $_POST['publicada'] ?? 'N';
    $fechaPublicacion = $_POST['fecha'];

    // Subir imagen
    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["imagen"]["name"]);
        move_uploaded_file($_FILES["imagen"]["tmp_name"], $target_file);
        $imagenNoticia = basename($_FILES["imagen"]["name"]);
    } else {
        $imagenNoticia = ''; // Si no se sube una imagen
    }

    $sql = "INSERT INTO Noticia (Titulo, Resumen, ImagenNoticia, ContenidoHTML, Publicada, FechaPublicada, idEmpresa)
            VALUES ('$titulo', '$resumen', '$imagenNoticia', '$contenidoHTML', '$publicada', '$fechaPublicacion', $idEmpresa)";

    if ($conn->query($sql) === TRUE) {
        header("Location: noticia.php?idEmpresa=$idEmpresa");
        exit;
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Lógica para modificar una noticia
if (isset($_POST['modificar_noticia'])) {
    $id = $_POST['id'];
    $titulo = $_POST['titulo'];
    $resumen = $_POST['resumen'];
    $contenidoHTML = $_POST['contenidoHTML'];
    $publicada = $_POST['publicada'] ?? 'N';
    $fechaPublicacion = $_POST['fecha'];

    // Si se sube una nueva imagen, actualizarla
    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["imagen"]["name"]);
        move_uploaded_file($_FILES["imagen"]["tmp_name"], $target_file);
        $imagenNoticia = basename($_FILES["imagen"]["name"]);
    } else {
        // Mantener la imagen actual si no se sube una nueva
        $imagenNoticia = $_POST['imagen_actual'];
    }

    $sql = "UPDATE Noticia SET 
                TitulodelaNoticia = '$titulo', 
                ResumendelaNoticia = '$resumen', 
                ImagenNoticia = '$imagenNoticia', 
                ContenidoHTML = '$contenidoHTML', 
                Publicada = '$publicada', 
                FechaPublicada = '$fechaPublicacion'
            WHERE Id = $id";

    if ($conn->query($sql) === TRUE) {
        header("Location: noticia.php?idEmpresa=$idEmpresa");
        exit;
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Lógica para eliminar una noticia
if (isset($_GET['eliminar_noticia'])) {
    $id = $_GET['eliminar_noticia'];
    $sql = "DELETE FROM Noticia WHERE Id = $id";
    if ($conn->query($sql) === TRUE) {
        header("Location: noticia.php?idEmpresa=$idEmpresa");
        exit;
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Consulta de noticias para la empresa seleccionada
$sqlNoticias = "SELECT * FROM Noticia WHERE idEmpresa = $idEmpresa";
$resultNoticias = $conn->query($sqlNoticias);
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrar Noticias</title>
    <!-- Bootstrap CSS -->
    <link href="css/bootstrap.css" rel="stylesheet">
</head>

<body>
    <div class="page">
        <!--========================================================
                            HEADER
  =========================================================-->

        <div id="stuck_container" class="stuck_container">
            <div class="container">
                <nav class="navbar navbar-default navbar-static-top pull-left">
                    <div class="">
                        <ul class="nav navbar-nav sf-menu sf-js-enabled sf-arrows" data-type="navbar">
                            <li style="list-style: none;" class="active">
                                <a href="home.php">INICIO</a>
                            </li>
                            <li style="list-style: none;">
                                <a href="./">LISTA EMPRESAS</a>
                            </li>
                        </ul>
                    </div>
                </nav>
                <form class="search-form" action="buscador.php" method="GET" accept-charset="utf-8">
                    <label class="search-form_label">
                        <input class="search-form_input" type="text" name="buscar" autocomplete="off" placeholder="Ingrese Texto" />
                        <span class="search-form_liveout"></span>
                    </label>
                    <button class="search-form_submit fa-search" type="submit"></button>
                </form>

            </div>

        </div>

        </header>
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container">
                <h1 class="navbar-brand">Administrar Noticias</h1>
            </div>
        </nav>

        <div class="container mt-4">
            <!-- Formulario para crear noticias -->
            <form method="POST" enctype="multipart/form-data" class="border p-4 rounded mb-4">
                <h2 class="mb-4">Crear Noticia</h2>

                <!-- Título -->
                <div class="mb-3">
                    <label for="titulo" class="form-label">Título</label>
                    <input type="text" name="titulo" class="form-control" placeholder="Título de la noticia" required>
                </div>

                <!-- Resumen -->
                <div class="mb-3">
                    <label for="resumen" class="form-label">Resumen</label>
                    <textarea name="resumen" class="form-control" placeholder="Resumen de la noticia" rows="3" required></textarea>
                </div>

                <!-- Imagen -->
                <div class="mb-3">
                    <label for="imagen" class="form-label">Imagen</label>
                    <input type="file" name="imagen" class="form-control">
                </div>

                <!-- Contenido HTML -->
                <div class="mb-3">
                    <label for="contenidoHTML" class="form-label">Contenido HTML</label>
                    <textarea name="contenidoHTML" class="form-control" placeholder="Contenido HTML de la noticia" rows="5" required></textarea>
                </div>

                <!-- Publicada -->
                <div class="mb-3 form-check">
                    <input type="checkbox" name="publicada" class="form-check-input" value="Y">
                    <label for="publicada" class="form-check-label">Publicar Noticia</label>
                </div>

                <!-- Fecha de Publicación -->
                <div class="mb-3">
                    <label for="fecha" class="form-label">Fecha de Publicación</label>
                    <input type="date" name="fecha" class="form-control" value="<?= date('Y-m-d') ?>" required>
                </div>

                <!-- Botón para crear -->
                <button type="submit" name="crear_noticia" class="btn btn-success">Crear Noticia</button>
            </form>

            <!-- Formulario para editar noticias (solo se muestra al editar) -->
            <?php if (isset($noticiaEditar)): ?>
                <form method="POST" enctype="multipart/form-data" class="border p-4 rounded mb-4">
                    <h2 class="mb-4">Editar Noticia</h2>

                    <!-- Campo Oculto para el ID de la Noticia -->
                    <input type="hidden" name="id" value="<?= $noticiaEditar['Id'] ?>">
                    <input type="hidden" name="imagen_actual" value="<?= $noticiaEditar['ImagenNoticia'] ?>">

                    <!-- Título -->
                    <div class="mb-3">
                        <label for="titulo" class="form-label">Título</label>
                        <input type="text" name="titulo" class="form-control" value="<?= $noticiaEditar['TitulodelaNoticia'] ?>" required>
                    </div>

                    <!-- Resumen -->
                    <div class="mb-3">
                        <label for="resumen" class="form-label">Resumen</label>
                        <textarea name="resumen" class="form-control" rows="3" required><?= $noticiaEditar['ResumendelaNoticia'] ?></textarea>
                    </div>

                    <!-- Imagen -->
                    <div class="mb-3">
                        <label for="imagen" class="form-label">Imagen</label>
                        <input type="file" name="imagen" class="form-control">
                    </div>

                    <!-- Contenido HTML -->
                    <div class="mb-3">
                        <label for="contenidoHTML" class="form-label">Contenido HTML</label>
                        <textarea name="contenidoHTML" class="form-control" rows="5" required><?= $noticiaEditar['ContenidoHTML'] ?></textarea>
                    </div>

                    <!-- Publicada -->
                    <div class="mb-3 form-check">
                        <input type="checkbox" name="publicada" class="form-check-input" value="Y" <?= $noticiaEditar['Publicada'] == 'Y' ? 'checked' : '' ?>>
                        <label for="publicada" class="form-check-label">Publicar Noticia</label>
                    </div>

                    <!-- Fecha de Publicación -->
                    <div class="mb-3">
                        <label for="fecha" class="form-label">Fecha de Publicación</label>
                        <input type="date" name="fecha" class="form-control" value="<?= $noticiaEditar['FechaPublicada'] ?>" required>
                    </div>

                    <!-- Botón para modificar -->
                    <button type="submit" name="modificar_noticia" class="btn btn-warning">Actualizar Noticia</button>
                </form>
            <?php endif; ?>

            <!-- Listado de noticias -->
            <table class="table table-hover mt-4">
                <thead>
                    <tr>
                        <th>Título</th>
                        <th>Resumen</th>
                        <th>Imagen</th>
                        <th>Publicada</th>
                        <th>Fecha</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($noticia = $resultNoticias->fetch_assoc()): ?>
                        <tr>
                            <td><?= htmlspecialchars($noticia['TitulodelaNoticia']) ?></td>
                            <td><?= htmlspecialchars($noticia['ResumendelaNoticia']) ?></td>
                            <td><img src="uploads/<?= htmlspecialchars($noticia['ImagenNoticia']) ?>" width="100"></td>
                            <td><?= htmlspecialchars($noticia['Publicada']) ?></td>
                            <td><?= htmlspecialchars($noticia['FechaPublicada']) ?></td>
                            <td>
                                <a href="?editar_noticia=<?= $noticia['Id'] ?>&idEmpresa=<?= $idEmpresa ?>" class="btn btn-warning btn-sm">Editar</a>
                                <a href="?eliminar_noticia=<?= $noticia['Id'] ?>&idEmpresa=<?= $idEmpresa ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Eliminar noticia?')">Eliminar</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>

        <!-- Bootstrap JS (opcional, solo si necesitas funcionalidades de Bootstrap) -->
        <script src="js/bootstrap.bundle.min.js"></script>
</body>

</html>