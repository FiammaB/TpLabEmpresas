<?php
include 'conexion.php';
$idEmpresa = $_GET['id'];
$resultEmpresa = $conn->query("SELECT * FROM empresa WHERE Id = $idEmpresa");
$empresa = $resultEmpresa->fetch_assoc();
$sqlNoticias = "SELECT * FROM noticia WHERE idEmpresa = $idEmpresa ORDER BY FechaPublicada DESC LIMIT 5";
$resultNoticias = $conn->query($sqlNoticias);
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
  <title>HOME</title>

  <!-- Bootstrap -->
  <link href="css/bootstrap.css" rel="stylesheet">

  <!-- Links -->
  <link rel="stylesheet" href="css/camera.css">
  <link rel="stylesheet" href="css/search.css">
  <link rel="stylesheet" href="css/google-map.css">


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
          <small><span>Horario:</span> <?php echo $empresa['HorariodeAtencion']; ?> </small>
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

      <section class="well well1 well1_ins1">
        <div class="camera_container">
          <div id="camera" class="camera_wrap">
            <?php while ($noticia = $resultNoticias->fetch_assoc()) { ?>
              <div data-src="<?php echo $noticia['ImagenNoticia'] ?>">
                <div class="camera_caption fadeIn">
                  <div class="jumbotron jumbotron1">
                    <em>
                      <a href="detalle.php?id=<?php echo $noticia['Id']; ?>">
                        <?php echo $noticia['TitulodelaNoticia']; ?>
                      </a>
                    </em>
                    <div class="wrap">
                      <p>
                        <?php echo $noticia['ResumendelaNoticia']; ?>
                      </p>
                      <a href="detalle.php?id=<?php echo $noticia['Id']; ?>" class="btn-link fa-angle-right"></a>
                    </div>
                  </div>
                </div>
              </div>
            <?php } ?>
          </div>
        </div>

        <section class="well well2 wow fadeIn  bg1" data-wow-duration='3s'>
          <div class="container">

            <h2 class="txt-pr">
              Quienes Somos
            </h2>
            <div class="row">
              <div class="col">
                <p style="text-align:justify">
                  <?php echo $empresa['QuienesSomos']; ?>
                </p>
              </div>
            </div>

          </div>
        </section>

    </main>

    <!--========================================================
                            FOOTER
  =========================================================-->
    <footer class="top-border">
      <section class="well well2 wow fadeIn  bg1" data-wow-duration='3s'>
        <div class="container">
          <h2 class="txt-pr">
            Donde estamos
          </h2>
        </div>
      </section>
      <div class="map">

        <iframe
          src="https://maps.google.com/maps?q=<?php echo urlencode($empresa['Domicilio']); ?>&t=&z=13&ie=UTF8&iwloc=&output=embed"
          width="1600"
          height="400"
          style="border:0;"
          allowfullscreen=""
          loading="lazy"></iframe>
      </div>

      <section class="well1">
        <div class="container">
          <p class="rights">
            <?php echo $empresa['Denominacion']; ?> &#169; <span id="copyright-year"></span>
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


</body>

</html>
<?php
$conn->close();
?>