<?php
class PersonnagesManager
{
    private $bdd;
     
    public function __construct($db)
    {
        $this->setDb($db);
    }
     
    // seter
    public function setDb(PDO $db)
    {
        $this->bdd = $db;
    }
     
    // ajout personnage en bdd
    public function add(Personnage $perso)
    {
        $q = $this->bdd->prepare('INSERT INTO personnages (nom) VALUES (:nom)');
        $q->bindValue(':nom', $perso->nom());
        $q->execute();
         
        $perso->hydrate([
            'id'=>$this->bdd->lastInsertId(),
            'degats' => 0,
        ]);
    }
     
    // comptage des persos
    public function count()
    {
        return $this->bdd->query('SELECT COUNT(*) FROM personnages')->fetchColumn();
    }
    
    // quand un perso est tué
    public function delete(Personnage $perso)
    {
        $this->bdd->exec('DELETE FROM personnages WHERE id = '.$perso->id());
    }
    
    // verification d'existance
    public function exists($info)
    {
        if (is_int($info))
        {
            return (bool)$this->bdd->query('SELECT COUNT(*) FROM personnages WHERE id = '.$info)->fetchColumn();
        }
         
        $q = $this->bdd->prepare('SELECT COUNT(*) FROM personnages WHERE nom = :nom');
        $q -> execute([':nom' => $info]);
         
        return (bool) $q->fetchColumn();
    }
    

    public function get($info)
    {
        if (is_int($info))
        {
            $q = $this->bdd->query('SELECT * FROM personnages WHERE id = '.$info);
            $donnees = $q->fetch(PDO::FETCH_ASSOC);
             
            return new Personnage($donnees);
        }
         
        $q = $this ->bdd ->prepare('SELECT * FROM personnages WHERE nom = :nom');
        $q->execute([':nom' => $info]);
        $donnees = $q->fetch(PDO::FETCH_ASSOC);
         
        return new Personnage($donnees);
    }
     
    public function getList($nom)
    {
        $persos = [];
 
        $q  =  $this->bdd->prepare('SELECT * FROM personnages WHERE nom <> :nom ORDER BY nom');
        $q->execute([':nom'=>$nom]);
 
        while ($donnees = $q->fetch(PDO::FETCH_ASSOC))
        {
            $persos[] = new Personnage($donnees);
        }
        return $persos;
    }
     
    // modification de la table personnages
    public function update(Personnage $perso)
    {
        $q  =  $this->bdd->prepare('UPDATE personnages SET degats = :degats  WHERE id = :id');
        $q->bindValue(':degats',$perso->degats(), PDO::PARAM_INT);
        $q->bindValue(':id',$perso->id(), PDO::PARAM_INT);
        $q->execute();
    }
     

}