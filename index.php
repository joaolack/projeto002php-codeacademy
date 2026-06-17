<?php

require_once __DIR__ . "/src/Interfaces/CombatenteInterface.php";
require_once __DIR__ . "/src/Personagens/Personagem.php";
require_once __DIR__ . "/src/Personagens/Berserker.php";
require_once __DIR__ . "/src/Personagens/Mago.php";
require_once __DIR__ . "/src/Personagens/Necromante.php";
require_once __DIR__ . "/src/Personagens/Monk.php";
require_once __DIR__ . "/src/Personagens/Knight.php";
require_once __DIR__ . "/src/Jogo/Arena.php";
require_once __DIR__ . "/src/Exceptions/ManaInsuficienteException.php";
require_once __DIR__ . "/src/Exceptions/EntradaInvalidaException.php";


$title = <<<'ASCII'
                                                                                                
,-.----.           ,--,,-.----.                                                                 
\    /  \        ,--.'|\    /  \      ,----..                                           ___     
|   :    \    ,--,  | :|   :    \    /   /   \                                        ,--.'|_   
|   |  .\ :,---.'|  : '|   |  .\ :  /   .     :            ,--,                       |  | :,'  
.   :  |: ||   | : _' |.   :  |: | .   /   ;.  \         ,'_ /|             .--.--.   :  : ' :  
|   |   \ ::   : |.'  ||   |   \ :.   ;   /  ` ;    .--. |  | :    ,---.   /  /    '.;__,'  /   
|   : .   /|   ' '  ; :|   : .   /;   |  ; \ ; |  ,'_ /| :  . |   /     \ |  :  /`./|  |   |    
;   | |`-' '   |  .'. |;   | |`-' |   :  | ; | '  |  ' | |  . .  /    /  ||  :  ;_  :__,'| :    
|   | ;    |   | :  | '|   | ;    .   |  ' ' ' :  |  | ' |  | | .    ' / | \  \    `. '  : |__  
:   ' |    '   : |  : ;:   ' |    '   ;  \; /  |  :  | : ;  ; | '   ;   /|  `----.   \|  | '.'| 
:   : :    |   | '  ,/ :   : :     \   \  ',  . \ '  :  `--'   \'   |  / | /  /`--'  /;  :    ; 
|   | :    ;   : ;--'  |   | :      ;   :      ; |:  ,      .-./|   :    |'--'.     / |  ,   /  
`---'.|    |   ,/      `---'.|       \   \ .'`--"  `--`----'     \   \  /   `--'---'   ---`-'   
  `---`    '---'         `---`        `---`                       `----'                        
                                                                                                 
ASCII;


function escolherPersonagem(int $numeroJogador): Personagem{
    while (true) {
        system('clear');

        echo $GLOBALS['title'] . "\n\n";

        echo "===== SELEÇÃO DE PERSONAGEM =====\n\n";
        echo "Player *{$numeroJogador}*, choose your class: \n\n";
        echo "[1] Berserker\n";
        echo "[2] Mage\n";
        echo "[3] Necromancer\n";
        echo "[4] Monge\n";
        echo "[5] Cavaleiro\n\n";

        $opcao = trim(readline("Digite sua opção: "));
        $nome = "Jogador {$numeroJogador}";

        try {
            return match ($opcao) {
                "1" => new Berserker($nome),
                "2" => new Mago($nome),
                "3" => new Necromante($nome),
                "4" => new Monk($nome),
                "5" => new Knight($nome),
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