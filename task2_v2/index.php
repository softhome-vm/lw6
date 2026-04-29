<?php

require_once 'vendor/autoload.php';

use Gamer\Lw6\CarRental;

function readDate(string $prompt): ?DateTime
{
    $input = readline($prompt);

    if ($input === false || trim($input) === '') {
        return null;
    }

    return new DateTime($input);
}

function readFloat(string $prompt): float
{
    $input = readline($prompt);

    if ($input === false || !is_numeric($input)) {
        throw new Exception("Некорректное число");
    }

    return (float)$input;
}

try {
    $start = readDate("Дата начала аренды: ");
    $end = readDate("Плановая дата окончания: ");
    $returned = readDate("Фактический возврат (Enter если нет): ");
    $price = readFloat("Цена за день: ");

    if ($start === null || $end === null) {
        throw new Exception("Дата начала и окончания обязательны");
    }

    $rental = new CarRental($start, $end, $price, $returned);

    echo "\n=== Результат ===\n";
    echo "Плановых дней: " . $rental->getPlannedDays() . PHP_EOL;
    echo "Фактических дней: " . $rental->getActualDays() . PHP_EOL;
    echo "Просрочка (дней): " . $rental->getExtraDays() . PHP_EOL;
    echo "Итоговая стоимость: " . $rental->getTotalCost() . PHP_EOL;
} catch (Exception $e) {
    echo "Ошибка: " . $e->getMessage() . PHP_EOL;
}
