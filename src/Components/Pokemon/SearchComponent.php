<?php

namespace App\Components\Pokemon;

use App\Service\PokemonService;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\DefaultActionTrait;

#[AsLiveComponent('pokemon:search')]
class SearchComponent
{
    use DefaultActionTrait;

    #[LiveProp(writable: true)]
    public ?string $search = null;

    #[LiveProp]
    public int $limit = 10;

    public function __construct(private readonly PokemonService $service)
    {
    }

    public function getResults(): array
    {
        return $this->service->search($this->search, $this->limit);
    }
}