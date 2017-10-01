<?php
namespace Hooloovoo\QueryEngine;
use Hooloovoo\QueryEngine\Query\Param\SorterParam;

/**
 * Class Sorter
 */
class Sorter
{
    const DIRECTION_ASC = true;
    const DIRECTION_DESC = false;

    /** @var SorterParam[] */
    protected $params = [];

    /**
     * @param SorterParam $param
     */
    public function addParam(SorterParam $param)
    {
        $this->params[$param->getName()] = $param;
    }

    /**
     * @return SorterParam[]
     */
    public function getParams() : array
    {
        return $this->params;
    }
}