<?php
declare(strict_types = 1);

namespace App\Service;

use App\Traits\ParameterTrait;
use Symfony\Component\DependencyInjection\ParameterBag\ContainerBagInterface;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;

class HealthService
{
    use ParameterTrait;

    public function __construct(private readonly ContainerBagInterface $params)
    {
    }

    public function checkEnvironmentVariables(): void
    {
        $fetch_cards_url = $this->getParameter('fetch_cards_url');
        $link_prop_id    = $this->getParameter('link_prop_id');
        $auth            = $this->getParameter('auth');
        $telegram_token  = $this->getParameter('telegram_token');
        $app_url         = $this->getParameter('app_url');

        if (!$fetch_cards_url || !is_string($fetch_cards_url)) {
            throw new BadRequestException('параметр fetch_cards_url не задан!');
        }
        if (!$link_prop_id || !is_string($link_prop_id)) {
            throw new BadRequestException('параметр link_prop_id не задан!');
        }
        if (!$auth || !is_string($auth)) {
            throw new BadRequestException('параметр auth не задан!');
        }
        if (!$telegram_token || !is_string($telegram_token)) {
            throw new BadRequestException('параметр telegram_token не задан!');
        }
        if (!$app_url || !is_string($app_url)) {
            throw new BadRequestException('параметр app_url не задан!');
        }
    }
}
