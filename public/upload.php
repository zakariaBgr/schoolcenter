<?php
if( isset($_POST['upload']) ) // si formulaire soumis
{
    $content_dir = 'upload/'; // dossier où sera déplacé le fichier

    $tmp_file = $_FILES['fichier']['tmp_name'];

    if( !is_uploaded_file($tmp_file) )
    {
        exit("Le fichier est introuvable");
    }

    // on vérifie maintenant l'extension
    $type_file = $_FILES['fichier']['type'];

    if( !strstr($type_file, 'jpg') && !strstr($type_file, 'jpeg') && !strstr($type_file, 'bmp') && !strstr($type_file, 'gif')&&  !strstr($type_file, 'png') )
    {
        exit("Le fichier n'est pas une image");
    }

    // on copie le fichier dans le dossier de destination
    $name_file = $_FILES['fichier']['name'];

    if( !move_uploaded_file($tmp_file, $content_dir . $name_file) )
    {
        exit("Impossible de copier le fichier dans $content_dir");
    }
    echo "<br><img width='150px' height='150px' src='upload/$name_file'/>";
}

?>

<div id="messages">
            <!-- les messages du tchat -->

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

                // on récupère les 10 derniers messages postés
                $requete = $bdd->query('SELECT * FROM messages ORDER BY id DESC LIMIT 0,10');

                while($donnees = $requete->fetch()){
                    // on affiche le message (l'id servira plus tard)
                    echo "<p id=\"" . $donnees['id'] . "\">" . $donnees['pseudo'] . " dit : " . $donnees['message'] . "</p>";
                }

                $requete->closeCursor();

            ?>

        </div>

    <form method="POST" action="upload.php">
        Pseudo : <input type="text" name="pseudo" id="pseudo" value="<?php echo $_POST['inputEmail'] ?>" disabled/><br />
        Message : <textarea name="message" id="message"></textarea><br />
        <input type="submit" name="submit" value="Envoyez votre message !" id="envoi" />
    </form>

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>



    <script>

            $('#envoi').click(function(e){
            e.preventDefault(); // on empêche le bouton d'envoyer le formulaire

            var pseudo = encodeURIComponent( $('#pseudo').val() ); // on sécurise les données
            var message = encodeURIComponent( $('#message').val() );

            if(pseudo != "" && message != ""){ // on vérifie que les variables ne sont pas vides
                $.ajax({
                    url : "traitement.php", // on donne l'URL du fichier de traitement
                    type : "POST", // la requête est de type POST
                    data : "pseudo=" + pseudo + "&message=" + message // et on envoie nos données
                });

               $('#messages').append("<p>" + pseudo + " dit : " + message + "</p>"); // on ajoute le message dans la zone prévue
            }
        });

            function charger(){

    setTimeout( function(){

        var premierID = $('#messages p:first').attr('id'); // on récupère l'id le plus récent

        $.ajax({
            url : "charger.php?id=" + premierID, // on passe l'id le plus récent au fichier de chargement
            type : GET,
            success : function(html){
                $('#messages').prepend(html);
            }
        });

        charger();

    }, 5000);

}

charger();

</script>