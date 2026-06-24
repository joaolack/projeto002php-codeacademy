<?php

require_once __DIR__ . "/src/interfaces/CombatInterface.php";
require_once __DIR__ . "/src/Characters/Character.php";
require_once __DIR__ . "/src/Characters/Berserker.php";
require_once __DIR__ . "/src/Characters/Mage.php";
require_once __DIR__ . "/src/Characters/Necromancer.php";
require_once __DIR__ . "/src/Characters/Monk.php";
require_once __DIR__ . "/src/Characters/Knight.php";
require_once __DIR__ . "/src/game/Arena.php";
require_once __DIR__ . "/src/game/CharacterSelection.php";
require_once __DIR__ . "/src/Exceptions/InsufficientManaException.php";
require_once __DIR__ . "/src/Exceptions/InvalidEntryException.php";

$title = require __DIR__ . "/src/title.php";
$characterSelection = new CharacterSelection();

$playerOne = $characterSelection->choose(1, $title);
$playerTwo = $characterSelection->choose(2, $title);

$arena = new Arena($playerOne, $playerTwo);
$arena->start();
