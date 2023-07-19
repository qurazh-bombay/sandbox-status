<?php
declare(strict_types = 1);

namespace App\Service;

use App\Entity\Team;
use App\Entity\User;
use App\Repository\TeamRepository;
use App\Repository\UserRepository;
use App\Service\Bot\Parser\TelegramRequest;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class UserService
{
    public function __construct(
        private readonly UserRepository     $userRepository,
        private readonly TeamRepository     $teamRepository,
        private readonly ValidatorInterface $validator
    ) {
    }

    public function setTeam(TelegramRequest $request): User
    {
        $user = $this->userRepository->findOneBy(['chatId' => $request->chatId]);
        $team = $this->teamRepository->findOneBy(['slug' => trim($request->content, '/')]);

        if (!$team instanceof Team) {
            throw new BadRequestException('Такая команда разработки не найдена');
        }

        if (!$user instanceof User) {
            $user = $this->createUser($request);
        }

        $user->setTeam($team);

        $this->userRepository->persistAndSave($user);

        return $user;
    }

    private function createUser(TelegramRequest $request): User
    {
        $user = new User();

        $user->setChatId($request->chatId);
        $user->setInfo(json_encode($request->userInfo, JSON_UNESCAPED_UNICODE));

        $errors = $this->validator->validate($user);

        if (count($errors) > 0) {
            throw new BadRequestException((string) $errors);
        }

        return $user;
    }

    public function getUser(TelegramRequest $request): ?User
    {
        return  $this->userRepository->findOneBy(['chatId' => $request->chatId]);
    }
}