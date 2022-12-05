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

        $this->data = $this->service->getPokemon($this->idOrName);

        dump($this->data);
        return $this->data;
    }

    public function getName(): string
    {
        return $this->getData()['name'];
    }

    public function getImage(): string
    {
        return $this->getData()['sprites']['other']['official-artwork']['front_default'] ?? '';
    }

    public function getType()
    {
        $types = $this->getData()['types'];

        $names = array_map(fn($type) => $type['type']['name'], $types);

        return implode(' / ', $names);
    }

    public function getStats()
    {
        return $this->getData()['stats'];
    }

    public function getId()
    {
        return $this->getData()['id'];
    }
}