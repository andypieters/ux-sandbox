<?php

namespace App\Components\Pokemon;

use App\Service\PokemonService;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent('pokemon:pokemon')]
class PokemonComponent
{
    public int|string $idOrName;

    private array $data;

    public function __construct(private readonly PokemonService $service)
    {
    }

    public function getData(): array
    {
        if (isset($this->data)) {
            return $this->data;
        }

        return $this->data = $this->service->getPokemon($this->idOrName);
    }

    public function getName(): string
    {
        return $this->getData()['name'];
    }

    public function getImage(): string
    {
        return $this->getData()['sprites']['other']['official-artwork']['front_default'] ?? '';
    }
}