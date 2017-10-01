<?php
namespace Hooloovoo\QueryEngine;

use Hooloovoo\QueryEngine\Query\Param\FilterParam;

/**
 * Class Filter
 */
class Filter
{
    const TYPE_EQ = 1;  // equals
    const TYPE_NE = 2;  // does not equal
    const TYPE_GT = 3;  // greater than
    const TYPE_GE = 4;  // greater or equal
    const TYPE_LT = 5;  // less than
    const TYPE_LE = 6;  // less or equal
    const TYPE_CT = 7;  // contains
    const TYPE_NC = 8;  // does not contain
    const TYPE_SW = 9;  // starts with
    const TYPE_EW = 10; // ends with
    const TYPE_NL = 11; // is null
    const TYPE_NN = 12; // is not null

    /** @var FilterParam[] */
    protected $params = [];

    /** @var FilterParam[][] */
    protected $groupedParams = [];

    /**
     * @param FilterParam $param
     */
    public function addParam(FilterParam $param)
    {
        $this->params[] = $param;
        $this->groupedParams[$param->getName()][] = $param;
    }

    /**
     * @return FilterParam[]
     */
    public function getParams() : array
    {
        return $this->params;
    }

    /**
     * @return FilterParam[][]
     */
    public function getParamsGroupedByName() : array
    {
        return $this->groupedParams;
    }
}