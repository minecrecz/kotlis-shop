<?php
if(isset($_SESSION['uzivatel_admin']))
    {
      if($_SESSION['uzivatel_admin']==1)
      {
?>
<h4 class="card-title">Administrace zboží</h4>
<?php
//mazání zboží
if(isset($_GET['idSmaz'])){
  $id=$_GET['idSmaz'];
  echo "<div class='alert alert-danger p-1'>";
  echo "Opravdu chcete smazat zboží č. <strong>$id</strong>?";
  echo " <a class='btn btn-danger btn-sm' href='?stranka=administrace&admin=zbozi&idSmazAno=$id'>Ano</a>";
  echo " <a class='btn btn-primary btn-sm' href='?stranka=administrace&admin=zbozi&idSmazNe=$id'>Ne</a>";
  echo "</div>";
}

if(isset($_GET['idSmazAno'])){
  $mazani=Db::query("delete from zbozi where id=?",$_GET['idSmazAno']);
  $typ=($mazani==1 ? "warning" : "info");
  echo "<div class='alert alert-$typ p-1'>";
  $smazano=($mazani==1 ? "byla" : "nebyla");
  echo "Položka ".$_GET['idSmazAno']." $smazano smazána.";
  echo "</div>";
}

if(isset($_GET['idSmazNe'])){
  echo "<div class='alert alert-warning p-1'>";
  echo "Položka ".$_GET['idSmazNe']." nebyla smazána.";
  echo "</div>";
}

//přidání zdoží
if(isset($_POST['pridatZbozi'])){
  $chyba="";
  if($_POST['nazev']=="")
    $chyba.="Zadejte název zboží. ";
  if($_POST['cena']<=0 || $_POST['cena']=="")
    $chyba.="Zadejte cenu zboží > 0. ";
  if($_POST['pocet']<0 || $_POST['pocet']=="")
    $chyba.="Zadejte počet zboží >=0.";
  if($chyba!=""){
    echo "<div class='alert alert-warning p-1'>$chyba</div>";
  }
  else{
    $aktivni = isset($_POST['aktivni']) ? 1 : 0;
    $pridani=Db::query("insert into zbozi 
                        (nazev, cena, ks, obrazek, aktivni) 
                        values (?,?,?,?,?)"
                        ,$_POST['nazev'], $_POST['cena'], $_POST['pocet'], $_POST['obrazek'], $aktivni);
    if($pridani==1){
      echo "<div class='alert alert-info p-1'>";
      echo "Položka byla přidána.";
      echo "</div>";
    }
    else{
      echo "<div class='alert alert-warning p-1'>";
      echo "Položka nebyla přidána.";
      echo "</div>";
    }
  }
}

//editace zboží
if(isset($_POST['editovatZbozi'])){
  $chyba="";
  if($_POST['nazevEdit']=="")
    $chyba.="Zadejte název zboží. ";
  if($_POST['cenaEdit']<=0 || $_POST['cenaEdit']=="")
    $chyba.="Zadejte cenu zboží > 0. ";
  if($_POST['pocetEdit']<0 || $_POST['pocetEdit']=="")
    $chyba.="Zadejte počet zboží >=0.";
  if($chyba!=""){
    echo "<div class='alert alert-warning p-1'>$chyba</div>";
  }
  else{
    $aktivni = isset($_POST['aktivniEdit']) ? 1 : 0;
    $editace=Db::query("update zbozi set nazev=?, cena=?, ks=?, obrazek=?, aktivni=? where id=?"
                        ,$_POST['nazevEdit'], $_POST['cenaEdit'], $_POST['pocetEdit'], $_POST['obrazekEdit'], $aktivni, $_POST['idEdit']);
    if($editace==1){
      echo "<div class='alert alert-info p-1'>";
      echo "Položka ".$_POST['idEdit']." byla změněna.";
      echo "</div>";
    }
    else{
      echo "<div class='alert alert-warning p-1'>";
      echo "Položka ".$_POST['idEdit']." nebyla změněna.";
      echo "</div>";
    }
  }
}

if(isset($_GET['idEdit'])){
  $zbozi=Db::queryOne("select * from zbozi where id=?",$_GET['idEdit']);
  $checked = $zbozi['aktivni']==1 ? " checked" : "";
?>
  <div class="border p-2 mb-3 bg-light">
    <h3>Editace zboží <?=$zbozi['id']?></h3>
    <form method="POST" action="?stranka=administrace&admin=zbozi">
      <div class="form-row">
          <input type="hidden" value="<?=$zbozi['id']?>" name="idEdit">
          <div class="form-group col">
            <label for="nazevEdit">Název</label>
            <input type="text" class="form-control" id="nazevEdit" name="nazevEdit" placeholder="Název zboží" value="<?=$zbozi['nazev']?>">
          </div>
          <div class="form-group col">
            <label for="cenaEdit">Cena</label>
            <input type="number" class="form-control" id="cenaEdit" name="cenaEdit" placeholder="Cena zboží" value="<?=$zbozi['cena']?>">
          </div>
          <div class="form-group col">
            <label for="cenaEdit">Počet</label>
            <input type="number" class="form-control" id="pocetEdit" name="pocetEdit" placeholder="Počet kusů zboží" value="<?=$zbozi['ks']?>">
          </div>
        </div>
        <div class="form-row">
          <div class="form-group col-10">
            <label for="obrazekEdit">Obrázek</label>
            <input type="file" class="form-control" id="obrazekEdit" name="obrazekEdit" value="" value="<?=$zbozi['obrazek']?>">
          </div>
          <div class="form-group col">
            <label for="aktivniEdit">Aktivní</label>
            <input type="checkbox" <?=$checked?> class="form-control" id="aktivniEdit" name="aktivniEdit" value="100">
          </div>
            <button type="submit" class="btn btn-primary btn-block" name="editovatZbozi">Editovat</button>
        </div>
      </form>
  </div>
<?php
}
?>

<div class="card p-2">
    <div class="card-header" id="headingThree">
      <h5 class="mb-0">
        <button class="btn btn-success collapsed" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
          Přidání zboží
        </button>
      </h5>
    </div>
    <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordion">
      <form method="POST">
      <div class="form-row">
          <div class="form-group col">
            <label for="nazev">Název</label>
            <input type="text" class="form-control" id="nazev" name="nazev" placeholder="Název zboží">
          </div>
          <div class="form-group col">
            <label for="cena">Cena</label>
            <input type="number" class="form-control" id="cena" name="cena" placeholder="Cena zboží">
          </div>
          <div class="form-group col">
            <label for="cena">Počet</label>
            <input type="number" class="form-control" id="pocet" name="pocet" placeholder="Počet kusů zboží">
          </div>
        </div>
        <div class="form-row">
          <div class="form-group col-10">
            <label for="obrazek">Obrázek</label>
            <input type="file" class="form-control" id="obrazek" name="obrazek" value="">
          </div>
          <div class="form-group col">
            <label for="aktivni">Aktivní</label>
            <input type="checkbox" checked class="form-control" id="aktivni" name="aktivni" value="100">
          </div>
            <button type="submit" class="btn btn-primary btn-block" name="pridatZbozi">Přidat</button>
        </div>
      </form>
    </div>
  </div>


<?php
  ZobrazZbozi(1);
      }
    }
?>