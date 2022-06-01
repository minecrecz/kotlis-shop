<?php
if(!isset($_SESSION['uzivatel_id'])){
    $zprava="Nejsi přihlášený";
}
else
if($_SESSION['uzivatel_admin']==1){
    $zprava="Nemůžeš nakupovat";
}

if (isset($zprava))
    echo('<p class="alert alert-danger p-1">'.$zprava.'</p>');
else
if(isset($_SESSION['uzivatel_id'])){
    //vložení zboží do košíku
    if(isset($_POST['kosikPridat'])){
        $zbozivKosiku=Db::query("select * from kosik where idZbozi=? and idUzivatele=?",$_POST['kosikId'],$_SESSION['uzivatel_id']);
        if($zbozivKosiku==1){
            echo('<p class="alert alert-warning p-1">Zboží '.$_POST['kosikId'].' je již v košíku vloženo.</p>');
        }
        else{
            $vlozeni=Db::query(" insert into kosik 
                        (idUzivatele, idZbozi, ks) 
                        values (?,?,?)",
                        $_SESSION['uzivatel_id'],
                        $_POST['kosikId'],
                        $_POST['kosikKs']);
            if($vlozeni==1){
                echo('<p class="alert alert-success p-1">Zboží '.$_POST['kosikId'].' bylo vloženo do košíku.</p>');
                header('Location: index.php?stranka=kosik');
                exit();
            }
            else{
                echo('<p class="alert alert-warning p-1">Zboží '.$_POST['kosikId'].' nebylo vloženo do košíku.</p>');
            }
        }
    }
    
    //smazání zboží z košíku
    if(isset($_GET['idSmazKosik'])){
        $mazani=Db::query("delete from kosik where idZbozi=? and idUzivatele=?",$_GET['idSmazKosik'],$_SESSION['uzivatel_id']);
        if($mazani==1){
            echo('<p class="alert alert-success p-1">Zboží '.$_GET['idSmazKosik'].' bylo z košíku odebráno.</p>');
            header('Location: index.php?stranka=kosik');
            exit();
        }
        else{
            echo('<p class="alert alert-warning p-1">Zboží '.$_GET['idSmazKosik'].' z košíku odebráno nebylo.</p>');
        }
    }

    echo "<h2>Košík uživatele ".ucfirst($_SESSION['uzivatel_jmeno'])."</h2>";
    ZobrazZbozi(4);
}