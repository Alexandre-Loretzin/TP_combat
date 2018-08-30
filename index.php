<?php
session_start();
 
// gestion de la deconexion
if (isset($_GET['deconnexion'])){
    session_destroy();
    header('Location: .');
    exit();
}

require ('conexion.php'); 
require ('personnage.php');
require ('personnagesManager.php');
require ('combat.php');

?>
<!DOCTYPE html>
<html>
<head>
        <title>TP : Mini jeu de combat</title>
        <meta charset="utf-8" />
</head>
<body>
     
        <p> Nombre de personnages créés : <?= $manager->count() ?></p>

<?php
    // affichage des messages
    if (isset($message)){
        echo '<p>'. $message . '</p>';
    }
    
    // affichage des infos du perso si un perso est selectioné
    if (isset($perso)){
?>
    <!-- bouton deconexion -->
    <p><a href="?deconnexion=1">Déconnexion</a></p> 
    
    <!-- info du perso -->
    <fieldset>
        <legend>Mes informations</legend>
        <p>
            Nom : <?=  htmlspecialchars($perso->nom()) ?><br />
            Dégâts : <?= $perso->degats() ?>
        </p>
    </fieldset>

    <!-- liste des cibles -->
    <fieldset>
        <legend>Qui frapper?</legend>
        <p>
            <?php
            // method getlist
            $persos = $manager->getList($perso->nom());  
            // si vide
            if (empty($persos)) {
                echo 'Personne à frapper!';
            } 
            else {
                // affichacge des cibles avec foreach
                foreach($persos as $unPerso){
                    echo '<a href="?frapper='.$unPerso->id().'">'.htmlspecialchars($unPerso->nom()).'</a> (dégâts : '.$unPerso->degats().')<br />';
                }
            }
            ?>
        </p>
    </fieldset>
        
    
<?php
    } 
    // si aucun perso selectioné : formulaire de creation/selection
    else {
?>
            <form action="" method = "post">
                <p>
                    Nom : <input type="text" name="nom" maxlength="50" />
                    <input type="submit" value = "Créer ce personnage" name="creer" />
                    <input type="submit" value = "Utiliser ce personnage" name="utiliser" />
                </p>
            </form>
<?php
        }
?>
</body>
</html>