<?php
declare(strict_types = 1);

namespace App\Service\Kaiten;

class KaitenParser
{
    public function getCardsWithSandboxUrl(array $cards, string $linkPropertyId): array
    {
        $carsWithUrl = $this->getCardsWithSetSandboxUrls($cards, $linkPropertyId);

        return $this->selectCardsWithBackendSandboxUrls($carsWithUrl, $linkPropertyId);
    }

    /**
     * выбирает карточки где добавлен url
     */
    private function getCardsWithSetSandboxUrls(array $cards, string $linkPropertyId): array
    {
        $cardsWithUrl = [];

        foreach ($cards as $card) {
            if (is_null($card['properties'])) {
                continue;
            }

            if (array_key_exists($linkPropertyId, $card['properties'])) {
                $cardsWithUrl[] = $card;
            }
        }

        return $cardsWithUrl;
    }

    /**
     * выбирает карточки, где в песочке есть бэкенд
     */
    private function selectCardsWithBackendSandboxUrls(array $cards, string $linkPropertyId): array
    {
        $cardsWithSandboxUrl = [];
        $divanUrlPattern     = "/(?:divan|samolet)([1-9][0-9]?[0-9]?)(?:[a-z][a-z])?\.intranet\.hhw\.ru/ius";

        foreach ($cards as $card) {
            if (preg_match($divanUrlPattern, $card['properties'][$linkPropertyId], $matches)) {
                $cardsWithSandboxUrl[] = array_merge($card, ['sandbox_id' => $matches[1]]);
            }
        }

        return $cardsWithSandboxUrl;
    }

    public function getTakenSandboxesData(array $cards, int $spaceId, string $linkPropertyId): array
    {
        $takenSandboxData = array_map(function (array $card) use ($linkPropertyId, $spaceId) {
            return [
                'sandboxId'   => $card['sandbox_id'],
                'sandboxUrl'  => $card['properties'][$linkPropertyId],
                'columnTitle' => $card['column']['title'],
                'cardTitle'   => $card['title'],
                'cardUrl'     => sprintf('https://divan.kaiten.ru/space/%s/card/%s', $spaceId, $card['id']),
            ];
        }, $cards);

        usort($takenSandboxData, fn(array $a, array $b) => $a['sandboxId'] <=> $b['sandboxId']);

        return $takenSandboxData;
    }

    public function getFreeSandboxesData(array $cards, array $sandboxIds): array
    {
        $takenSandboxIds = array_map(fn(array $card) => (int) $card['sandbox_id'], $cards);

        return array_values(array_diff($sandboxIds, $takenSandboxIds));
    }

    public function getHtml(array $item): string
    {
        $sandBoxLink = sprintf('<a href="%s">%s</a>', $item['sandboxUrl'], $item['sandboxId']);
        $CardLink    = sprintf('<a href="%s">%s</a>', $item['cardUrl'], $item['cardTitle']);

        return <<<HTML
Номер песочки: <b>{$sandBoxLink}</b>
Колонка: <b>{$item['columnTitle']}</b>
Карточка: <b>{$CardLink}</b>
HTML;
    }
}
