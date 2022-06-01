<?php
if(isset($_SESSION['uzivatel_admin']))
    {
      if($_SESSION['uzivatel_admin']==1)
      {
?>
<div class="card text-center">
    <div class="card-header">
        <ul class="nav nav-tabs card-header-tabs">
            <li class="nav-item">
                <a class="nav-link
                <?php
                    if(isset($_GET['admin'])){
                        if($_GET['admin']=="uzivatel")
                            echo " active";
                    }
                    else
                        echo " active";
                ?>
                " href="index.php?stranka=administrace&admin=uzivatel">Uživatelé</a>
            </li>
            <li class="nav-item">
                <a class="nav-link
                <?php
                    if(isset($_GET['admin'])){
                        if($_GET['admin']=="zbozi")
                            echo " active";
                    }
                ?>" href="index.php?stranka=administrace&admin=zbozi">Zboží</a>
            </li>
            <li class="nav-item">
                <a class="nav-link
                <?php
                    if(isset($_GET['admin'])){
                        if($_GET['admin']=="system")
                            echo " active";
                    }
                ?>" href="index.php?stranka=administrace&admin=system">Systém</a>
            </li>
        </ul>
    </div>
    <div class="card-body">
        <?php
            if(isset($_GET['admin'])){
                switch ($_GET['admin']){
                    case "uzivatel":
                        include "administraceUzivatel.php";
                        break;
                    case "zbozi":
                        include "administraceZbozi.php";
                        break;
                    case "system":
                        include "administraceSystem.php";
                        break;
                    default:
                        include "administraceZbozi.php";
                        break;
                }
            }
            else
                include "administraceUzivatel.php"; 
        ?>
    </div>
</div>
<?php
      }     
    }
?>