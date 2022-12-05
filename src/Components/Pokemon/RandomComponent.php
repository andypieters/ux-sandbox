<?php

namespace App\Components\Pokemon;

use App\Service\PokemonService;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\DefaultActionTrait;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsLiveComponent('pokemon:random')]
class RandomComponent
{
    use DefaultActionTrait;

    public function __construct(private readonly PokemonService $service)
    {
    }

    public function getPokemon(): string
    {
        $names = $this->service->getAllNames();
        $randomKey = array_rand($names, 1);

        return $names[$randomKey];
    }

}