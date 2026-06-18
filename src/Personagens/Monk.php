<?php

class Monk extends Personagem{
    private const CUSTO_PUNHO_SUAVE = 30;
    private int $countBasicAttacks = 0;

    public function __construct(string $nome){
        parent::__construct($nome, 100, 20, 10, 85);
    }

    //passiva
    public function onBasicAttack(int &$dano, Personagem $alvo): void{
        $this->countBasicAttacks++;

        if ($this->countBasicAttacks > 0 && $this->countBasicAttacks <= 1){
            $dano += $dano * 0.1;
        } elseif ($this->countBasicAttacks > 1 && $this->countBasicAttacks < 3){
            $dano += $dano * 0.2;
        } elseif ($this->countBasicAttacks >= 3){
            $dano += $dano * 0.3;
        } else {
            $dano += 0;
        }
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