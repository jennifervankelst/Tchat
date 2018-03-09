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
/*if ($conn->connect_error){
    die("connection failed: " . $conn->connect_error);

}
echo "connected succefully";*/



//pour le bouton envoyer
if(isset($_POST['submit']) && !empty($_POST['pseudo']) && !empty($_POST['mot_de_passe']) && !empty($_POST['mail'])){


    $_POST['pseudo'] = filter_var($_POST['pseudo'],FILTER_SANITIZE_STRING);
    $_POST['mot_de_passe'] = filter_var($_POST['mot_de_passe'],FILTER_SANITIZE_STRING);
    $_POST['mail'] = filter_var($_POST['mail'],FILTER_SANITIZE_STRING);


        $pseudo = htmlspecialchars($_POST['pseudo']);
        $mot_de_passe = sha1($_POST['mot_de_passe']);
        $mail = htmlspecialchars($_POST['mail']);
        global $bdd;

        $mailreq = $bdd->prepare('SELECT * FROM utilisateur WHERE mail = ?');
        $mailreq->execute(array($mail));
        $mailexiste = $mailreq->rowcount();

        $pseudoreq = $bdd->prepare('SELECT * FROM utilisateur WHERE pseudo = ?');
        $pseudoreq->execute(array($pseudo));
        $pseudoexiste = $pseudoreq->rowcount();

        if($pseudoexiste == 0){

            if($mailexiste == 0){

                $insertutil= $bdd->prepare("INSERT INTO utilisateur (pseudo, mot_de_passe, mail) VALUES ('".$pseudo."', '".$mot_de_passe."','".$mail."')");
                $insertutil->execute(array(
                    "pseudo" => $pseudo, 
                    "mot_de_passe" => $mot_de_passe, 
                    "mail" => $mail));
                    header('location: index.php');
                /*$SESSION['comptecree'] = "Votre compte a bien été créé!";*/
            }       
                else {
                
                    $erreur = "Votre mail existe déjà!";
                }
            // echo "ok";*/

        

                //echo 'ok';

        }
        else {
            $erreur = "Ce pseudo est déjà utlisé!";
        }
        
}
else {

    $erreur = "Tous les champs ne sont pas rempli!";
    
}                 
        
    

?>




<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Inscription</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="main.css" />
    <link rel="stylesheet" type="text/css" href="inscription.css"/>
    <script src="main.js"></script>
</head>
<body>
    <section class="formulaire"> 
        <h1>Inscription</h1>
            <div class="enregistrer">
            <form method="post" action="inscription.php">
                <div class="pseudo">
                    Pseudo:
                        <input class="button1" type="text" name="pseudo" id="pseudo" placeholder="pseudo"
                           value=<?php if(isset($pseudo)){ echo($pseudo); }?>></br>
                </div>
                <div class="mot_de_passe">
                    Mot de passe:
                        <input class="button2" type="password" name="mot_de_passe" id="mot_de_passe" placeholder="obligatoire"></br>
                </div>
                <div class="mail">
                    Email:    
                        <input class="button3" type="text" name="mail" id="mail" placeholder="obligatoire"
                            value=<?php if(isset($mail)) {echo($mail); }?>></br>
                </div>
            </div>    
                <div class="envoyer"> 
                        <input class="button4" type="submit" name="submit" value="Envoyer">
                </div> 
            </form>
                <?php 
                     if(isset($erreur)){
                         echo '<font color= "red"> '.$erreur."</font>";
                     }
                ?> 
    </section>    
</body>
</html>