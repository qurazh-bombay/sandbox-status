<?php
declare(strict_types = 1);

namespace App\Service\Kaiten;

use App\Entity\TeamSettings;
use App\Traits\ParameterTrait;
use Symfony\Component\DependencyInjection\ParameterBag\ContainerBagInterface;

class KaitenService
{
    use ParameterTrait;

    public function __construct(
        private readonly ContainerBagInterface $params,
        private readonly KaitenParser          $parser,
        private readonly RequestService        $client
    ) {
    }

    public function testGetSpaces(): array
    {
        $url  = 'https://divan.kaiten.ru/api/latest/spaces';
        $auth = $this->getParameter('auth');

        return $this->client->getRequestData($url, $auth);
    }

    public function fetchTakenSandboxes(TeamSettings $teamSettings): array
    {
        $cards          = $this->fetch($teamSettings->getBoardIds());
        $linkPropertyId = $this->getParameter('link_prop_id');

        return $this->parser->getTakenSandboxesData($cards, $teamSettings->getSpaceId(), $linkPropertyId);
    }

    public function fetchFreeSandboxes(TeamSettings $teamSettings): array
    {
        $cards = $this->fetch($teamSettings->getBoardIds());

        return $this->parser->getFreeSandboxesData($cards, $teamSettings->getSandboxIds());
    }

    private function fetch(array $boardIds): array
    {
        $response            = [];
        $auth                = $this->getParameter('auth');
        $kaitenFetchCardsUrl = $this->getParameter('fetch_cards_url');
        $linkPropertyId      = $this->getParameter('link_prop_id');

        foreach ($boardIds as $boardId) {
            $url        = $this->client->getKaitenActiveCardsFetchUrl($kaitenFetchCardsUrl, $boardId);
            $boardCards = $this->client->getRequestData($url, $auth);
            $response   = array_merge($response, $boardCards);
        }

        return $this->parser->getCardsWithSandboxUrl($response, $linkPropertyId);
    }

    public function getHtml(array $item): string
    {
        return $this->parser->getHtml($item);
    }

    public function isUrlAvailable(string $url): bool
    {
        return $this->client->isUrlAvailable($url);
    }
}
