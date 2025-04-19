<?php

use LDAP\Result;

include 'conexion.php';

// Obtener el ID de la noticia desde la URL
if (!isset($_GET['id'])) {
  die("Error: No se proporcionó un ID de noticia.");
}
$idNoticia = $_GET['id'];

// Obtener los datos de la noticia desde la base de datos
$sql = "SELECT * FROM noticia WHERE Id = $idNoticia";
$result = $conn->query($sql);

if (!$result) {
  die("Error en la consulta: " . $conn->error);
}

if ($result->num_rows === 0) {
  die("Error: No se encontró la noticia.");
}

$noticia = $result->fetch_assoc();
$idEmpresa = $noticia['idEmpresa'];
$sqlempresa = "SELECT * FROM empresa WHERE  Id=$idEmpresa";
$resultEmpresa = $conn->query($sqlempresa);
$empresa = $resultEmpresa->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
  <meta name="format-detection" content="telephone=no" />
  <link rel="icon" href="images/favicon.ico" type="image/x-icon">
  <title>PRIVACY</title>

  <!-- Bootstrap -->
  <link href="css/bootstrap.css" rel="stylesheet">

  <!-- Links -->
  <link rel="stylesheet" href="css/search.css">

  <!--JS-->
  <script src="js/jquery.js"></script>
  <script src="js/jquery-migrate-1.2.1.min.js"></script>
  <script src="js/rd-smoothscroll.min.js"></script>


  <!--[if lt IE 9]>
    <div style=' clear: both; text-align:center; position: relative;'>
        <a href="http://windows.microsoft.com/en-US/internet-explorer/..">
            <img src="images/ie8-panel/warning_bar_0000_us.jpg" border="0" height="42" width="820"
                 alt="You are using an outdated browser. For a faster, safer browsing experience, upgrade for free today."/>
        </a>
    </div>
    <script src="js/html5shiv.js"></script>
    <![endif]-->
  <script src='js/device.min.js'></script>
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
            <a data-type='rd-navbar-brand' href="./"><small><?php echo $empresa['Denominacion']; ?></small></a>
          </h1>
          <a class="search-form_toggle" href="#"></a>
        </div>

        <div class="help-box text-right">
          <p>Telefono</p>
          <a href="callto:#"><?php echo $empresa['Telefono']; ?></a>
          <small><span>Horario:<?php echo $empresa['HorariodeAtencion']; ?></span> </small>
        </div>
      </div>

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

    <!--========================================================
                            CONTENT
  =========================================================-->

    <main>

      <section class="well well4">

        <div class="container">
          <center>
            <div id="imagenPrincipal" style="height: 450px; background-image: url('<?php echo $noticia['ImagenNoticia']; ?>');
             background-repeat: no-repeat;background-size: cover;">
              <div style="text-align:left; background-color: rgba(1,1,1,0.5);color: #ffffff;font-size: 16px;line-height: 50px;">
                <?php echo $noticia['TitulodelaNoticia']; ?>
              </div>
            </div>
          </center>
          <h2>
            <?php echo $noticia['TitulodelaNoticia']; ?>
          </h2>
          Fecha de Publicación: <?php echo $noticia['FechaPublicada']; ?>
          <hr>
          <div class="row offs2">

            <div class="col-lg-12">
              <dl class="terms-list">
                <dt>
                  <?php echo $noticia['ResumendelaNoticia']; ?>
                </dt>
                <hr>
                <dd>
                  <?php echo $noticia['ContenidoHTML']; ?>
                </dd>
              </dl>
            </div>
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
            <?php echo $empresa['Denomincaión']; ?> &#169; <span id="copyright-year"></span>
            <a href="index-5.html">Privacy Policy</a>
            <!-- {%FOOTER_LINK} -->
          </p>
        </div>
      </section>
    </footer>
  </div>


  <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
  <!-- Include all compiled plugins (below), or include individual files as needed -->
  <script src="js/bootstrap.min.js"></script>
  <script src="js/tm-scripts.js"></script>
  <!-- </script> -->

  <!-- coded by vitlex -->

</body>

</html>
<?php
$conn->close();
?>