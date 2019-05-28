<?php
session_start();
require 'db.php';



if ($_SESSION['normal-prihlasen'] == 'ano' || $_SESSION['admin'] == 'ano' || $_SESSION['glogin'] == 'ano') {
    $id_filmu = $_GET["id_filmu"];
    $sql = "SELECT * FROM promitani WHERE film_id=" . $id_filmu . "";
    $vypis = $db->query($sql);
 } else {
    header('Location: prihlaseni.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Promítací časy filmu - doplnit</title>
</head>

<body>
    <div class="container" style="margin-top: 100px">
        <div class="row justify-content-center">
            <div class="col-md-6 col-offset-3" align="center">
                <?php
                if ($vypis->rowCount() > 0) {
                    echo "<table><tr><th>Datum představení</th><th>Čas představení</th></tr>";
                    while ($data = $vypis->fetch(PDO::FETCH_ASSOC)) {
                        echo "<tr>
                <td>" . $data['datum'] . "</td>
                <td>" . $data['cas'] . "</td>
                <td><form action='rezervace.php' method='post/get'>
                <input type='hidden' name='id_promitani' id='id_promitani' value='" . $data['id'] . "' />
                <input type='hidden' name='cas_promitani' id='cas_promitani' value='" . $data['cas'] . "' />
                <input type='submit' value='Vytvořit rezervaci'/>
                </form></td>
              </tr>";
              $_SESSION['id_promitani'] = $data['id'];
              

                    }
                } else {
                    echo "U Tohoto filmu není ani jeden promítací čas";
                }
                echo "</table>";
                ?>
                <br><br>
                <?php
                if ($_SESSION["admin"] == "ano") {
                    echo "<a href='pridani_promitani.php'>Přidání promítacího času</a><br><br>";
                }
                ?>

                
                <a href="vypsat_filmy.php">Zpět na filmy</a>
            </div>
        </div>
    </div>

</body>

</html>