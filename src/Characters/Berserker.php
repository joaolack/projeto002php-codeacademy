<?php 

class Berserker extends Character{
    private const SLASH_AND_DASH_COST = 30;

    public function __construct(string $name){
        parent::__construct($name, 110, 25, 10, 60);
    }

    // passive
    public function onDamageCalc(int &$damage, Character $target): void{
        $lostHealthRatio = ($this->maxHealth - $this->health) / $this->maxHealth;

        $bonus = $lostHealthRatio * 0.5;

        $damage = (int) ($damage * (1 + $bonus));
    }


    public function useUltimate(Character $target): string{
        $this->consumeMana(self::SLASH_AND_DASH_COST);

        $damage = max(self::MIN_DAMAGE, 40 - $target->getCurrentDefense());
        $this->onDamageCalc($damage, $target);
        $target->receiveDamage($damage);

        return "{$this->name} (Berserker) usou Slash and Dash em {$target->getName()} causando {$damage} de dano.";
    }

    public function getType(): string{
        return "Berserker";
    }
}
