<?php
include 'conexion.php';

// Obtener el texto de búsqueda
$buscarTexto = isset($_GET['buscar']) ? $_GET['buscar'] : '';

// Consulta SQL para buscar en los campos Titulo y Resumen
$sqlNoticias = "SELECT * FROM noticia 
                WHERE TitulodelaNoticia LIKE '%$buscarTexto%' OR ResumendelaNoticia LIKE '%$buscarTexto%'
                ORDER BY FechaPublicada DESC
                LIMIT 20";  // Limitar a las últimas 20 noticias

$resultNoticias = $conn->query($sqlNoticias);

if (!$resultNoticias) {
  die("Error en la consulta: " . $conn->error);
}

// Obtener la primera noticia para mostrar datos de la empresa (si hay resultados)
$noticia = $resultNoticias->fetch_assoc();
$idEmpresa = isset($noticia['idEmpresa']) ? $noticia['idEmpresa'] : null;

// Obtener datos de la empresa (si existe una noticia)
if ($idEmpresa) {
  $sqlEmpresa = "SELECT * FROM empresa WHERE Id = $idEmpresa";
  $resultEmpresa = $conn->query($sqlEmpresa);

  if (!$resultEmpresa) {
    die("Error en la consulta de empresa: " . $conn->error);
  }

  $Empresa = $resultEmpresa->fetch_assoc();
} else {
  $Empresa = null;  // No hay empresa asociada
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
  <meta name="format-detection" content="telephone=no" />
  <link rel="icon" href="images/favicon.ico" type="image/x-icon" />
  <title>Buscador de Noticias</title>

  <!-- Bootstrap -->
  <link href="css/bootstrap.css" rel="stylesheet" />

  <!-- Links -->
  <link rel="stylesheet" href="css/search.css" />

  <!--JS-->
  <script src="js/jquery.js"></script>
  <script src="js/jquery-migrate-1.2.1.min.js"></script>
  <script src="js/rd-smoothscroll.min.js"></script>

  <!--[if lt IE 9]>
      <div style="clear: both; text-align: center; position: relative">
        <a href="http://windows.microsoft.com/en-US/internet-explorer/..">
          <img
            src="images/ie8-panel/warning_bar_0000_us.jpg"
            border="0"
            height="42"
            width="820"
            alt="You are using an outdated browser. For a faster, safer browsing experience, upgrade for free today."
          />
        </a>
      </div>
      <script src="js/html5shiv.js"></script>
    <![endif]-->
  <script src="js/device.min.js"></script>
</head>

<body>
  <div class="page">
    <!--========================================================
                            HEADER
  =========================================================-->
    <header>
      <div class="container top-sect">
        <div class="navbar-header">
          <h1 class="navbar-brand">
            <a data-type="rd-navbar-brand" href="./">
              <small><?php echo isset($Empresa['Denominacion']) ? $Empresa['Denominacion'] : 'Empresa'; ?></small>
            </a>
          </h1>
          <a class="search-form_toggle" href="#"></a>
        </div>

        <div class="help-box text-right">
          <p>Telefono</p>
          <a href="callto:#"><?php echo isset($Empresa['Telefono']) ? $Empresa['Telefono'] : '800-2345-6789'; ?></a>
          <small><span>Horario:</span> <?php echo isset($Empresa['HorariodeAtencion']) ? $Empresa['HorariodeAtencion'] : '6am-4pm PST M-Th; 6am-3pm PST Fri'; ?></small>
        </div>
      </div>

      <div id="stuck_container" class="stuck_container">
        <div class="container">
          <nav class="navbar navbar-default navbar-static-top pull-left">
            <div class="">
              <ul class="nav navbar-nav sf-menu sf-js-enabled sf-arrows" data-type="navbar">
                <li style="list-style: none" class="active">
                  <a href="home.php">INICIO</a>
                </li>
                <li style="list-style: none">
                  <a href="./">LISTA EMPRESAS</a>
                </li>
              </ul>
            </div>
          </nav>
          <form class="search-form" action="buscador.php" method="GET" accept-charset="utf-8">
            <label class="search-form_label">
              <input
                class="search-form_input"
                type="text"
                name="buscar"
                autocomplete="off"
                placeholder="Ingrese Texto" />
              <span class="search-form_liveout"></span>
            </label>
            <button class="search-form_submit fa-search" type="submit"></button>
          </form>
        </div>
      </div>
    </header>

    <!--========================================================
                            CONTENT
  =========================================================-->

    <main>
      <section class="well well4">
        <div class="container">
          <h2>Resultado de su búsqueda: "<?php echo htmlspecialchars($buscarTexto); ?>"</h2>
          <div class="row offs2">
            <?php if ($resultNoticias->num_rows > 0): ?>
              <?php while ($noticia = $resultNoticias->fetch_assoc()): ?>
                <table width="90%" align="center">
                  <tbody>
                    <tr>
                      <td>
                        <a href="detalle.php?id=<?php echo $noticia['Id']; ?>">
                          <img
                            width="250px"
                            class="imgNoticia"
                            src="uploads/<?php echo $noticia['ImagenNoticia']; ?>"
                            alt=" " />
                        </a>
                      </td>
                      <td width="25"></td>
                      <td style="text-align: justify" valign="top">
                        <a
                          style="text-align: justify; font-size: 20px"
                          href="detalle.php?id=<?php echo $noticia['Id']; ?>"
                          class="banner">
                          <?php echo $noticia['TitulodelaNoticia']; ?>
                        </a>
                        <div class="verOcultar">
                          <?php echo $noticia['ResumendelaNoticia']; ?>
                          <a
                            href="detalle.php?id=<?php echo $noticia['Id']; ?>"
                            style="color: blue">
                            Leer Más - <?php echo $noticia['FechaPublicada']; ?>
                          </a>
                        </div>
                      </td>
                    </tr>
                  </tbody>
                </table>
                <hr />
              <?php endwhile; ?>
            <?php else: ?>
              <p>No se encontraron noticias que coincidan con la búsqueda.</p>
            <?php endif; ?>
          </div>
        </div>
      </section>
    </main>

    <!--========================================================
                            FOOTER
  =========================================================-->
    <footer>
      <section class="well">
        <div class="container">
          <p class="rights">
            <?php echo isset($Empresa['Denominacion']) ? $Empresa['Denominacion'] : 'Empresa'; ?>
            &#169; <span id="copyright-year"></span>
            <a href="index-5.html">Privacy Policy</a>
          </p>
        </div>
      </section>
    </footer>
  </div>

  <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
  <!-- Include all compiled plugins (below), or include individual files as needed -->
  <script src="js/bootstrap.min.js"></script>
  <script src="js/tm-scripts.js"></script>
</body>

</html>

<?php
$conn->close();
?>