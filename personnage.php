<?php

class Personnage
{
    private $id,
            $nom,
            $degats;

    const CEST_MOI = 1;
    const PERSONNAGE_TUE = 2;
    const PERSONNAGE_FRAPPE = 3;

    public function __construct(array $donnees)
    {
        $this->hydrate($donnees);

    }


    // hydratation
    public function hydrate(array $donnees)
    {
        foreach ($donnees as $key => $value) {
            $method = 'set' . ucfirst($key);

            if (method_exists($this, $method)){
                $this->$method($value);
            }
        }
    }

    public function frapper(Personnage $perso)
    {
        if ($perso->id() == $this->id) {
            return self::CEST_MOI;
        }

        return $perso->recevoirDegats();
        
    }

    public function recevoirDegats()
    {
        $this->degats += 5;

        if ($this->degats >=100) {
            return self::PERSONNAGE_TUE;
        }
       
        return self::PERSONNAGE_FRAPPE;
    }
    
    // geter
    public function degats()
    {
        return $this->degats;
    }

    public function id()
    {
        return $this->id;
    }

    public function nom()
    {
        return $this->nom;
    }

    // seter
    public function setDegats($degats)
    {
        $degats = (int) $degats;

        if ($degats >= 0 && $degats <=100){
            $this->degats = $degats;
        }
    }
    public function nomValide()
    {
      return !empty($this->nom);
    }
    public function setId($id)
    {
        $id = (int) $id;
        if ($id > 0 ){
            $this->id = $id;
        }
    }

    public function setNom($nom)
    {
      
            $this->nom = $nom;
        
    }

}
