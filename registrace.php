<?php
require 'db.php';

session_start();
//TODO - KONTROLA DAT Z FORMULÁŘE - ošetřit vstupy proti sql a jiné injection
if($_SERVER["REQUEST_METHOD"] == "POST"){
    $jmeno = htmlspecialchars($_POST['jmeno']);
    $email = htmlspecialchars($_POST['email']);
    $heslo = htmlspecialchars($_POST['heslo']);
    $chyby="";
    //ošetření formuláře
    if(!empty($_POST)){
    if(empty($_POST['jmeno'])){
        $chyby.='Zadejte své jméno!<br>';
    }
    if(empty($_POST['email'])){
        $chyby.='Zadejte svůj email do formuláře!<br>';
    }else if(!(filter_var($email, FILTER_VALIDATE_EMAIL))){
        $chyby.='zadejte email ve správném formátu.<br>';
    }
    
    if (strlen($heslo) < 5) {
        // heslo je moc krátké
        $chyby.='Heslo je moc krátké, zadejte heslo obsahující alespoň 5 znaků!<br>';
      }
    if(empty($chyby)){
        $hash = password_hash($heslo, PASSWORD_DEFAULT);

        $stmt = $db->prepare("INSERT INTO uzivatel(jmeno, email, heslo) VALUES(?,?,?)");
        $stmt->execute(array($jmeno, $email, $hash));

        
        $stmt = $db->prepare("SELECT id FROM uzivatel WHERE email = ? LIMIT 1");
        $stmt->execute(array($email));
        $id_uziv = (int)$stmt->fetchColumn();

        $_SESSION['id_uziv']=$id_uziv;
        $_SESSION['normal-prihlasen']= 'ano';
        header('Location: index.php');
    }
}
}


?>
<!DOCTYPE html>
<html> 
    <head>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>REGISTRACE</title>
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
      <input type="text" id="jmeno" name="jmeno" value="<?php echo htmlspecialchars(@$_POST['jmeno']);?>" ><br/><br/>

      <label for="email">Váš email</label>
      <input type="text" id="email" name="email" value="<?php echo htmlspecialchars(@$_POST['email']);?>" ><br/><br/>

      <label for="heslo">Vaše heslo</label>
      <input type="password" name="heslo" id="heslo" value=""><br/><br/>
                  

      <input type="submit" value="Vytvořit účet"> nebo <a href="https://eso.vse.cz/~podo01/sem/index.php">Zrušit</a>
  
  </form>
    <?php
    if(!empty($chyby)){
        echo '<div class="error">'.$chyby.'</div>';
    }
    ?>
    
    </body>
</html>