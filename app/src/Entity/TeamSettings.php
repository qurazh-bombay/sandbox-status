<?php
declare(strict_types = 1);

namespace App\Entity;

use App\Entity\Traits\IdTrait;
use App\Repository\TeamSettingsRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TeamSettingsRepository::class)]
#[ORM\Table(name: 'team_settings')]
class TeamSettings
{
    use IdTrait;

    #[ORM\Column(type: Types::INTEGER, nullable: false)]
    private int $spaceId;

    #[ORM\Column(type: Types::JSON, nullable: false)]
    private array $boardIds;

    #[ORM\Column(type: Types::JSON, nullable: false)]
    private array $sandboxIds;

    #[ORM\OneToOne(inversedBy: 'teamSettings', targetEntity: Team::class)]
    #[ORM\JoinColumn(name: 'team_id', referencedColumnName: 'id', onDelete: 'SET NULL')]
    private ?Team $team = null;

    public function getSpaceId(): int
    {
        return $this->spaceId;
    }

    public function getBoardIds(): array
    {
        return $this->boardIds;
    }

    public function getSandboxIds(): array
    {
        return $this->sandboxIds;
    }

    public function getTeam(): ?Team
    {
        return $this->team;
    }
}
