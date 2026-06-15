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

    public function iniciar(): void{
        $atual = $this->jogador1;
        $oponente = $this->jogador2;
        $numeroJogador = 1;

        while ($this->jogador1->estaVivo() && $this->jogador2->estaVivo()){
            $this->turnos++;
            $atual->iniciarTurno();

            $acaoExecutada = false;

            while (!$acaoExecutada){
                $this->exibirTelaCombate($numeroJogador, $atual, $oponente);

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

                    echo "\nRESULTADO\n";
                    $this->log[] = "Turno {$this->turnos}: {$resultado}";
                    $acaoExecutada = true;

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

    private function exibirTelaCombate(int $numeroJogador, Personagem $atual, Personagem $oponente): void{
        system('clear');

        echo "=== ARENA DE BATALHA ===\n";

        echo "Vez do Jogador {$numeroJogador})\n";
        echo "HP: {$this->jogador1->getVida()} / {$this->jogador1->getVidaMaxima()}\n";
        echo "HP: {$this->jogador2->getVida()} / {$this->jogador2->getVidaMaxima()}\n\n";

        echo "Mana de {$atual->getNome()}: {$atual->getMana()}\n";

        echo "\nAções disponíveis:\n";
        echo "1) Atacar\n";
        echo "2) Defender\n";
        echo "3) Usar Ult\n";
        echo $resultado;
    }

    private function exibirResumo(): void{
        system('clear');
        
        $vencedor = $this->jogador1->estaVivo() ? $this->jogador1 : $this->jogador2;

        echo "=== FIM DA BATALHA ===\n";
        echo "Vencedor: {$vencedor->getNome()}({$vencedor->getTipo()})\n";
        echo "Turnos jogados: {$this->turnos}\n";
        echo "Vida restante: {$vencedor->getVida()} / {$vencedor->getVidaMaxima()}\n";

        echo "\n=== LOG DA BATALHA ===\n";

        foreach ($this->log as $linha) {
            echo $linha . "\n";
        }
        
    }
} 