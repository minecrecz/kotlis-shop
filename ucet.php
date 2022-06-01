<?php
if(!isset($_SESSION['uzivatel_id'])){
    $zprava="Nejsi přihlášený";
}

if (isset($zprava))
    echo('<p class="alert alert-danger p-1">'.$zprava.'</p>');
else{
    echo "<h2>Účet uživatele <strong>".ucfirst($_SESSION['uzivatel_jmeno'])."</strong></h2>";
    ?>
    <div class="card text-center">
        <div class="card-header">
            <ul class="nav nav-tabs card-header-tabs">
                <li class="nav-item">
                    <a class="nav-link
                    <?php
                        if(isset($_GET['ucetObsah'])){
                            if($_GET['ucetObsah']=="objednavky")
                                echo " active";
                        }
                        else
                            echo " active";
                    ?>
                    " href="index.php?stranka=ucet&ucetObsah=objednavky">Objednávky</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link
                    <?php
                        if(isset($_GET['ucetObsah'])){
                            if($_GET['ucetObsah']=="udaje")
                                echo " active";
                        }
                    ?>" href="index.php?stranka=ucet&ucetObsah=udaje">Moje údaje</a>
                </li>
            </ul>
        </div>
        <div class="card-body">
            <?php
                if(isset($_GET['ucetObsah'])){
                    switch ($_GET['ucetObsah']){
                        case "objednavky":
                            include "ucetObjednavky.php";
                            break;
                        case "udaje":
                            include "ucetUdaje.php";
                            break;
                        default:
                            include "ucetObjednavky.php";
                            break;
                    }
                }
                else
                    include "ucetObjednavky.php"; 
            ?>
        </div>
    </div>
<?php
}