<?php
require 'db.php';
session_start();

?>

<!DOCTYPE html>
<html> 
    <head>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
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
    <div class="container" style="margin-top: 100px">
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
                echo "<a href='vypsat_filmy.php'>Zobrazení představení</a><br>";
                echo "<a href='odhlaseni.php'>odhlásit se</a>";
            }
            
           
        
        
        }else{?>
        <h3>
       Pro plnohodnotné využívání aplikace doporučujeme se přihlásit, pokud u nás nemáte účet tak se zaregistrovat.
       </h3>
        <a href="vypsat_filmy.php">Zobrazení představení</a><br>
        <a href="prihlaseni.php">Přihlásit se </a><br>
        <a href="registrace.php">Registrovat </a>
        <?php
        }
        ?>
        </div>

        <?php
    
        
        ?>
    </body>
</html>