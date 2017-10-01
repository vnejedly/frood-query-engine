<?php
namespace Hooloovoo\QueryEngine\DataSourceConnector;

use Hooloovoo\QueryEngine\DataSourceConnector\Exception\FieldNameException;
use Hooloovoo\QueryEngine\Filter;
use Hooloovoo\QueryEngine\Pager;
use Hooloovoo\QueryEngine\Query\Param\FilterParam;
use Hooloovoo\QueryEngine\Query\Param\SorterParam;
use Hooloovoo\QueryEngine\Query\Query;
use Hooloovoo\QueryEngine\Sorter;

/**
 * Class AbstractConnector
 */
abstract class AbstractSerialConnector extends AbstractConnector
{
    /**
     * @param Query $query
     * @throws FieldNameException
     */
    public function applyQuery(Query $query)
    {
        $this->applyFilter($query->getFilter());
        $this->applySorter($query->getSorter());
        $this->applyPager($query->getPager());
    }

    /**
     * @param Filter $filter
     * @throws FieldNameException
     */
    protected function applyFilter(Filter $filter)
    {
        foreach ($filter->getParams() as $param) {
            $this->applyFilterParam($param);
        }
    }

    /**
     * @param Sorter $sorter
     * @throws FieldNameException
     */
    protected function applySorter(Sorter $sorter)
    {
        foreach ($sorter->getParams() as $param) {
            $this->applySorterParam($param);
        }
    }

    /**
     * @param FilterParam $param
     * @throws FieldNameException
     */
    abstract protected function applyFilterParam(FilterParam $param);

    /**
     * @param SorterParam $param
     * @throws FieldNameException
     */
    abstract protected function applySorterParam(SorterParam $param);

    /**
     * @param Pager $pager
     */
    abstract protected function applyPager(Pager $pager);
}