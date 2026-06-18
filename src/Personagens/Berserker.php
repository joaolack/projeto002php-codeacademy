<?php 

class Berserker extends Personagem{
    private const CUSTO_SLASH_AND_DASH = 30;

    public function __construct(string $nome){
        parent::__construct($nome, 110, 25, 10, 60);
    }

    //passiva
    public function onDamageCalc(int &$dano, Personagem $alvo): void{
        $vidaPerdida = ($this->vidaMaxima - $this->vida) / $this->vidaMaxima;

        $bonus = $vidaPerdida * 0.5;

        $dano = (int) ($dano * (1 + $bonus));
    }


    public function ultar(Personagem $alvo): string{
        $this->consumirMana(self::CUSTO_SLASH_AND_DASH);

        $dano = max(self::DANO_MINIMO, 40 - $alvo->getDefesaAtual());
        $this->onDamageCalc($dano, $alvo);
        $alvo->receberDano($dano);

        return "{$this->nome} (Berserker) usou Slash and Dash em {$alvo->getNome()} causando {$dano} de dano.";
    }

    public function getTipo(): string{
        return "Berserker";
    }
}