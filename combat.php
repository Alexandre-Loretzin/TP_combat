<?php

$manager = new PersonnagesManager($bdd);
 
// On crée un nouveau personnage.
if (isset($_POST['creer']) && isset($_POST['nom'])){

    $perso = new Personnage(['nom' => $_POST['nom']]);
    
    // nom valide ?
    if (!$perso->nomValide()){
        $message = 'Le nom choisi est invalide.';
        unset($perso);
    
    // nom unique ?
    } elseif ($manager->exists($perso->nom())){
        $message = 'Le nom du personnage est déjà pris.';
        unset($perso);
        
    // ajout
    } else {
        $manager->add($perso);
    }
    
    // enregistrement du personage dans la session
    $_SESSION["nom"] = $_POST["nom"];
} 

// Si on a voulu utiliser un personnage.  
if (isset($_POST['utiliser']) && isset($_POST['nom'])){

    // Si celui-ci existe.
    if ($manager->exists($_POST['nom'])){
        $perso = $manager->get($_POST['nom']);
    }

    else {
        // S'il n'existe pas, on affichera ce message.
        $message = 'Ce personnage n\'existe pas !';
    }

    // enregistrement du personage dans la session
    $_SESSION["nom"] = $_POST["nom"];
     
} 

// Quand on frappe un personnage
if (isset($_GET['frapper'])){

    // recuperation de la session
    $perso = $manager->get($_SESSION['nom']); 

    // ciblage
    $persoAFrapper = $manager->get((int) $_GET['frapper']);
    $retour = $perso->frapper($persoAFrapper);
        
    // gestion des differents cas
    switch($retour)
    {
        case Personnage::CEST_MOI :
            $message = 'Mais... pouquoi voulez-vous vous frapper ???';
            break;

        case Personnage::PERSONNAGE_FRAPPE :
            $message = 'Le personnage a bien été frappé !';
            $manager->update($perso);
            $manager->update($persoAFrapper);
            break;

        case Personnage::PERSONNAGE_TUE;
            $message = 'Vous avez tué ce personnage !';
            $manager->update($perso);
            $manager->delete($persoAFrapper);
        break;
    }
}