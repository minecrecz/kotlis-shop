<?php
if(isset($_SESSION['uzivatel_admin']))
    {
      if($_SESSION['uzivatel_admin']==1)
      {
?>
<h4 class="card-title">Administrace systému</h4>
<p class="card-text">Zde budeme administrovat systém</p>
<?php
      }
    }
?>