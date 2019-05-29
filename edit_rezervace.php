<?php
session_start();
require 'db.php';

if ($_SESSION['normal-prihlasen'] == 'ano' || $_SESSION['admin'] == 'ano' || $_SESSION['glogin'] == 'ano') {
    $sql = "SELECT * FROM rezervace WHERE id_uzivatel=" . $_SESSION['id_uziv']. "";
    $vypis = $db->query($sql);
    
 } else {
    header('Location: prihlaseni.php');
    exit();
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $_SESSION['edit'] = $_POST['id_rezervace'];
    if (isset($_POST['Smazat'])) {
        $sql = "DELETE FROM rezervace WHERE id='" . $_SESSION['edit']. "'";
        $proved = $db->query($sql);  
        header('Location: edit_rezervace.php');
    }
    if (isset($_POST['potvrdit'])) {
        
        header("Location: potvrzeni.php");
    }
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Editace rezervací</title>
</head>

<body>
    <div class="container" style="margin-top: 100px">
        <div class="row justify-content-center">
            <div class="col-md-6 col-offset-3" align="center">
            <?php
                if ($vypis->rowCount() > 0) {
                    echo "<table>
                    <tr><th>Datum představení</th>
                    <th>Čas představení</th>
                    <th>Místa</th></tr>";
                    while ($data = $vypis->fetch(PDO::FETCH_ASSOC)) {
                        $mista=json_decode($data['mista']);
                        echo "<tr>
                <td>" . $data['datum_promitani'] . "</td>
                <td>" . $data['cas_promitani'] . "</td>
                <td>";
                        foreach($mista as $misto){
                            echo $misto."\n";
                        }
                echo "</td>
                <td><form action='edit_rezervace.php' method='post'>
                <input type='hidden' name='id_rezervace' id='id_rezervace' value='" . $data['id'] . "' />
                <input type='submit' name='Smazat' value='Smazat'/>
                
                </form></td>
              </tr>";
                //<input type='submit' name='potvrdit' value='Potvrdit'/>
                    }
                   
                } else {
                    echo "Nemáte žádnou rezervaci";
                }
                echo "</table>";
                ?>
                <a href="vypsat_filmy.php">Zpět</a>
            </div>
        </div>
    </div>

</body>

</html>