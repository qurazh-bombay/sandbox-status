<?php
declare(strict_types = 1);

namespace App\Service\Kaiten;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Symfony\Component\HttpFoundation\Response;

class RequestService
{
    private readonly Client $client;

    public function __construct()
    {
        $this->client = new Client();
    }

    public function getRequestData(string $url, string $auth): array
    {
        try {
            $response = $this->client->get(
                $url,
                [
                    'headers' => [
                        'Accept'        => 'application/json',
                        'Content-Type'  => 'application/json',
                        'Authorization' => $auth,
                    ],
                ]
            );

            return json_decode($response->getBody()->getContents(), true);
        } catch (GuzzleException) {
            return [];
        }
    }

    public function getKaitenActiveCardsFetchUrl(string $url, int $boardId): string
    {
        return $url . "?archived=false&board_id={$boardId}&states=1,2";
    }

    public function isUrlAvailable(string $url): bool
    {
        $response = false;

        try {
            $request  = $this->client->get($url);
            $response = $request->getStatusCode() === Response::HTTP_OK;
        } catch (\Throwable) {

        }

        return $response;
    }
}
