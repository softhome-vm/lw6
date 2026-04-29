<?php

require_once 'vendor/autoload.php';

use Gamer\Lw6\Delivery;

function readDate(string $prompt): ?DateTime
{
    $input = (readline($prompt));

    if ($input === false || trim($input) === '') {
        return null;
    }

    return new DateTime($input);
}

try {
    $createdAt = readDate("Введите дату создания (YYYY-MM-DD HH:MM): ");

    $estimatedAt = readDate("Введите плановую дату доставки: ");
    if ($createdAt === null || $estimatedAt === null) {
        throw new Exception("Дата создания и Плановая дата доставки обязательны");
    }

    $deliveredAt = readDate("Введите фактическую дату доставки (или Enter если нет): ");

    $delivery = new Delivery($createdAt, $estimatedAt, $deliveredAt);

    echo "Опоздала ли доставка: " . ($delivery->isLate() ? "Да" : "Нет") . "\n";
    echo "Минут опоздания: " . $delivery->getDelayMinutes() . "\n";

    $interval = $delivery->getDeliveryTime();
    echo "Длительность доставки: {$interval->days} дн. {$interval->h} ч. {$interval->i} мин.\n";
} catch (Exception $e) {
    echo "Ошибка: " . $e->getMessage() . "\n";
}
