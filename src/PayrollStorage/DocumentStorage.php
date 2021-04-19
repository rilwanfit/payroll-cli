<?php

declare(strict_types=1);

namespace App\PayrollStorage;

interface DocumentStorage
{
    public function append(array $record): int;
}
