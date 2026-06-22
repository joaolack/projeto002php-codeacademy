<?php

abstract class Character implements CombatInterface {
    
    public const MIN_DAMAGE = 0;
    public const DEFENSE_BONUS = 8;
    public const MANA_REGENERATION = 10;

    protected string $name;
    protected int $health;
    protected int $maxHealth;
    protected int $attackPower;
    protected int $attackBonus = 0;
    protected int $attackBonusTurns = 0;
    protected int $defenseBonus = 0;
    protected int $defenseBonusTurns = 0;
    protected int $defense;
    protected int $mana;
    protected int $maxMana;
    protected bool $isDefending = false;

    public function __construct(
        string $name,
        int $health,
        int $attackPower,
        int $defense,
        int $mana
    ){
        $this->name = $name;
        $this->health = $health;
        $this->maxHealth = $health;
        $this->attackPower = $attackPower;
        $this->defense = $defense;
        $this->mana = $mana;
        $this->maxMana = $mana;
    }

    public function attack(Character $target): string{    
        $currentAttackPower = $this->attackPower + $this->attackBonus;
        
        $damage = max(self::MIN_DAMAGE, $currentAttackPower - $target->getCurrentDefense());
        $this->onDamageCalc($damage, $target);
        $this->onBasicAttack($damage, $target);
        $target->receiveDamage($damage);

        if ($this->attackBonusTurns > 0) {
            $this->attackBonusTurns--;

            if ($this->attackBonusTurns === 0) {
                $this->attackBonus = 0;
            }
        }

        return "{$this->name} atacou {$target->getName()} causando {$damage} de dano.";
    }

    public function defend(): string{
        $this->isDefending = true;
        $this->onDefend();

        return "{$this->name} assumiu postura defensiva e ganhou +".self::DEFENSE_BONUS." de defesa ate o proximo turno.";
    }

    abstract public function useUltimate(Character $target): string;

    public function onBasicAttack(int &$damage, Character $target): void{ }

    public function onDamageCalc(int &$damage, Character $target): void{ }

    public function onDefend(): void{ }

    public function startTurn(): void{
        $this->isDefending = false;
        $this->recoverMana(self::MANA_REGENERATION);

        if ($this->defenseBonusTurns > 0) {
            $this->defenseBonusTurns--;

            if ($this->defenseBonusTurns === 0) {
                $this->defenseBonus = 0;
            }
        }
    }    
    
    public function receiveDamage(int $damage): void{
        $this->health -= $damage;

        if ($this->health < 0){
            $this->health = 0;
        }
    }

    public function heal(int $amount): void{
        $this->health += $amount;

        if ($this->health > $this->maxHealth) {
            $this->health = $this->maxHealth;
        }
    }

    protected function consumeMana(int $cost): void{
        if ($this->mana < $cost){
            throw new InsufficientManaException("Mana insuficiente para realizar a acao.");
        }

        $this->mana -= $cost;
    }

    protected function recoverMana(int $amount): void{
        $this->mana += $amount;

        if ($this->mana > $this->maxMana) {
            $this->mana = $this->maxMana;
        }
    }

    public function getCurrentDefense(): int{
        $currentDefense = $this->defense + $this->defenseBonus;

        if ($this->isDefending) {
            $currentDefense += self::DEFENSE_BONUS;
        }

        return $currentDefense;
    }

    public function isAlive(): bool{
        return $this->health > 0;
    }

    public function getName(): string{
        return $this->name;
    }

    public function getHealth(): int{
        return $this->health;
    }

    public function getMaxHealth(): int{
        return $this->maxHealth;
    }

    public function getMana(): int{
        return $this->mana;
    }

    public function getMaxMana(): int{
        return $this->maxMana;
    }

    abstract public function getType(): string;

}
