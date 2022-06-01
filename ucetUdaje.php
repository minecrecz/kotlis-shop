<?php
if(!isset($_SESSION['uzivatel_id'])){
    $zprava="Nejsi přihlášený";
}

if (isset($zprava))
    echo('<p class="alert alert-danger p-1">'.$zprava.'</p>');
else{
    echo "<h3>Moje údaje</h3>";
}