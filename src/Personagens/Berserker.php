<?php 

class Berserker extends Personagem{
    private const CUSTO_TERREMOTO = 30;

    public function __construct(string $nome){
        parent::__construct($nome, 120, 25, 10, 60);
    }

    public function ultar(Personagem $alvo): string{
        $this->consumirMana(self::CUSTO_TERREMOTO);

        $dano = max(self::DANO_MINIMO, 40 - $alvo->getDefesaAtual());
        $alvo->receberDano($dano);

        return "{$this->nome} usou Terremoto em {$alvo->getNome()} causando {$dano} de dano.";
    }

    public function getTipo(): string{
        return "Berserker";
    }
}