<?php
require 'db.php';
session_start();
$_SESSION['cas_promitani'] = $_GET["cas_promitani"];
$json_pryc = array();
$id_rezervujici = array();
$id_misto = 0;
if ($_SESSION['normal-prihlasen'] == 'ano' || $_SESSION['admin'] == 'ano' || $_SESSION['glogin'] == 'ano') { } else {
    header('Location: prihlaseni.php');
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $vybrana_mista=array();
    $chyby = "";
    if (!empty($_POST)) {
        if(empty($_POST['mista'])){
            $chyby .= "Vyberte místa, která chcete rezervovat.";
        }
    }
    if (isset($_POST['rezervovat'])) {
        if (!empty($_POST['mista'])) {
            foreach ($_POST['mista'] as $vybrane) {
                $vybrana_mista[] = $vybrane;
            }
        }
    } 
    if(empty($chyby)){
        $id_uzivatel = $_SESSION['id_uziv'];
        $id_promitani = $_SESSION['id_promitani'];
        $cas_promitani = $_SESSION['cas_promitani'];
        $mista = $vybrana_mista;
        $mista_json = json_encode($mista);

        $stmt = $db->prepare("INSERT INTO rezervace(id_uzivatel, id_promitani,cas_promitani, mista) VALUES(?,?,?,?)");
        $stmt->execute(array($id_uzivatel, $id_promitani, $cas_promitani, $mista_json));    
        
           
        
    }
    
    
}
$sql = "SELECT * FROM rezervace WHERE id_promitani=".$_SESSION['id_promitani']." AND cas_promitani=".$_SESSION['cas_promitani']."";
$vypis = $db->query($sql);
    if ($vypis->rowCount() > 0) { 
        while ($data = $vypis->fetch(PDO::FETCH_ASSOC)) {
          $json_pryc = json_decode($data["mista"],true);
          $id_rezervujici = $data["id_uzivatel"];
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
    <title>REZERVACE</title>
</head>

<body>
    <div class="container" style="margin-top: 50px">


        <div class="row justify-content-center">
            <div class="col-md-6 col-offset-3" align="center">
                <h1>
                    REZERVACE MÍSTA V KINĚ<br>
                </h1>
                <?php

                echo "<form method='post'><table class='table table-bordered'><br />";

                for ($radek = 0; $radek < 5; $radek++) {
                     
                    echo "<tr>";
                    for ($sloupec = 0; $sloupec < 5; $sloupec++) {
                        echo "<td class='";
                        foreach($json_pryc as $misto){
                            if($misto-1 == $id_misto){
                                if( $id_rezervujici == $_SESSION['id_uziv']){
                                    echo "table-success";    
                                }else{
                                    echo "table-danger";    
                                }
                                                        
                                                       
                            }
                        }
                       
                        echo "'><input type='checkbox' name='mista[]' value='" . ($id_misto = $id_misto + 1) . "'";
                        foreach($json_pryc as $misto){
                            if($misto == $id_misto){
                               echo "disabled";                             
                            }
                        }                    
                         echo ">".($id_misto)."</input></td>";                 
                    }
                        
                    }
                    echo "</tr>";
                
            
                echo "</table>";
                echo "<input type='submit' class='btn-primary' name='rezervovat' value='Rezervovat'/>";
                echo "</form>";
                                        
                
            
                ?>
                    <form method="post">
                    <input type='submit' class='btn-primary' name='vypsat' value='Vypsat'/>
                    </form>
                  <?php
                    if (!empty($chyby)) {
                        echo '<div class="error">' . $chyby . '</div>';
                    }
                    ?>
                <a href="vypsat_filmy.php">Zpět na filmy</a>
            </div>
            <!-- konec COL MD 6-->
        </div>
        <!-- konec row justify-->
    </div>
    <!-- konec kontejneru-->
</body>

</html>