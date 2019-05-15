<?php
require 'db.php';
session_start();

?>

<!DOCTYPE html>
<html> 
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Welcome</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="">
    </head>
    <body>
    <!--
        Výchozí stránka s rozcestníkem
    -->
       <h1>
       VÍTEJTE, VYBERTE CO CHCETE UDĚLAT<br>
       </h1>
       
        <?php if(isset($_SESSION['normal-prihlasen'])){
            $id = $_SESSION['id_uziv'];
            $stmt = $db->prepare("SELECT * FROM uzivatel WHERE id=:id");
            $stmt->execute(['id' => $id]); 
            $data = $stmt->fetchAll();
            // and somewhere later:
            foreach ($data as $row) {
                echo "Přihlášený uživatel :  ".$row['jmeno']."<br>";
                echo "<a href='odhlaseni.php'>odhlásit se</a>";
            }
            
           
        
        
        }else{?>
        <h3>
       Pro plnohodnotné využívání aplikace doporučujeme se přihlásit, pokud u nás nemáte účet tak se zaregistrovat.
       </h3>
        <a href="vypsat_filmy.php">Zobrazení představení</a>
        <a href="prihlaseni.php">Přihlásit se </a>
        <a href="registrace.php">Registrovat </a>
        <?php
        }
        ?>
    </body>
</html>