<?php
session_start();
require 'db.php';

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $email = htmlspecialchars($_POST['email']);
    $heslo = htmlspecialchars($_POST['heslo']);
    $chyby="";
    //ošetření formuláře
    if(!empty($_POST)){
    if(empty($_POST['email'])){
        $chyby.='Zadejte svůj email do formuláře!<br>';
    }else if(!(filter_var($email, FILTER_VALIDATE_EMAIL))){
        $chyby.='zadejte email ve správném formátu.<br>';
    }else if (strlen($heslo) < 5) {
        // heslo je moc krátké
        $chyby.='Zadejte dostatečně dlouhé heslo!<br>';
      }
    }
    $stmt = $db->prepare("SELECT * FROM uzivatel WHERE email = ? LIMIT 1");
    $stmt->execute(array($email));
    $prihlaseny = @$stmt->fetchAll()[0];

    if(password_verify($heslo, $prihlaseny["heslo"])){
        $_SESSION['id_uziv'] = $prihlaseny['id'];
        $_SESSION['normal-prihlasen']= 'ano';
        header('Location: index.php');
    }else{
        $chyby.="Nesprávný email nebo heslo.";
    }
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
        Stránka s přihlašovacím formulářem
    -->
    <h1>Přihlaste se vaším účtem</h1>
    <form method="post">

      <label for="email">Váš email</label>
      <input type="text" id="email" name="email" value="<?php echo htmlspecialchars(@$_POST['email']);?>" ><br/><br/>

      <label for="heslo">Vaše heslo</label>
      <input type="password" name="heslo" id="heslo" value=""><br/><br/>
                  

      <input type="submit" value="Přihlásit se"> nebo <a href="index.php">Zrušit</a>
  
  </form>
    </form>
    </body>
</html>