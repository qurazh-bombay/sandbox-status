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
trait UpdatedAtTrait
{
    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?DateTime $updatedAt = null;

    public function getUpdatedAt(): ?DateTime
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(DateTime $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * @throws Exception
     */
    #[ORM\PreUpdate]
    public function onPreUpdate(): void
    {
        if (is_null($this->updatedAt)) {
            $this->updatedAt = new DateTime('now', new DateTimeZone('UTC'));
        }
    }
}
