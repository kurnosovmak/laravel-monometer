<?php declare(strict_types=1);

namespace LaravelMonometer\Drivers;

use Monometer\Driver\StatsHouseDriver as MonometerStatsHouseDriver;
use VK\StatsHouse\StatsHouse;

class StatsHouseDriver implements Driver
{
    public function getImplementation(array $data): MonometerStatsHouseDriver
    {
        return new MonometerStatsHouseDriver(
            new StatsHouse($this->getAddr($data))
        );
    }

    private function getAddr(array $data): string
    {
        return (string) $data['addr'];
    }
}
