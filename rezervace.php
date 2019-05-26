<?php
require 'db.php';
session_start();

$id_misto = 0;
if ($_SESSION['normal-prihlasen'] == 'ano' || $_SESSION['admin'] == 'ano' || $_SESSION['glogin'] == 'ano') { } else {
    header('Location: prihlaseni.php');
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $vybrana_mista=array();
    $chyby = "";
    if (!empty($_POST)) {
        if(empty($_POST['mista'])){
            $chyby .= "Vyberte místa, která chcete rezervovat.";
        }
    }
    if (isset($_POST['rezervovat'])) { //to run PHP script on submit
        if (!empty($_POST['mista'])) {
            // Loop to store and display values of individual checked checkbox.
            foreach ($_POST['mista'] as $vybrane) {
                $vybrana_mista[] = $vybrane;
            }
        }
    } 
    if(empty($chyby)){
        $id_uzivatel = $_SESSION['id_uziv'];
        $id_promitani = $_SESSION['id_promitani'];
        $mista = $vybrana_mista;
        $mista_serializovana = serialize($mista);
        $stmt = $db->prepare("INSERT INTO rezervace(id_uzivatel, id_promitani, mista) VALUES(?,?,?)");
        $stmt->execute(array($id_uzivatel, $id_promitani, $mista_serializovana));
    }
}

/*
$array = array("my", "litte", "array", 2);

$serialized_array = serialize($array);
$unserialized_array = unserialize($serialized_array);

var_dump($serialized_array);// gives back a string, perfectly for db saving!
var_dump($unserialized_array); // gives back the array again
*/



//TODO - kontrola jestli film_id, které dostaneme z GET existuje - pokud ne "fuckoff" pokud ano pokračuj dále
//Zobrazení z tabulky v db - rezervace míst již obsazená místa zakreslení do tabulky - kontrola v php
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>REZERVACE</title>
</head>

<body>
    <div class="container" style="margin-top: 50px">


        <div class="row justify-content-center">
            <div class="col-md-6 col-offset-3" align="center">
                <h1>
                    REZERVACE MÍSTA V KINĚ<br>
                </h1>
                <?php

                echo "<form method='post'><table class='table table-bordered'><br />";

                for ($radek = 0; $radek < 5; $radek++) {
                    echo "<tr>";
                    for ($sloupec = 0; $sloupec < 5; $sloupec++) {
                        echo "<td><input type='checkbox' name='mista[]' value='" . ($id_misto = $id_misto + 1) . "'> " . ($id_misto) . " </input></td>";
                    }
                    echo "</tr>";
                }
                echo "</table>";
                echo "<input type='submit' class='btn-primary' name='rezervovat' value='Rezervovat'/>";
                echo "</form>";
                                        
                
            
                ?>
                  <?php
                    if (!empty($chyby)) {
                        echo '<div class="error">' . $chyby . '</div>';
                    }
                    ?>
                <a href="vypsat_filmy.php">Zpět na filmy</a>
            </div>
            <!-- konec COL MD 6-->
        </div>
        <!-- konec row justify-->
    </div>
    <!-- konec kontejneru-->
</body>

</html>