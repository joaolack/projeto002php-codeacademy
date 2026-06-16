<?php

class Monk extends Personagem{
    private const CUSTO_PUNHO_SUAVE = 30;

    public function __construct(string $nome){
        parent::__construct($nome, 100, 20, 10, 85);
    }

    public function ultar(Personagem $alvo): string{
        $this->consumirMana(self::CUSTO_PUNHO_SUAVE);

        $this->bonusAtaque = 10;
        $this->turnosBonusAtaque = 3;

        return "{$this->nome} (Monge) usou Punho Suave e seus ataques básicos causaram +10 de dano por 3 turnos";
    }

    public function getTipo(): string{
        return "Monge";
    }
}