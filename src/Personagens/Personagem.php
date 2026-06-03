<?php

abstract class Personagem implements CombatenteInterface {
    
    public const DANO_MINIMO = 0;
    public const BONUS_DEFESA = 8;
    public const REGENERACAO_MANA = 10;

    protected string $nome;
    protected int $vida;
    protected int $vidaMaxima;
    protected int $poderAtaque;
    protected int $defesa;
    protected int $mana;
    protected int $manaMaxima;
    protected bool $defendendo = false;

    public function __construct(
        string $nome,
        int $vida,
        int $poderAtaque,
        int $defesa,
        int $mana
    ){
        $this->nome = $nome;
        $this->vida = $vida;
        $this->vidaMaxima = $vida;
        $this->poderAtaque = $poderAtaque;
        $this->defesa = $defesa;
        $this->mana = $mana;
        $this->manaMaxima = $mana;
    }

    public function atacar(Personagem $alvo): string{    
        $dano = max(self::DANO_MINIMO, $this->poderAtaque - $alvo->getDefesaAtual());
        $alvo->receberDano($dano);

        return "{$this->nome} atacou {$alvo->getNome()} causando {$dano} de dano.";
    }

    public function defender(): string{
        $this->defendendo = true;

        return "{$this->nome} assumiu postura defensiva e ganhou +".self::BONUS_DEFESA." de defesa até o próximo turno.";
    }

    abstract public function ultar(Personagem $alvo): string;

    public function iniciarTurno(): void{
        $this->defendendo = false;
        $this->regenerarMana();
    }
    
    public function receberDano(int $dano): void{
        $this->vida -= $dano;

        if ($this->vida < 0){
            $this->vida = 0;
        }
    }

    public function curar(int $quantidade): void{
        $this->vida += $quantidade;

        if ($this->vida > $this->vidaMaxima) {
            $this->vida = $this->vidaMaxima;
        }
    }

    protected function consumirMana(int $custo):void {
        if ($this->mana < $custo){
            throw new ManaInsuficienteException("Mana insuficiente para realizar a ação.");
        }

        $this->mana -= $custo;
    }

    protected function regenerarMana(): void{
        $this->mana += self::REGENERACAO_MANA;

        if ($this->mana > $this->manaMaxima) {
            $this->mana = $this->manaMaxima;
        }
    }

    public function getDefesaAtual(): int{
        return $this->defendendo ? $this->defesa + self::BONUS_DEFESA : $this->defesa;
    }

    public function estaVivo(): bool{
        return $this->vida > 0;
    }

    public function getNome(): string{
        return $this->nome;
    }

    public function getVida(): int{
        return $this->vida;
    }

    public function getVidaMaxima(): int{
        return $this->vidaMaxima;
    }

    public function getMana(): int{
        return $this->mana;
    }

    abstract public function getTipo(): string;

}