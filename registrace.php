<h2>Registrace</h2>
<?php
    if (isset($zprava))
        echo('<p class="alert alert-danger p-1">' . $zprava . '</p>');
?>

<form method="post">
    Jméno<br />
    <input type="text" name="jmeno" /><br />
    Heslo<br />
    <input type="password" name="heslo" /><br />
    Heslo znovu<br />
    <input type="password" name="heslo_znovu" /><br />
    Zadejte aktuální rok (antispam)<br />
    <input type="text" name="rok" /><br />
    <input type="submit" value="Registrovat" name="registrace" />
</form>