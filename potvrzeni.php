<?php
session_start();
require 'db.php';

if (($_SESSION['admin'] == 'ano' || $_SESSION['normal-prihlasen'] == 'ano' && $_SESSION['glogin'] == 'ne') ) {
    $stmt = $db->prepare("SELECT email FROM uzivatel WHERE id = ? LIMIT 1");
    $stmt->execute(array($_SESSION['id_uziv']));
    $email = (string)$stmt->fetchColumn();

    $stmt = $db->prepare("SELECT id_promitani FROM rezervace WHERE id = ? LIMIT 1");
    $stmt->execute(array($_SESSION['id_rezervace']));
    $id_film = (string)$stmt->fetchColumn();
    var_dump($id_film);
} else if ($_SESSION['normal-prihlasen'] == 'ano' && $_SESSION['glogin'] == 'ano') { 
    
    $email = $_SESSION['email'];
} else {
    header('Location: prihlaseni.php');
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
/*
    $pro      =$email;
    $predmet = "Rezervace sedadel v kině";
    $zprava = 'Dobrý den informujeme Vás o rezervaci míst v kině na film'.$film.'';
    $hlavicka = 'Od: on.podolsky@gmail.com' . "\r\n" .
    'Odpovědět: on.podolsky@gmail.com' . "\r\n";

    mail($pro, $predmet, $zprava, $hlavicka);
    */
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
                
                ?>
                <a href="edit_rezervace.php">Zpět</a>
            </div>
        </div>
    </div>

</body>

</html>