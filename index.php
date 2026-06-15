<?php

require_once __DIR__ . "/src/Interfaces/CombatenteInterface.php";
require_once __DIR__ . "/src/Personagens/Personagem.php";
require_once __DIR__ . "/src/Personagens/Berserker.php";
require_once __DIR__ . "/src/Personagens/Mago.php";
require_once __DIR__ . "/src/Personagens/Necromante.php";
require_once __DIR__ . "/src/Jogo/Arena.php";
require_once __DIR__ . "/src/Exceptions/ManaInsuficienteException.php";
require_once __DIR__ . "/src/Exceptions/EntradaInvalidaException.php";


$title = <<<'ASCII'
                                                                        ,--,            
                                                                     ,---.'|            
,-.----.                                                    ,----..  |   | :      ,---, 
\    /  \                                                  /   /   \ :   : |   ,`--.' | 
;   :    \          ,--,      ,---,                       |   :     :|   ' :   |   :  : 
|   | .\ :        ,'_ /|  ,-+-. /  |            .--.--.   .   |  ;. /;   ; '   :   |  ' 
.   : |: |   .--. |  | : ,--.'|'   |   ,---.   /  /    '  .   ; /--` '   | |__ |   :  | 
|   |  \ : ,'_ /| :  . ||   |  ,"' |  /     \ |  :  /`./  ;   | ;    |   | :.'|'   '  ; 
|   : .  / |  ' | |  . .|   | /  | | /    /  ||  :  ;_    |   : |    '   :    ;|   |  | 
;   | |  \ |  | ' |  | ||   | |  | |.    ' / | \  \    `. .   | '___ |   |  ./ '   :  ; 
|   | ;\  \:  | : ;  ; ||   | |  |/ '   ;   /|  `----.   \'   ; : .'|;   : ;   |   |  ' 
:   ' | \.''  :  `--'   \   | |--'  '   |  / | /  /`--'  /'   | '/  :|   ,/    '   :  | 
:   : :-'  :  ,      .-./   |/      |   :    |'--'.     / |   :    / '---'     ;   |.'  
|   |.'     `--`----'   '---'        \   \  /   `--'---'   \   \ .'            '---'    
`---'                                 `----'                `---`                       
ASCII;


function escolherPersonagem(int $numeroJogador): Personagem{
    while (true) {
        system('clear');

        echo $GLOBALS['title'] . "\n\n";

        echo "====SELEÇÃO DE PERSONAGEM=====\n\n";
        echo "Player *{$numeroJogador}*, choose your class: \n\n";
        echo "1. Berserker\n";
        echo "2. Mage\n";
        echo "3. Necromancer\n\n";

        $opcao = trim(readline("Opção: "));
        $nome = "Jogador {$numeroJogador}";

        try {
            return match ($opcao) {
                "1" => new Berserker($nome),
                "2" => new Mago($nome),
                "3" => new Necromante($nome),
                default => throw new EntradaInvalidaException("Opção Inválida."),
            };
        } catch (EntradaInvalidaException $e) {
            echo "\nErro: {$e->getMessage()}\n";
            readline("Pressione ENTER para tentar novamente...");
        }

    }
}

$jogador1 = escolherPersonagem(1);
$jogador2 = escolherPersonagem(2);

$arena = new Arena($jogador1, $jogador2);
$arena->iniciar();