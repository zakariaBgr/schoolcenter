<?php

    // on se connecte à notre base de données
    try
    {
        $bdd = new PDO('mysql:host=localhost;dbname=schoolcenter', 'root', '');
    }
    catch (Exception $e)
    {
        die('Erreur : ' . $e->getMessage());
    }


    $requete = $bdd->query('SELECT * FROM sujet ');

    while($donnees = $requete->fetch()){
        echo "<p> ". $donnees['login'] . " -  " . $donnees['nomsujet'] . "</p>";
    }

    $requete->closeCursor();

?>