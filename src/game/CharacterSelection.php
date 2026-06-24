<?php

class CharacterSelection{
    public function choose(int $playerNumber, string $title): Character{
        while (true) {
            system(PHP_OS_FAMILY === 'Windows' ? 'cls' : 'clear');

            echo $title . "\n\n";

            echo "===== SELEÇÃO DE PERSONAGEM =====\n\n";
            echo "Jogador *{$playerNumber}*, escolha sua classe: \n\n";
            echo "[1] Berserker - Passiva: \033[1mFúria Crescente\033[0m - Para cada 2% de vida perdida, ganha 1% de dano adicional, até o maximo de 50%.\n";
            echo "[2] Mage - Passiva: \033[1mFluxo Arcano\033[0m - Ataques básicos recuperam 5 de mana.\n";
            echo "[3] Necromancer - Passiva: \033[1mColheita de Almas\033[0m - Sempre que causar dano, o Necromante recupera uma pequena quantidade de vida.\n";
            echo "[4] Monge - Passiva: \033[1mSerenidade\033[0m - Ataques básicos consecutivos aumentam o dano em ate 60%. Defender ou usar ult reinicia os acúmulos.\n";
            echo "[5] Cavaleiro - Passiva: \033[1mPostura de Ferro\033[0m - Após defender, o proximo ataque básico causa dano adicional baseado na defesa.\n\n";

            $option = trim(readline("Digite sua classe: "));
            $name = "Jogador {$playerNumber}";

            try {
                return match ($option) {
                    "1" => new Berserker($name),
                    "2" => new Mage($name),
                    "3" => new Necromancer($name),
                    "4" => new Monk($name),
                    "5" => new Knight($name),
                    default => throw new InvalidEntryException("Opção Inválida."),
                };
            } catch (InvalidEntryException $e) {
                echo "\nErro: {$e->getMessage()}\n";
                readline("Pressione ENTER para tentar novamente...");
            }
        }
    }
}
