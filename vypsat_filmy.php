<?php
require 'db.php';
$sql = "SELECT * FROM filmy";
$vypis = $db->query($sql);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>VYPSAT FILMY</title>
</head>

<body>
<div class="container" style="margin-top: 50px">
    <?php
    if ($vypis->rowCount() > 0) {
        echo "<table><tr><th>Název filmu</th><th>Délka filmu</th><th>Promítací časy</th></tr>";
        while ($data = $vypis->fetch(PDO::FETCH_ASSOC)) {
            //todo - podmínka přihlášení pro tlačítko na zobrazení časů promítání
            echo "<tr>
                <td>" . $data['nazev'] . "</td>
                <td>" . $data['delka_filmu'] . " min</td>
                <td><form action='promitaci_casy.php' method='post/get'>
                <input type='hidden' name='id_filmu' id='id_filmu' value='" . $data['id'] . "' />
                <input type='submit' value='Zobrazit'/>
                </form></td>
              </tr>";
        }
    } else {
        echo "Nenašlo to ani jeden řádek s Daty";
    }
    echo "</table>";
    ?>
    <br><br>
    <a href="index.php">Zpět na index</a>
</div>
</body>

</html>