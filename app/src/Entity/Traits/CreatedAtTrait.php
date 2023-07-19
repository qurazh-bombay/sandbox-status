<?php
declare(strict_types = 1);

namespace App\Entity\Traits;

use DateTime;
use DateTimeZone;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Exception;

/**
 * сущности использующие этот трейт должны содержать HasLifecycleCallbacks в аннотации
 */
trait CreatedAtTrait
{
    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?DateTime $createdAt = null;

    public function getCreatedAt(): ?DateTime
    {
        return $this->createdAt;
    }

    public function setCreatedAt(DateTime $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * @throws Exception
     */
    #[ORM\PrePersist]
    public function onPrePersist(): void
    {
        if (is_null($this->createdAt)) {
            $this->createdAt = new DateTime('now', new DateTimeZone('UTC'));
        }
    }
}
