<?php
namespace Hooloovoo\QueryEngine\Query\Parser;

use Hooloovoo\QueryEngine\Query\Param\FilterParam;
use Hooloovoo\QueryEngine\Query\Param\SorterParam;

/**
 * Interface ParserInterface
 */
interface ParserInterface
{
    /**
     * @param $rawFilter
     * @return FilterParam[]
     */
    public function getFilterParams($rawFilter) : array ;

    /**
     * @param $rawSorter
     * @return SorterParam[]
     */
    public function getSorterParams($rawSorter) : array ;

    /**
     * @param $rawOffset
     * @return int
     */
    public function getOffset($rawOffset) : int ;

    /**
     * @param $rawLimit
     * @return int
     */
    public function getLimit($rawLimit) : int ;
}