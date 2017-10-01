<?php
namespace Hooloovoo\QueryEngine\Query\Param;

/**
 * Class SorterParam
 */
class SorterParam
{
    /** @var string */
    private $name;

    /** @var bool */
    private $direction;

    /**
     * SorterParam constructor.
     *
     * @param string $name
     * @param bool $direction
     */
    public function __construct(string $name, bool $direction)
    {
        $this->name = $name;
        $this->direction = $direction;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return bool
     */
    public function getDirection(): bool
    {
        return $this->direction;
    }
}