<?php

interface CombatenteInterface {
    public function atacar(Personagem $alvo): string;
    public function defender(): string;
    public function ultar(Personagem $alvo): string;
}