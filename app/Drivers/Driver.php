<?php declare(strict_types=1);

namespace LaravelMonometer\Drivers;

use Monometer\Driver\Contract\DriverInterface;

interface Driver
{
    public function getImplementation(array $data): DriverInterface;
}
