<?php
    if(isset($_SESSION['uzivatel_admin']))
    {
      if($_SESSION['uzivatel_admin']==1)
      {
        echo "<h1>Administrace</h1>";
        include "administraceObsah.php";
      }
      else
      {
        $zprava="Nejsi admin";
      }
    }
    else
        $zprava="Nejsi přihlášený";

   if (isset($zprava))
        echo('<p class="alert alert-danger p-1">' . $zprava . '</p>');