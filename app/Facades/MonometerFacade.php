<?php declare(strict_types=1);

namespace LaravelMonometer\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static driver(string $alias = null): MetricInterface
 * @method static sendCounter(string $metricName, array $tags, float $count, int $ts): void
 * @method static sendValue(string $metricName, array $tags, array $values, float $count, int $ts): void
 * @method static sendUnique(string $metricName, array $tags, array $values, float $count, int $ts): void
 */
class MonometerFacade extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'monometer';
    }
}
