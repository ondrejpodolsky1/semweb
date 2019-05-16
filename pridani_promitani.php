<?php
require 'db.php';
$sql = "SELECT * FROM filmy";
$vypis = $db->query($sql);
$filmy_op = "";
$filmy_op = $filmy_op."<option value='zadny' selected='selected'>vyberte film..</option>";
while($data = $vypis->fetch( PDO::FETCH_ASSOC )) {
  $filmy_op = $filmy_op."<option value=".$data['id'].">".$data['nazev']."</option>";
}

if($_SERVER["REQUEST_METHOD"] == "POST"){
  $cas = $_POST['cas'];
  $film_id = $_POST['filmy_sel'];
  $datum = $_POST['Datum'];
  $chyby="";
  
  
  if(!empty($_POST)){
    if($_POST['cas']=="0"){
        $chyby.='Vyberte čas promítání!<br>';
    }
    if($_POST['filmy_sel']=="zadny"){
        $chyby.='Vyberte film!<br>';
    }
    if(empty($_POST['Datum'])){
      $chyby.='Vyberte datum promítání!<br>';
    }
    
    
    $stmt = $db->prepare("INSERT INTO promitani(datum, cas, film_id) VALUES(?,?,?)");
    $stmt->execute(array($datum, $cas, $film_id));

    $stmt = $db->prepare("SELECT id FROM promitani WHERE film_id = ? LIMIT 1");
    $stmt->execute(array($film_id));
    $id_promitani = (int)$stmt->fetchColumn();

    $_SESSION['id_promitani']=$id_promitani;
}
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Založení nového filmu</title>
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <link rel="stylesheet" href="/resources/demos/style.css">
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <script>
  
  $(document).ready(function() {
  
    $('#Datum').datepicker({
      dateFormat: 'yy-mm-dd'
      /*
        onSelect: function(datText, prom) {
            //Dostane dnešní datum - půlnoc (dnes)
            var dnes = new Date();
            dnes = Date.parse(dnes.getMonth()+1+'/'+dnes.getDate()+'/'+dnes.getFullYear());
            //Zde je načteno vybrané datum z pickeru (also at midnight)
            var vybDat = Date.parse(datText);

            if(vybDat < dnes) {
                //Pokud je vybrané datum menší než dnešní picker nezmizí a nechá uživatele dále vybírat
                $('#Datum').val('');
                $(prom).datepicker('show');
            }
        }*/
    });
});
  </script>
</head>
<body>
<form method="post">

<label for="film">Film:</label>
<select name="filmy_sel" id="filmy_sel">
<?php
echo $filmy_op;
?>
</select><br><br>


<label for="datum">Datum:</label>
<input type="text" name="Datum" id="Datum"><br><br>


<label for="cas">Čas:</label>
<select name="cas" id="cas">
<option selected='selected' value='0'>Vyberte čas</option>
<option value='10'>10:00</option>
<option value='13'>13:00</option>
<option value='16'>16:00</option>
<option value='19'>19:00</option>
<option value='22'>22:00</option>
</select><br><br>
<input type="submit" value="Přidat čas promítání"> nebo <a href="vypsat_filmy.php">Zrušit</a>
</form>

<?php
    if(!empty($chyby)){
        echo '<div class="error">'.$chyby.'</div>';
    }
    ?>

<a href="index.php">Zpět na index</a>
</body>
</html>