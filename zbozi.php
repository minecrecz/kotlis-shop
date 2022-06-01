<h2>Nabídka obchodu</h2>
<?php
    if(isset($_SESSION['uzivatel_admin'])){
        if($_SESSION['uzivatel_admin']==0)
        {
            ZobrazZbozi(2);
        }
        else{
            ZobrazZbozi(3);
        }
    }
    else{
        ZobrazZbozi(3);
    }
    
?>