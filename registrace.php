<?php
require 'db.php';

session_start();
//TODO - KONTROLA DAT Z FORMULÁŘE - ošetřit vstupy proti sql a jiné injection
if($_SERVER["REQUEST_METHOD"] == "POST"){
    $jmeno = htmlspecialchars($_POST['jmeno']);
    $email = htmlspecialchars($_POST['email']);
    $heslo = htmlspecialchars($_POST['heslo']);

    $hash = password_hash($heslo, PASSWORD_DEFAULT);

    $stmt = $db->prepare("INSERT INTO uzivatel(jmeno, email, heslo) VALUES(?,?,?)");
    $stmt->execute(array($jmeno, $email, $hash));

    $stmt = $db->prepare("SELECT id FROM uzivatele WHERE email = ? LIMIT 1");
    $stmt->execute(array($email));
    $id_uziv = (int)$stmt->fetchColumn();

    $_SESSION['id_uziv']=$id_uziv;

    header('Location: index.php');







}
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
        Stránka s registrací uživatele 
    -->
    <h1>Registrační formulář</h1>

 
    <form action="" method="POST">
	  
      <label for="jmeno">Vaše jméno</label>
      <input type="text" id="jmeno" name="jmeno" value=""><br/><br/>

      <label for="email">Váš email</label>
      <input type="text" id="email" name="email" value=""><br/><br/>

      <label for="heslo">Vaše heslo</label>
      <input type="password" name="heslo" id="heslo" value=""><br/><br/>
                  

      <input type="submit" value="Vytvořit účet"> nebo <a href="https://eso.vse.cz/~podo01/sem/index.php">Zrušit</a>
  
  </form>
    
    </form>
    </body>
</html>