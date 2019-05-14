<?php
//pripojeni do db na serveru eso.vse.cz
$db = new PDO('mysql:host=127.0.0.1;dbname=podo01;charset=utf8', 'podo01', 'kephOilyupconJuvLyu');
//vyhazuje vyjimky v pripade neplatneho SQL vyrazu
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
?>