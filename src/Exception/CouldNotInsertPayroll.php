<?php

declare(strict_types=1);

namespace App\Exception;

use RuntimeException;

class CouldNotInsertPayroll extends RuntimeException
{
    protected $message = 'Could not insert payroll record.';
}
