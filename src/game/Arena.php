<?php

class Arena{
    private Character $playerOne;
    private Character $playerTwo;
    private int $turns = 0;
    private array $log = [];

    public function __construct(Character $playerOne, Character $playerTwo){
        $this->playerOne = $playerOne;
        $this->playerTwo = $playerTwo;
    }

    private function hpBar(Character $character): string{
        $width = 20;
        $health = $character->getHealth();
        $maxHealth = $character->getMaxHealth();
        $percentage = $health / $maxHealth;
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

        return "{$color}[{$bar}]\033[0m {$health}/{$maxHealth}";
    }

    private function manaBar(Character $character): string{
        $width = 10;
        $mana = $character->getMana();
        $maxMana = $character->getMaxMana();
        $percentage = $mana / $maxMana;
        $filled = (int) round($percentage * $width);
        $empty = $width - $filled;
        $color = "\033[36m";

        $bar =
            str_repeat("█", $filled) . 
            str_repeat("░", $empty);

        return "{$color}[$bar]\033[0m {$mana}/{$maxMana}";
    }

    public function start(): void{
        $currentPlayer = $this->playerOne;
        $opponent = $this->playerTwo;
        $playerNumber = 1;

        while ($this->playerOne->isAlive() && $this->playerTwo->isAlive()){
            $this->turns++;
            $currentPlayer->startTurn();

            $actionExecuted = false;
            $result = "";

            while (!$actionExecuted){
                $this->showCombatScreen($playerNumber, $currentPlayer, $opponent, $result);

                try {
                    $option = trim(readline("Escolha uma opção: "));

                    if(!in_array($option, ["1", "2", "3"])){
                        throw new InvalidEntryException("Opção Inválida.");
                    }

                    $result = match ($option) {
                        "1" => $currentPlayer->attack($opponent),
                        "2" => $currentPlayer->defend(),
                        "3" => $currentPlayer->useUltimate($opponent)
                    };

                    $this->log[] = "Turno {$this->turns}: {$result}";
                    $actionExecuted = true;
                    $this->showCombatScreen($playerNumber, $currentPlayer, $opponent, $result);

                    readline("\nPressione ENTER para continuar...");
                } catch (InsufficientManaException | InvalidEntryException $e) {
                    echo "\nErro: {$e->getMessage()}\n ";
                    readline("Pressione ENTER para tentar novamente...");
                }
            }

            [$currentPlayer, $opponent] = [$opponent, $currentPlayer];
            $playerNumber = $playerNumber === 1 ? 2 : 1;
        }
        $this->showSummary();
    }

    private function showCombatScreen(int $playerNumber, Character $currentPlayer, Character $opponent, string $result): void{
        system(PHP_OS_FAMILY === 'Windows' ? 'cls' : 'clear');

        echo "=== ARENA DE BATALHA ===\n\n";

        echo "VEZ DO JOGADOR {$playerNumber})\n\n";
        echo "{$this->playerOne->getName()} - Classe: {$this->playerOne->getType()} HP: {$this->hpBar($this->playerOne)} Defesa: {$this->playerOne->getCurrentDefense()} Mana: {$this->manaBar($this->playerOne)}\n";
        echo "{$this->playerTwo->getName()} - Classe: {$this->playerTwo->getType()} HP: {$this->hpBar($this->playerTwo)} Defesa: {$this->playerTwo->getCurrentDefense()} Mana: {$this->manaBar($this->playerTwo)}\n\n";

        echo "Mana de {$currentPlayer->getName()}: {$currentPlayer->getMana()}\n";

        echo "\nAções disponíveis:\n";
        echo "1) Atacar\n";
        echo "2) Defender\n";
        echo "3) Usar Ult\n";

        if ($result !== "") {
            echo "{$result}\n";
        }
    }

    private function showSummary(): void{
        system(PHP_OS_FAMILY === 'Windows' ? 'cls' : 'clear');
        
        $winner = $this->playerOne->isAlive() ? $this->playerOne : $this->playerTwo;

        echo "=== FIM DA BATALHA ===\n";
        echo "Vencedor: {$winner->getName()} Classe: ({$winner->getType()})\n";
        echo "Turnos jogados: {$this->turns}\n";
        echo "Vida restante: {$winner->getHealth()} / {$winner->getMaxHealth()}\n";

        echo "\n=== LOG DA BATALHA ===\n";

        foreach ($this->log as $line) {
            echo $line . "\n";
        }
    }
}
