<?php

class Mago extends Personagem{
    private const CUSTO_CHAMA_ARCANA = 40;
    private const MANA_RECUPERADA_ATAQUE_BASICO = 5;

    public function __construct(string $nome){
        parent::__construct($nome, 90, 20, 5, 100);
    }

    public function onBasicAttack(int &$dano, Personagem $alvo): void{
        $this->recuperarMana(self::MANA_RECUPERADA_ATAQUE_BASICO);
    }


    public function ultar(Personagem $alvo): string{
        $this->consumirMana(self::CUSTO_CHAMA_ARCANA);

        $dano = max(self::DANO_MINIMO, 32 - $alvo->getDefesaAtual());
        $alvo->receberDano($dano);

        $cura = 10;
        $this->curar($cura);

        return "{$this->nome} (Mago) usou Chama Arcana em {$alvo->getNome()} causando {$dano} de dano e recuperando {$cura} de vida.";
    }

    public function getTipo(): string{
        return "Mago";
    }

}
