<?php

namespace Gamer\Lw6;

use DateTime;
use DateInterval;
use InvalidArgumentException;

class CarRental
{
    private DateTime $startDate;
    private DateTime $endDate;
    private ?DateTime $returnedAt;
    private float $pricePerDay;

    public function __construct(
        DateTime $startDate,
        DateTime $endDate,
        float $pricePerDay,
        ?DateTime $returnedAt = null
    ) {
        if ($endDate < $startDate) {
            throw new InvalidArgumentException('Дата окончания раньше начала');
        }

        if ($returnedAt !== null && $returnedAt < $startDate) {
            throw new InvalidArgumentException('Возврат раньше начала аренды');
        }

        if ($pricePerDay <= 0) {
            throw new InvalidArgumentException('Цена должна быть > 0');
        }

        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->returnedAt = $returnedAt;
        $this->pricePerDay = $pricePerDay;
    }

    public function getPlannedDays(): int
    {
        $diff = $this->startDate->diff($this->endDate);
        return (int)$diff->days;
    }
    
    public function getActualDays(): int
    {
        $end = $this->returnedAt ?? new DateTime();
        $diff = $this->startDate->diff($end);
        return (int)$diff->days;
    }

    public function getExtraDays(): int
    {
        $extra = $this->getActualDays() - $this->getPlannedDays();
        return $extra > 0 ? $extra : 0;
    }

    public function getTotalCost(): float
    {
        return $this->getActualDays() * $this->pricePerDay;
    }
}
