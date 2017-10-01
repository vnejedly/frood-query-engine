<?php
namespace Hooloovoo\QueryEngine\Query\Param;

/**
 * Class FilterParam
 */
class FilterParam
{
    /** @var string */
    private $name;

    /** @var int */
    private $type;

    /** @var mixed */
    private $value;

    /**
     * FilterParam constructor.
     *
     * @param string $name
     * @param int $type
     * @param $value
     */
    public function __construct(string $name, int $type, $value)
    {
        $this->name = $name;
        $this->type = $type;
        $this->value = $value;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return int
     */
    public function getType(): int
    {
        return $this->type;
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }
}