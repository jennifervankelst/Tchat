<?php
 session_start();
 $username = "root";
 $password = "user";
 $host = "localhost";
 $bdname = "chat";

 try {
  //je me connecte a MySQL
  //$bdd = new PDO('mysql:host=localhost;dbname=chat;charset=utf8', 'root', 'user');
  $bdd = new PDO('mysql:dbname='.$bdname.';host='.$host.";charset=utf8", $username, $password);
}   

catch(Exception $e) {
  // En cas d'erreur, on affiche un message et on arrête tout
  die('Erreur: ' .$e->getMessage());

}
    
$requtil = $bdd->prepare('SELECT * 
                        FROM messages
                        LEFT JOIN utilisateur
                        ON messages.id_pseudo = utilisateur.id
                        ORDER BY heure DESC');

$requtil->execute();

$utilinfo = $requtil->fetchAll(PDO::FETCH_ASSOC);


?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Conversation</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="main.css" />
    <script src="main.js"></script>
    <link rel="stylesheet" href="conversation.css">
    <meta http-equiv="refresh" content="10; url=conversation.php">
</head>
<body>
    <div>
        <?php foreach($utilinfo as $value):  ?>
            <div>
                <label class="pseudo"> <?php echo $value['pseudo']; ?></label>
                <label class="heure"> <?php echo $value['heure']; ?></label>
                <label class="lbl_message"> <?php echo $value['texte']; ?></label>
            </div>
        <?php endforeach;?>
    </div>
</body>
</html>