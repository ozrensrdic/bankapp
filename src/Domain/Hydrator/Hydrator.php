<?php


namespace App\Domain\Hydrator;

use samdark\hydrator\Hydrator as ParentHydrator;

class Hydrator
{
    /**
     * @param string $class
     * @param array $data
     * @return mixed
     */
    public function factory(string $class, array $data): mixed
    {
        $hydrator = new ParentHydrator($class::$hydratorMap);

        return $hydrator->hydrate($data, $class);
    }
}