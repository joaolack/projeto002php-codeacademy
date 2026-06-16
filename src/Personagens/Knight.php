<?php

class Knight extends Personagem{
    private const CUSTO_ARMADURA_PESADA = 20;

    public function __construct(string $nome){
        parent::__construct($nome, 130, 20, 15, 40);
    }

    public function ultar(Personagem $alvo): string{
        $this->consumirMana(self::CUSTO_ARMADURA_PESADA);

        $bonus = $this->defesa * 0.2;
        $this->bonusDefesa = $bonus;
        $this->turnosBonusDefesa = 2;

        return "{$this->nome} (Cavaleiro) usou Armadura Pesada e aumentou sua defesa em 20% por 2 turnos.";
    }

    public function getTipo(): string{
        return "Cavaleiro";
    }
}