<?php
function ZobrazZbozi($zobrazeni){
    //definice parametru $zobrazeni
    //1 - administrace
    //2 - přihlášený uživatel
    //3 - nepřihlášený uživatel
    //4 - košík
?>
<div class=" table-responsive">
<table class="table table-striped">
  <thead>
    <tr>
      <th scope="col">Id</th>
      <th scope="col">Název</th>
      <th scope="col">Cena (Kč)</th>
      <th scope="col">Počet (ks)</th>
      <th scope="col">Obrázek</th>
      <?php 
      if($zobrazeni==1){
      ?>
        <th scope="col">Aktivní</th>
        <th scope="col">Mazání</th>
        <th scope="col">Editace</th>
      <?php 
        }
      else
      if($zobrazeni==2){
      ?>
        <th scope="col">Počet</th>
        <th scope="col">Košík</th>
      <?php }
      else
      if($zobrazeni==4){
        ?>
          <th scope="col" class="text-center">Odebrat</th>
        <?php } ?>
    </tr>
  </thead>
  <tbody>
<?php
    //zobrazení zboží
    switch($zobrazeni){
        case 1:
            $zbozi=Db::queryAll("select * from zbozi");
            break;
        case 4:
            $zbozi=Db::queryAll("SELECT zbozi.id as id, zbozi.nazev as nazev, zbozi.cena as cena, zbozi.obrazek as obrazek, zbozi.ks as ksNaSklade, 
                                        kosik.idZbozi, kosik.idUzivatele, kosik.ks as ks 
                                FROM kosik INNER JOIN zbozi ON kosik.idZbozi = zbozi.id AND kosik.idUzivatele=?
                                 ORDER BY zbozi.id ASC",$_SESSION['uzivatel_id']);
            break;
        default:
            $zbozi=Db::queryAll("select * from zbozi where aktivni=1");
            break;
    }
        
    foreach($zbozi as $z){
      $id=$z['id'];
      echo "<tr>";
      echo "<th scope='row'>$id</th>";
      echo "<td>".ucfirst($z['nazev'])."</td>";
      echo "<td>".number_format($z['cena'],0,","," ").",-</td>";
      echo "<td>".$z['ks']."</td>";
      echo "<td>-</td>";
      if($zobrazeni==1){
        $checked = ($z['aktivni']==1 ? " checked" : "");
        echo "<td><input type='checkbox' disabled $checked></td>";
        echo "<td><a class='btn btn-danger' href='?stranka=administrace&admin=zbozi&idSmaz=$id'>Smaž $id</a></td>";
        echo "<td><a class='btn btn-info' href='?stranka=administrace&admin=zbozi&idEdit=$id'>Edituj $id</a></td>";
      }
      else
      if($zobrazeni==2){
        echo "<form method='post' action='?stranka=kosik'>";
        echo "<td><input type='number' name='kosikKs' value='1' min='1' max='".$z['ks']."'>";
        echo "<input type='hidden' value='$id' name='kosikId'></td>";
        echo "<td><button class='btn btn-info' name='kosikPridat'>Přidat $id</button></td>";
        echo "</form>";
      }
      else
      if($zobrazeni==4){
        echo "<td class='text-center'><a class='btn btn-danger' href='?stranka=kosik&idSmazKosik=$id'>x</a></td>";
      }
      echo "</tr>";
    }
    if($zobrazeni==4 && isset($z)){
        echo "<tr>";
        echo "<td colspan='6' class='text-right'><form action='index.php' method='POST'><button type='submit' class='btn btn-success' name='kosikObjednat'>Závazně objednat</button></form></td>";
        echo "</tr>";
    }
?>
  </tbody>
</table>
</div>
<?php
    if($zobrazeni==4){
       echo "<div><a class='btn btn-primary btn-block' href='index.php'>Pokračovat v nákupu</a></div>"; 
    }
}

function ZobrazObjednavky($admin){
  //použijeme proměnnou $_SESSION['uzivatel_admin']

?>
<div class=" table-responsive">
<table class="table table-striped">
  <thead>
    <tr>
      <th scope="col">Id</th>
      <?php 
      if($admin==1){
      ?>
      <th scope="col">Uživatel</th>
      <?php 
        }
      ?>
      <th scope="col">Datum</th>
      <th scope="col">Stav</th>
      <th scope="col">Detail</th>
      <?php 
      if($admin==1){
      ?>
      <th scope="col">Změnit stav</th>
      <th scope="col">Odebrat</th>
      <?php 
        }
      ?>
    </tr>
  </thead>
  <tbody>
<?php
  $filtr=($admin==1) ? "" : " where idUzivatele=".$_SESSION['uzivatel_id'];
  $objednavky=Db::queryAll("SELECT * FROM faktury$filtr");
  foreach($objednavky as $o){
    $id=$o['id'];
    echo "<tr>";
    echo "<th scope='row'>$id</th>";
    echo ($admin==1) ? "<td>".$o['idUzivatele']."</td>" : "";
    echo "<td>".date_format(date_create($o['datum']),"d. m. Y")."</td>";
    echo "<td>".$o['stav']."</td>";
    echo "<td><a class='btn btn-info' href='?stranka=ucet&ucetObsah=objednavky&idDetailObjednavky=$id'>Detail $id</a></td>";
    if($admin==1){
      echo "<td><a class='btn btn-info' href='#'>Změnit $id</a></td>";
      echo "<td><a class='btn btn-danger' href='#'>Smaž $id</a></td>";
    }
    echo "</tr>";
  }
?>
</tbody>
</table>
</div>
<?php
}

function ZobrazJednuObjednavku($idUzivatele,$idObjednavky){
  $objednavka=Db::queryAll("SELECT faktury.datum as datum, faktury.stav as stav, zbozi.nazev as nazev, radekFaktury.cena as cena, radekFaktury.ks as ks 
                            FROM radekFaktury  
                            INNER JOIN zbozi ON radekFaktury.idFaktury=? AND zbozi.id=radekFaktury.idZbozi  
                            INNER JOIN faktury ON faktury.id=?",
                          $idObjednavky,$idObjednavky);
  echo "<p class='text-left'>";
  echo "<strong>Vytvoření objednávky: </strong>".date_format(date_create($objednavka[0]['datum']),"d. m. Y")."<br>";
  echo "<strong>Stav objednávky: </strong>".$objednavka[0]['stav']."<br>";
  if($_SESSION['uzivatel_admin']==1){
    $jmeno=Db::querySingle("SELECT jmeno FROM uzivatel WHERE id=?",$idUzivatele);
    echo "<strong>Objednal uživatel: </strong>".$jmeno."<br>";
  }
  echo "<ul class='text-right list-group'>";
  $cenaCelkem=0;
  $i=0;
  foreach($objednavka as $o){
    $cenaZbozi=$o['ks']*$o['cena'];
    $cenaCelkem+=$cenaZbozi;
    $striped=(($i++)%2==0) ? " list-group-item-info" : "";
    echo "<li class='list-group-item$striped'><strong>".$o['nazev']."</strong> - ".$o['ks']." x "
    .number_format($o['cena'],0,","," ").",- Kč = "
    .number_format($cenaZbozi,0,","," ").",- Kč</li>";
  }
  echo "<li class='list-group-item list-group-item-primary'><strong>Celkem:</strong> "
        .number_format($cenaCelkem,0,","," ").",- Kč</li>";
  echo "</ul>";
  echo "</p>";
}