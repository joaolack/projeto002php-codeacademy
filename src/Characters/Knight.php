<?php

class Knight extends Character{
    private const HEAVY_ARMOR_COST = 20;

    public function __construct(string $name){
        parent::__construct($name, 130, 20, 15, 40);
    }

    public function onDefend(): void{
        $defense = $this->getCurrentDefense();

        $bonus = (int) round($defense * 0.3);
    
        $this->attackBonus = $bonus;
        $this->attackBonusTurns = 1;
    }

    public function useUltimate(Character $target): string{
        $this->consumeMana(self::HEAVY_ARMOR_COST);

        $bonus = $this->defense * 0.2;
        $this->defenseBonus = $bonus;
        $this->defenseBonusTurns = 2;

        return "{$this->name} (Cavaleiro) usou Armadura Pesada e aumentou sua defesa em 20% por 2 turnos.";
    }

    public function getType(): string{
        return "Cavaleiro";
    }
}
