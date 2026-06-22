<?php

class Necromancer extends Character{
    private const DECOMPOSITION_COST = 35;

    public function __construct(string $name){
        parent::__construct($name, 90, 25, 4, 90);
    }

    // passive
    public function onBasicAttack(int &$damage, Character $target): void{
        if ($damage <= 0) {
            return;
        }   

        $healing = (int) round($damage * 0.2);     

        $this->heal($healing);
    }

    public function useUltimate(Character $target): string{
        $this->consumeMana(self::DECOMPOSITION_COST);
        
        $damage = max(self::MIN_DAMAGE, 40 - $target->getCurrentDefense());

        if ($damage > 0){
            $healing = (int) round($damage * 0.2);
            $this->heal($healing);
        }

        $target->receiveDamage($damage);

        return "{$this->name} (Necromante) usou Decomposicao em {$target->getName()} causando {$damage} de dano.";
    } 

    public function getType(): string{
        return "Necromante";
    }
}
