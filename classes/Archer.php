<?php
class Archer extends Character
{
    // équivalent à $arrowPoints == 0 
    protected $flechePoints = 5;
    protected $nbTourAttendu = 0;
    protected $actuelAttack = "";


    public function __construct($name) {
        $this->name = $name;
    }


    public function turn($target) {
        return $this->jeterArrow($target);
    }

    private function attack($target, $damage = 0, $weapon = "fleche") {
        $target->setHealthPoints($damage);
        $status = " $this->name donne un coup de $weapon à $target->name ! Il reste $target->healthPoints points de vie à $target->name !";
        return $status;
    }

    public function carquoisVide() : bool
    {
        return $this->flechePoints <= 0;
    }

    // tirer une flèche
    public function jeterArrow($target) 
    {
        // si le carquois est vide on attaque avec la dague
        if ($this->carquoisVide()) {
            return $this->attackDague($target);
        }

        // sinon on tire une flèche
        $this->flechePoints -= 1;
        return $this->attack($target, $this->damage, "une flèche");

    }
public function throwTwoArrows($target)
    {
        // il faut qu'il y ait suffisamment de flèche
        if ($this->flechePoints < 2) {
            // on n'a pas assez de flèche
            return $this->attackDague($target);
        }

        // on a assez de flèches
        if($this->nbTourAttendu < 1){
            $this->nbTourAttendu +=1;
            $this->actuelAttack = "throwTwoArrows";
            return "$this->name attend avant de tirer ses deux flèches";
        }

        // on peut tirer deux flèches
        $this->flechePoints -= 2;
        return $this->jeterArrow($target) + $this->jeterArrow($target); 
    }

    // viser un point faible
    
    public function shootCriticalPoint($target)
    {
        if ($this->flechePoints < 1) {
            // on n'a pas assez de flèche
            return $this->attackDague($target);
        }

        
        if ($this->nbTourAttendu < 1) {
            $this->nbTourAttendu += 1;
            // l'attaque en cours devient attaquer avec deux flèches
            $this->actuelAttack = "shootAtCriticalPoint";
            return "$this->name attend avant de tirer un coup critique";
        }

        // on peut tirer deux flèches
        $this->flechePoints -= 1;
        $combo = rand(15, 30) / 10;
        return $this->attack($target, $damage = $this->damage * $combo, "flèche critique");
    }

    // attaquer avec la dague
    public function attackDague($target)
    {
        return $this->attack($target, $damage = $this->damage * 0.80, "dague");
    }

}
