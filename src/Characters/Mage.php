<?php

class Mage extends Character{
    private const ARCANE_FLAME_COST = 40;
    private const BASIC_ATTACK_MANA_RECOVERY = 5;

    public function __construct(string $name){
        parent::__construct($name, 90, 20, 5, 100);
    }

    public function onBasicAttack(int &$damage, Character $target): void{
        $this->recoverMana(self::BASIC_ATTACK_MANA_RECOVERY);
    }


    public function useUltimate(Character $target): string{
        $this->consumeMana(self::ARCANE_FLAME_COST);

        $damage = max(self::MIN_DAMAGE, 32 - $target->getCurrentDefense());
        $target->receiveDamage($damage);

        $healing = 10;
        $this->heal($healing);

        return "{$this->name} (Mago) usou Chama Arcana em {$target->getName()} causando {$damage} de dano e recuperando {$healing} de vida.";
    }

    public function getType(): string{
        return "Mago";
    }

}
