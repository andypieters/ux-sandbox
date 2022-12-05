<?php

namespace App\Service;

use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Contracts\Cache\ItemInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class PokemonService
{
    public function __construct(private HttpClientInterface $httpClient, private CacheInterface $cache)
    {
    }

    public function getPokemon($idOrName): array
    {
        return $this->cache->get('pokemon-'.$idOrName, function (ItemInterface $item) use ($idOrName) {
            $item->expiresAfter(3600);

            $response = $this->httpClient->request('GET', 'https://pokeapi.co/api/v2/pokemon/'.$idOrName.'/');
            $content = $response->getContent();

            return json_decode($content, true);
        });
    }

    private function getAllNames(): array
    {
        return $this->cache->get('pokemon-all-names', function (ItemInterface $item) {
            $item->expiresAfter(3600);

            $response = $this->httpClient->request('GET', 'https://pokeapi.co/api/v2/pokemon?limit=100000&offset=0');
            $content = $response->getContent();

            $result = json_decode($content, true);

            $pokemon = $result['results'];

            return array_map(fn($item) => $item['name'], $pokemon);
        });
    }

    public function search(?string $search, int $limit = 10): array
    {
        $key = 'pokemon-search-'.$limit.'-'.$search;

        return $this->cache->get($key, function (ItemInterface $item) use ($search, $limit) {
            $results = $this->getAllNames();

            if (!empty($search)) {
                $results = array_filter(
                    $results,
                    fn($pokemon) => str_contains(strtolower($pokemon), strtolower($search))
                );
            }

            return array_slice($results, 0, $limit);
        });
    }
}