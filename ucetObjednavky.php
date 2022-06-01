<?php
if(!isset($_SESSION['uzivatel_id'])){
    $zprava="Nejsi přihlášený";
}

if (isset($zprava))
    echo('<p class="alert alert-danger p-1">'.$zprava.'</p>');
else{
    if(isset($_GET['idDetailObjednavky'])){
        $idObjednavky=$_GET['idDetailObjednavky'];
        if($_SESSION['uzivatel_admin']==1){
            $existujeObjednavka=Db::queryOne("SELECT * FROM faktury WHERE id=?",$idObjednavky);
        }
        else{
            $existujeObjednavka=Db::queryOne("SELECT * FROM faktury WHERE id=? AND idUzivatele=?",$idObjednavky,$_SESSION['uzivatel_id']);
        }
        if($existujeObjednavka){
            echo "<h3>Objedávka číslo $idObjednavky</h3>";
            ZobrazJednuObjednavku($existujeObjednavka['idUzivatele'],$idObjednavky);
        }
        else{
            echo('<p class="alert alert-warning p-1">Objednávka č. '.$idObjednavky.' neexistuje!</p>');
        }
    }
    else{
        echo "<h3>Moje objednávky</h3>";
        ZobrazObjednavky($_SESSION['uzivatel_admin']);
    }
}