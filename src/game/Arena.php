<?php

class Arena{
    private Personagem $jogador1;
    private Personagem $jogador2;
    private int $turnos = 0;
    private array $log = [];

    public function __construct(Personagem $jogador1, Personagem $jogador2){
        $this->jogador1 = $jogador1;
        $this->jogador2 = $jogador2;
    }

    private function hpBar(Personagem $personagem): string{
        $width = 20;
        $vida = $personagem->getVida();
        $vidaMaxima = $personagem->getVidaMaxima();
        $percentage = $vida / $vidaMaxima;
        $filled = (int) round($percentage * $width);
        $empty = $width - $filled;

        if ($percentage > 0.6) {
            $color = "\033[32m";
        } elseif ($percentage > 0.3) {
            $color = "\033[33m";
        } else {
            $color = "\033[31m";
        }

        $bar = 
            str_repeat("█", $filled) . 
            str_repeat("░", $empty);

        return "{$color}[{$bar}]\033[0m {$vida}/{$vidaMaxima}";
    }

    private function manaBar(Personagem $personagem): string{
        $width = 10;
        $mana = $personagem->getMana();
        $manaMaxima = $personagem->getManaMaxima();
        $percentage = $mana / $manaMaxima;
        $filled = (int) round($percentage * $width);
        $empty = $width - $filled;
        $color = "\033[36m";

        $bar =
            str_repeat("█", $filled) . 
            str_repeat("░", $empty);

        return "{$color}[$bar]\033[0m {$mana}/{$manaMaxima}";
    }

    public function iniciar(): void{
        $atual = $this->jogador1;
        $oponente = $this->jogador2;
        $numeroJogador = 1;

        while ($this->jogador1->estaVivo() && $this->jogador2->estaVivo()){
            $this->turnos++;
            $atual->iniciarTurno();

            $acaoExecutada = false;
            $resultado = "";

            while (!$acaoExecutada){
                $this->exibirTelaCombate($numeroJogador, $atual, $oponente, $resultado);

                try {
                    $opcao = trim(readline("Escolha uma opção: "));

                    if(!in_array($opcao, ["1", "2", "3"])){
                        throw new EntradaInvalidaException("Opção Inválida.");
                    }

                    $resultado = match ($opcao) {
                        "1" => $atual->atacar($oponente),
                        "2" => $atual->defender(),
                        "3" => $atual->ultar($oponente)
                    };

                    $this->log[] = "Turno {$this->turnos}: {$resultado}";
                    $acaoExecutada = true;
                    $this->exibirTelaCombate($numeroJogador, $atual, $oponente, $resultado);

                    readline("\nPressione ENTER para continuar...");
                } catch (ManaInsuficienteException | EntradaInvalidaException $e) {
                    echo "\nErro: {$e->getMessage()}\n ";
                    readline("Pressione ENTER para tentar novamente...");
                }
            }

            [$atual, $oponente] = [$oponente, $atual];
            $numeroJogador = $numeroJogador === 1 ? 2 : 1;
        }
        $this->exibirResumo();
    }

    private function exibirTelaCombate(int $numeroJogador, Personagem $atual, Personagem $oponente, string $resultado): void{
        system('clear');

        echo "=== ARENA DE BATALHA ===\n\n";



        echo "VEZ DO JOGADOR {$numeroJogador})\n\n";
        echo "{$this->jogador1->getNome()} - Classe: {$this->jogador1->getTipo()} HP: {$this->hpBar($this->jogador1)} Defesa: {$this->jogador1->getDefesaAtual()} Mana: {$this->manaBar($this->jogador1)}\n";
        echo "{$this->jogador2->getNome()} - Classe: {$this->jogador2->getTipo()} HP: {$this->hpBar($this->jogador2)} Defesa: {$this->jogador2->getDefesaAtual()} Mana: {$this->manaBar($this->jogador2)}\n\n";

        echo "Mana de {$atual->getNome()}: {$atual->getMana()}\n";

        echo "\nAções disponíveis:\n";
        echo "1) Atacar\n";
        echo "2) Defender\n";
        echo "3) Usar Ult\n";

        if ($resultado !== "") {
            echo "{$resultado}\n";
        }
    }

    private function exibirResumo(): void{
        system('clear');
        
        $vencedor = $this->jogador1->estaVivo() ? $this->jogador1 : $this->jogador2;

        echo "=== FIM DA BATALHA ===\n";
        echo "Vencedor: {$vencedor->getNome()} Classe: ({$vencedor->getTipo()})\n";
        echo "Turnos jogados: {$this->turnos}\n";
        echo "Vida restante: {$vencedor->getVida()} / {$vencedor->getVidaMaxima()}\n";

        echo "\n=== LOG DA BATALHA ===\n";

        foreach ($this->log as $linha) {
            echo $linha . "\n";
        }
        
    }
}
