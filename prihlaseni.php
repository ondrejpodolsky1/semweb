<?php

require 'db.php';
require_once 'config.php';
$loginURL= $gClient->createAuthUrl();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = htmlspecialchars($_POST['email']);
    $heslo = htmlspecialchars($_POST['heslo']);
    $chyby = "";
    //ošetření formuláře
    if (!empty($_POST)) {
        if (empty($_POST['email'])) {
            $chyby .= 'Zadejte svůj email do formuláře.<br>';
        } else if (!(filter_var($email, FILTER_VALIDATE_EMAIL))) {
            $chyby .= 'Zadejte email ve správném formátu.<br>';
        } else if (strlen($heslo) < 5) {
            // heslo je moc krátké
            $chyby .= 'Zadejte dostatečně dlouhé heslo.<br>';
        }
    }
    $stmt = $db->prepare("SELECT * FROM uzivatel WHERE email = ? LIMIT 1");
    $stmt->execute(array($email));
    $prihlaseny = @$stmt->fetchAll()[0];

    if (password_verify($heslo, $prihlaseny["heslo"])) {
        $_SESSION['id_uziv'] = $prihlaseny['id'];
        $_SESSION['normal-prihlasen'] = 'ano';
        $_SESSION['admin'] = 'ne';

        if($prihlaseny["id"]==1){
            $_SESSION['admin'] = 'ano';
            $_SESSION['normal-prihlasen'] = 'ne';
        }
        header('Location: index.php');
    } else {
        $chyby .= "Nelze se přihlásit, zadejte znovu svoje přihlašovací údaje. Nemáte-li účet <a href='registrace.php'>zaregistrujte se</a>";
    }
}


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

        Stránka s přihlašovacím formulářem
    -->
    <div class="container" style="margin-top: 100px">
        <div class="row justify-content-center">
            <div class="col-md-6 col-offset-3" align="center">
                <h1>Přihlaste se vaším účtem</h1>
                <form method="post">

                    <label for="email">Váš email</label>
                    <input type="text" class="form-control" style="width:350px" id="email" name="email" value="<?php echo htmlspecialchars(@$_POST['email']); ?>"><br /><br />

                    <label for="heslo">Vaše heslo</label>
                    <input type="password" class="form-control" style="width:350px" name="heslo" id="heslo" value=""><br /><br />


                    <input type="submit" value="Přihlásit se" class="button btn-primary"> <input type="button" class="button btn-warning" onclick="window.location='<?php echo $loginURL?>'" value="Přihlásit pomocí google"> <br /><br />nebo <a href="index.php">Zrušit</a>

                </form>
                <?php
                if (!empty($chyby)) {
                    echo '<div class="error">' . $chyby . '</div>';
                }
                ?>
            </div>
        </div>
    </div>




</body>

</html>