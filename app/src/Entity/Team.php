<?php
declare(strict_types = 1);

namespace App\Entity;

use App\Entity\Traits\IdTrait;
use App\Repository\TeamRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TeamRepository::class)]
#[ORM\Table(name: 'teams')]
class Team
{
    use IdTrait;

    #[ORM\Column(length: 255)]
    private string $title;

    #[ORM\Column(length: 255)]
    private string $slug;

    /**
     * @var Collection|User[]
     */
    #[ORM\OneToMany(
        mappedBy: 'team',
        targetEntity: User::class,
        cascade: ['persist'],
        fetch: 'EXTRA_LAZY',
        orphanRemoval: true
    )]
    private Collection|array $users;

    #[ORM\OneToOne(mappedBy: 'team', targetEntity: TeamSettings::class, cascade: ['persist'], fetch: 'EXTRA_LAZY')]
    private ?TeamSettings $teamSettings = null;

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function getTeamSettings(): ?TeamSettings
    {
        return $this->teamSettings;
    }
}
