<?php

interface CombatInterface {
    public function attack(Character $target): string;
    public function defend(): string;
    public function useUltimate(Character $target): string;
}
