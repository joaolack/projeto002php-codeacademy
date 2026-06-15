<?php

class Necromante extends Personagem{
    private const CUSTO_DECOMPOSICAO = 35;

    public function __construct(string $nome){
        parent::__construct($nome, 90, 25, 4, 90);
    }

    public function ultar(Personagem $alvo): string{
        $this->consumirMana(self::CUSTO_DECOMPOSICAO);

        $dano = max(self::DANO_MINIMO, 40 - $alvo->getDefesaAtual());
        $alvo->receberDano($dano);

        return "{$this->nome} usou Decomposição em {$alvo->getNome()} causando {$dano} de dano.";
    } 

    public function getTipo(): string{
        return "Necromante";
    }
}