<?php
declare(strict_types = 1);

namespace App\ArgumentResolver;

use App\Service\Bot\BotService;
use App\Service\Bot\Parser\TelegramRequest;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ArgumentValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;

class TelegramRequestResolver implements ArgumentValueResolverInterface
{
    public function __construct(private readonly BotService $botService)
    {
    }

    public function supports(Request $request, ArgumentMetadata $argument): bool
    {
        return TelegramRequest::class === $argument->getType();
    }

    public function resolve(Request $request, ArgumentMetadata $argument): iterable
    {
        $input = $this->botService->getUpdate();

        if (!key_exists('update_id', $input)) {
            yield new TelegramRequest();
            return;
        }

        $updateId = $input['update_id'];

        if (key_exists('callback_query', $input)) {
            $rawData = $input['callback_query'];
            $content = $rawData['data'];
            $chatId  = $rawData['message']['chat']['id'];
        } else {
            $rawData = $input['message'];
            $content = $rawData['text'];
            $chatId  = $rawData['chat']['id'];
        }

        $userInfo = $rawData['from'];

        $telegramRequest           = new TelegramRequest();
        $telegramRequest->updateId = $updateId;
        $telegramRequest->chatId   = $chatId;
        $telegramRequest->rawData  = $rawData;
        $telegramRequest->content  = strtolower($content);
        $telegramRequest->userInfo = $userInfo;

        yield $telegramRequest;
    }
}
