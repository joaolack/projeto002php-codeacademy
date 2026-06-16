<?php 

class Berserker extends Personagem{
    private const CUSTO_SLASH_AND_DASH = 30;

    public function __construct(string $nome){
        parent::__construct($nome, 110, 25, 10, 60);
    }

    public function ultar(Personagem $alvo): string{
        $this->consumirMana(self::CUSTO_SLASH_AND_DASH);

        $dano = max(self::DANO_MINIMO, 40 - $alvo->getDefesaAtual());
        $alvo->receberDano($dano);

        return "{$this->nome} (Berserker) usou Slash and Dash em {$alvo->getNome()} causando {$dano} de dano.";
    }

    public function getTipo(): string{
        return "Berserker";
    }
}