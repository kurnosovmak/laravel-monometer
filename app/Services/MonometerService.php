<?php declare(strict_types=1);

namespace LaravelMonometer\Services;

use LaravelMonometer\Drivers\Driver;
use LaravelMonometer\Exceptions\MonometerSendException;
use Monometer\ErrorData;
use Monometer\Implementation\Contract\MetricInterface;
use Monometer\Value\Counter;
use Monometer\Value\Unique;
use Monometer\Value\Value;
use RuntimeException;

class MonometerService
{
    public function driver(string $alias = null): MetricInterface
    {
        $alias = $alias ?? $this->getDefaultAlias();
        if ($alias === null) {
            throw new RuntimeException('Monometer alias is null.');
        }
        $config = $this->getConfigDriver($alias);

        if ($config['driver'] === null) {
            throw new RuntimeException('Monometer driver is null.');
        }

        /** @var Driver $driver */
        $driver = app()->make($config['driver']);

        return $driver->getImplementation($config)->getInstance();
    }

    /**
     * @throws MonometerSendException
     */
    public function sendCounter(string $metricName, array $tags, float $count, int $ts): void
    {
        $error = $this->driver()->sendCounter($metricName, new Counter($tags, $count, $ts));
        $this->errorHandle($error);
    }

    /**
     * @throws MonometerSendException
     */
    public function sendValue(string $metricName, array $tags, array $values, float $count, int $ts): void
    {
        $error = $this->driver()->sendValue($metricName, new Value($tags, $values, $count, $ts));
        $this->errorHandle($error);
    }

    /**
     * @throws MonometerSendException
     */
    public function sendUnique(string $metricName, array $tags, array $values, float $count, int $ts): void
    {
        $error = $this->driver()->sendUnique($metricName, new Unique($tags, $values, $count, $ts));
        $this->errorHandle($error);
    }

    private function getDefaultAlias(): ?string
    {
        return config('monometer.default');
    }

    private function getConfigDriver(string $alias): array
    {
        $config = config('monometer.drivers.' . $alias);
        if ($config === null) {
            throw new RuntimeException('Monometer driver config not found.');
        }

        return $config;
    }

    private function errorHandle(?ErrorData $errorData): void
    {
        if ($errorData !== null) {
            throw new MonometerSendException($errorData->getMessage());
        }
    }
}
