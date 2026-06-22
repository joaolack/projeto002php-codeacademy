<?php

class Monk extends Character{
    private const SOFT_FIST_COST = 30;
    private int $basicAttackCount = 0;

    public function __construct(string $name){
        parent::__construct($name, 100, 20, 10, 85);
    }

    // passive
    public function onBasicAttack(int &$damage, Character $target): void{
        $this->basicAttackCount++;

        if ($this->basicAttackCount === 2){
            $damage += $damage * 0.2;
        } elseif ($this->basicAttackCount === 3){
            $damage += $damage * 0.4;
        } elseif ($this->basicAttackCount >= 4) {
            $damage += $damage * 0.6;
        }
    }

    public function onDefend(): void{
        $this->basicAttackCount = 0;
    }

    public function useUltimate(Character $target): string{
        $this->consumeMana(self::SOFT_FIST_COST);

        $this->basicAttackCount = 0;

        $this->attackBonus = 10;
        $this->attackBonusTurns = 3;

        return "{$this->name} (Monge) usou Punho Suave e seus ataques basicos causaram +10 de dano por 3 turnos";
    }

    public function getType(): string{
        return "Monge";
    }
}
