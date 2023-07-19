<?php
declare(strict_types = 1);

namespace App\Service\Bot;

use App\Traits\ParameterTrait;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Symfony\Component\DependencyInjection\ParameterBag\ContainerBagInterface;
use Symfony\Component\HttpFoundation\RequestStack;

class BotService
{
    use ParameterTrait;

    const TELEGRAM_BOT_URL = 'https://api.telegram.org/bot';

    private Client $client;

    public function __construct(private readonly ContainerBagInterface $params, private readonly RequestStack $requestStack)
    {
        $this->client = new Client();
    }

    public function getUpdate(): ?array
    {
        return json_decode($this->requestStack->getCurrentRequest()?->getContent() ?? '', true);
    }

    /**
     * @throws GuzzleException
     */
    public function sendMessage(int $chatId, string $text, ?array $markup = null): void
    {
        $url = $this->getTelegramApiUrlWithToken() . '/sendMessage';

        $data = [
            'text'       => $text,
            'chat_id'    => $chatId,
            'parse_mode' => 'html',
        ];

        if ($markup !== null) {
            $data['reply_markup'] = $markup;
        }

        $options = [
            'headers' => [
                'Content-Type' => 'application/json',
            ],
            'body'    => json_encode($data),
        ];

        $this->client->post($url, $options);
    }

    public function setWebHook(?string $url = null): array
    {
        $url = $url ?? trim($this->getParameter('app_url'), '/') . '/updates';

        return $this->doGetRequest('setWebhook', [
            'url' => $url,
        ]);
    }

    public function deleteWebHook(): array
    {
        return $this->doGetRequest('deleteWebhook');
    }

    /**
     * @throws GuzzleException
     */
    private function doGetRequest(string $method, array $params = []): array
    {
        $url = $this->getTelegramApiUrlWithToken() . '/' . $method;

        if (!empty($params)) {
            $url = $url . '?' . http_build_query($params);
        }

        $result = $this->client->get($url);

        return json_decode($result->getBody()->getContents(), true);
    }

    private function getTelegramApiUrlWithToken(): string
    {
        return self::TELEGRAM_BOT_URL . $this->getParameter('telegram_token');
    }

    /**
     * @throws GuzzleException
     */
    public function sendImage(int $chatId, string $text, string $filepath, ?array $markup = null): void
    {
        $url = $this->getTelegramApiUrlWithToken() . '/sendPhoto';

        $data = [
            'caption'    => $text,
            'chat_id'    => $chatId,
            'photo'      => $filepath,
            'parse_mode' => 'html',
        ];

        if ($markup !== null) {
            $data['reply_markup'] = $markup;
        }

        $options = [
            'headers' => [
                'Content-Type' => 'application/json',
            ],
            'body'    => json_encode($data),
        ];

        $this->client->post($url, $options);
    }
}
