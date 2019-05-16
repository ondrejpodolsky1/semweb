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
        onSelect: function(datText, prom) {
            //Dostane dnešní datum - půlnoc (dnes)
            var dnes = new Date();
            dnes = Date.parse(dnes.getMonth()+1+'/'+dnes.getDate()+'/'+dnes.getFullYear());
            //Zde je načteno vybrané datum z pickeru (also at midnight)
            var vybDat = Date.parse(datText);

            if(vybDat < today) {
                //Pokud je vybrané datum menší než dnešní picker nezmizí a nechá uživatele dále vybírat
                $('#Datum').val('');
                $(prom).datepicker('show');
            }
        }
    });
});
  </script>
</head>
<body>
<form action="" method="post">
<label for="datum">Datum:</label>
<input type="text" name="datum" id="Datum"></p><br><br>
</form>
<a href="index.php">Zpět na index</a>
 
 
</body>
</html>