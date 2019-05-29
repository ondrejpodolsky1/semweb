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
    <div class="container" style="margin-top: 50px" align="center">
        <h1>
            VÍTEJTE<br>
        </h1>
        <h3>
            NA TĚCHTO STRÁNKÁCH NALEZNETE MOU SEMESTRÁLNÍ PRÁCI NA PŘEDMĚT 4IZ278 WEBOVÉ TECHNOLOGIE
        </h3>
        <div class="row justify-content-center">
        <div class="col-md-6 col-offset-3" align="center">
            <?php if (isset($_SESSION['normal-prihlasen']) && $_SESSION['glogin'] == 'ne') {
                $id = $_SESSION['id_uziv'];
                $stmt = $db->prepare("SELECT * FROM uzivatel WHERE id=:id");
                $stmt->execute(['id' => $id]);
                $data = $stmt->fetchAll();
                // and somewhere later:
                foreach ($data as $row) {
                    echo "Přihlášený uživatel :  " . $row['jmeno'] . "<br>";
                    echo "<a class='btn btn-primary btn-lg btn-block' style='width:400px' href='vypsat_filmy.php'>Zobrazení představení</a><br>";
                    echo "<a class='btn btn-outline-danger btn-block' style='width:400px' href='odhlaseni.php'>odhlásit se</a>";
                }
            } else if (isset($_SESSION['glogin']) && $_SESSION['glogin'] == 'ano') {

                echo "Přihlášený uživatel: " . $_SESSION['gjmeno'] . " " . $_SESSION['gprijmeni'] . " <br>";
                echo "<a class='btn btn-primary btn-lg btn-block' style='width:400px' href='vypsat_filmy.php'>Zobrazení představení</a><br>";
                echo "<a class='btn btn-outline-danger btn-block' style='width:400px' href='odhlaseni.php'>Odhlásit se</a>";
            } else { ?>

                <a class='btn btn-primary btn-lg btn-block' style='width:400px' role='button' href="vypsat_filmy.php">Zobrazení představení</a><br>
                <a class='btn btn-outline-secondary btn-block' style='width:400px' href="prihlaseni.php">Přihlásit se...</a><br>
                <a class='btn btn-outline-success btn-block' style='width:400px' href="registrace.php">Registrovat se...</a>
            <?php
        }
        ?>
         </div>
        <!-- konec COL MD 6-->
        </div>
        <!-- konec row justify-->
    </div>
    <!-- konec kontejneru-->

</body>

</html>