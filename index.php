<?php
session_start();
if(isset($_GET['odhlasit'])){
  session_destroy();
  header("Location: index.php");
  exit();
}

require_once('Db.php');
require_once('funkce.php');
Db::connect('127.0.0.1', 'obchodit3', 'root', '');

if(isset($_POST['prihlaseni'])){
  $existuje = Db::queryOne('
  SELECT *
  FROM uzivatel
  WHERE jmeno=?
', $_POST['jmeno']);
  if ($existuje && password_verify($_POST['heslo'], $existuje['heslo'])){
    $_SESSION['uzivatel_id'] = $existuje['id'];
    $_SESSION['uzivatel_jmeno'] = $existuje['jmeno'];
    $_SESSION['uzivatel_admin'] = $existuje['admin'];
    if($_SESSION['uzivatel_admin']==1){
      header('Location: index.php?stranka=administrace');
      exit();
    }
    else{
      header('Location: index.php');
      exit();
    }
  }
  else{
    $zprava = 'Neplatné přihlášení';
  }  
}

if (isset($_POST['registrace']))
{
    if ($_POST['rok'] != date('Y'))
        $zprava = 'Chybně vyplněný antispam.';
    else if ($_POST['heslo'] != $_POST['heslo_znovu'])
        $zprava = 'Hesla nesouhlasí';
    else
    {
        $existuje = Db::querySingle('
            SELECT COUNT(*)
            FROM uzivatel
            WHERE jmeno=?
            LIMIT 1
        ', $_POST['jmeno']);
        if ($existuje)
        {
            $zprava = 'Uživatel s touto přezdívkou je již v databázi obsažen.';
        }
        else
        {
            $heslo = password_hash($_POST['heslo'], PASSWORD_DEFAULT);
            Db::query('
                INSERT INTO uzivatel (jmeno, heslo)
                VALUES (?, ?)
            ', $_POST['jmeno'], $heslo);
            $_SESSION['uzivatel_id'] = Db::getLastId();
            $_SESSION['uzivatel_jmeno'] = $_POST['jmeno'];
            $_SESSION['uzivatel_admin'] = 0;
            $_SESSION['oznameni']="Zaregistroval se uživatel ".ucfirst($_SESSION['uzivatel_jmeno']);
            header('Location: index.php?zprava=pridanyUzivatel');
            exit();
        }
    }
}

if(isset($_POST['kosikObjednat'])){
  if(!isset($_SESSION['uzivatel_id'])){
    $zpravaNakup="Nejsi přihlášený";
  }
  else
  if($_SESSION['uzivatel_admin']==1){
      $zpravaNakup="Nemůžeš nakupovat";
  }  

  //nákup zboží
  if(isset($zpravaNakup)){
    echo('<p class="alert alert-danger p-1">'.$zprava.'</p>');
  }
  else{
    $datum=strftime("%Y-%m-%d",time());
    $faktura=Db::query("INSERT INTO `faktury` 
                      (`id`, `idUzivatele`, `datum`, `stav`, `poznamka`) 
                      VALUES (NULL, ?, '$datum', 'založeno', '');",$_SESSION['uzivatel_id']);
    if($faktura==1){
      echo('<p class="alert alert-success p-1">Objednávka byla vytvořena.</p>');
      $cisloFaktury=Db::getLastId();
      $obsahKosiku=Db::queryAll("select * from kosik where idUzivatele=?",$_SESSION['uzivatel_id']);
      foreach($obsahKosiku as $z){
        $cenaZbozi=Db::querySingle("select cena from zbozi where id=?",$z['idZbozi']);
        Db::query("INSERT INTO radekfaktury 
                  (idFaktury, idZbozi, cena, ks) 
                  VALUES (?,?,?,?);",
                  $cisloFaktury,$z['idZbozi'],$cenaZbozi,$z['ks']);

        Db::query("UPDATE zbozi 
                    SET ks=ks-? 
                    WHERE id=?",
                    $z['ks'],$z['idZbozi']);         
      }
      Db::query("delete from kosik where idUzivatele=?",$_SESSION['uzivatel_id']);
    }
    else{
      echo('<p class="alert alert-warning p-1">Objednávka nebyla vytvořena.</p>');
    }
  }
}
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="bootstrap-4.0.0/favicon.ico">

    <title>Náš obchod</title>

    <!-- Bootstrap core CSS -->
    <link href="bootstrap-4.0.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

    <!-- Custom styles for this template -->
    <link href="jumbotron.css" rel="stylesheet">
  </head>

  <body>
    <?php
    if(isset($_GET['zprava'])){
      switch($_GET['zprava']){
        case "pridanyUzivatel":
        {
          $naseZprava="Zaregistroval se uživatel ".ucfirst($_SESSION['uzivatel_jmeno']);
          break;
        }
      }
      echo "<div class='alert alert-success'>$naseZprava</div>";
    }

    //if(isset($_SESSION['oznameni'])){
    //  echo "<div class='alert alert-success'>".$_SESSION['oznameni']."</div>";
    //  unset($_SESSION['oznameni']);
    //}
    ?>
    <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
      <a class="navbar-brand" href="index.php">Navigace</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarsExampleDefault">
        <ul class="navbar-nav mr-auto">
          <li class="nav-item active">
            <a class="nav-link" href="index.php">Domů <span class="sr-only">(current)</span></a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="?stranka=kontakty">Kontakty</a>
          </li>
          <?php
            if(!isset($_SESSION['uzivatel_id']))
            {
          ?>
            <li class="nav-item">
              <a class="nav-link" href="?stranka=registrace">Registrace</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="?stranka=prihlaseni">Přihlášení</a>
            </li>
          <?php
            }
            if(isset($_SESSION['uzivatel_admin']))
            {
              if($_SESSION['uzivatel_admin']==1)
              {
          ?>
            <li class="nav-item">
              <a class="nav-link" href="?stranka=administrace">Administrace</a>
            </li>
          <?php
              }
          ?>
            <li class="nav-item">
              <a class="nav-link" href="?stranka=ucet">Můj účet</a>
            </li>
          <?php
            }
          ?>
        </ul>
        <form class="form-inline my-2 my-lg-0">
          <input class="form-control mr-sm-2" type="text" placeholder="Hledat" aria-label="Search">
          <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Hledat</button>
        </form>
        <?php
            if(isset($_SESSION['uzivatel_id'])){
              echo "<div class='bg-light p-2 ml-2'>";
              echo "Uživatel <strong>".ucfirst($_SESSION['uzivatel_jmeno'])."</strong> ";
              if($_SESSION['uzivatel_admin']==0){
                $pocetPolozek=Db::querySingle("select count(*) from kosik where idUzivatele=?",$_SESSION['uzivatel_id']);
                echo "<a href='?stranka=kosik' class='btn btn-success'>Košík $pocetPolozek</a> ";
              }
              echo "<a href='?odhlasit=true' class='btn btn-secondary'>Odhlásit</a>";
              echo "</div>";
            }
        ?>
      </div>
    </nav>

    <main role="main">

      <!-- Main jumbotron for a primary marketing message or call to action -->
      <div class="jumbotron">
        <div class="container">
          <h1 class="display-3">Náš obchod</h1>
          <p>Nakupujte výhodně, také jak jinak :-)</p>
        </div>
      </div>

      <div class="container">
        <!-- Example row of columns -->
        <div class="row">
          <div class="col-md-2">            
            <h2>Filtr</h2>
          </div>
          <div class="col-md-8">
          <?php
              if(isset($_GET['stranka'])){
                $stranka=$_GET['stranka'].".php";
                include $stranka;
              }
              else
                include('zbozi.php');
            ?>
          </div>
          <div class="col-md-2">
            <h2>Novinky</h2>
            <p>Nebo také reklamy</p>
          </div>
        </div>
        <hr>
      </div> <!-- /container -->

    </main>

    <footer class="container">
      <p>&copy; JardaShop 2021</p>
    </footer>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script>window.jQuery || document.write('<script src="../../../../assets/js/vendor/jquery-slim.min.js"><\/script>')</script>
    <script src="../../../../assets/js/vendor/popper.min.js"></script>
    <script src="../../../../dist/js/bootstrap.min.js"></script>
  </body>
</html>
