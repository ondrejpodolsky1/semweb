<?php
require 'db.php';
$id_filmu =$_GET["id_filmu"];
$sql = "SELECT * FROM promitani WHERE film_id=".$id_filmu."";
$vypis = $db->query($sql);


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Promítací časy filmu - doplnit</title>
</head>
<body>
<?php
    if ($vypis->rowCount()> 0) {
        echo "<table><tr><th>Datum představení</th><th>Čas představení</th></tr>";
        while($data = $vypis->fetch( PDO::FETCH_ASSOC )) {
        echo "<tr>
                <td>".$data['datum']."</td>
                <td>".$data['cas']."</td>
                <td><form action='rezervace.php' method='post/get'>
                <input type='hidden' name='id_filmu' id='id_promitani' value='".$data['id']."' />
                <input type='submit' value='Vytvořit rezervaci'/>
                </form></td>
              </tr>";
        }
    } else {
        echo "U Tohoto filmu není ani jeden promítací čas";
    }
    echo "</table>";
    ?>
<a href="vypsat_filmy.php">Zpět na filmy</a>
</body>
</html>