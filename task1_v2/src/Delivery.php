<?php

namespace Gamer\Lw6;

use DateTime;
use DateInterval;
use InvalidArgumentException;

class Delivery
{
    private DateTime $createdAt;
    private DateTime $estimatedAt;
    private ?DateTime $deliveredAt;

    public function __construct(DateTime $createdAt, DateTime $estimatedAt, ?DateTime $deliveredAt = null)
    {
        if ($estimatedAt < $createdAt) {
            throw new InvalidArgumentException(
                'Плановое время доставки не может быть раньше времени создания заказа'
            );
        }
        if ($deliveredAt !== null && $deliveredAt < $createdAt) {
            throw new InvalidArgumentException(
                'Время доставки не может быть раньше времени создания заказа'
            );
        }

        $this->createdAt = $createdAt;
        $this->estimatedAt = $estimatedAt;
        $this->deliveredAt = $deliveredAt;
    }

    public function isLate(): bool
    {
        if ($this->deliveredAt !== null) {
            return $this->deliveredAt > $this->estimatedAt;
        }
        return (new DateTime()) > $this->estimatedAt;
    }

    public function getDelayMinutes(): int
    {
        if (!$this->isLate()) {
            return 0;
        }

        $finish = $this->deliveredAt ?? new DateTime();
        $diff = $finish->diff($this->estimatedAt);

        return (int)$diff->format('%a') * 24 * 60 + (int)$diff->format('%h') * 60 + (int)$diff->format('%i');
    }

    public function getDeliveryTime(): DateInterval
    {
        $end = $this->deliveredAt ?? new DateTime();
        return $this->createdAt->diff($end);
    }
}
