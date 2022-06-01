<h2>Přihlášení</h2>
<?php
    if (isset($zprava))
        echo('<p class="alert alert-danger p-1">' . $zprava . '</p>');
?>

<form method="post">
    Jméno<br />
    <input type="text" name="jmeno" /><br />
    Heslo<br />
    <input type="password" name="heslo" /><br />
    <input type="submit" value="Přihlásit" name="prihlaseni" />
</form>