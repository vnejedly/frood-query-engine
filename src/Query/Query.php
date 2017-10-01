<?php
namespace Hooloovoo\QueryEngine\Query;

use Hooloovoo\QueryEngine\Query\RequestConnector\Exception\NoParamException;
use Hooloovoo\QueryEngine\Query\RequestConnector\ConnectorInterface as RequestConnector;
use Hooloovoo\QueryEngine\Query\Parser\ParserInterface;
use Hooloovoo\QueryEngine\Filter;
use Hooloovoo\QueryEngine\Sorter;
use Hooloovoo\QueryEngine\Pager;

/**
 * Class Query
 */
class Query
{
    /** @var RequestConnector */
    private $requestConnector;

    /** @var ParserInterface */
    private $parser;

    /**
     * Query constructor.
     *
     * @param RequestConnector $requestConnector
     * @param ParserInterface $parser
     */
    public function __construct(RequestConnector $requestConnector, ParserInterface $parser)
    {
        $this->requestConnector = $requestConnector;
        $this->parser = $parser;
    }

    /**
     * @return Filter
     */
    public function getFilter() : Filter
    {
        $filter = new Filter();

        try {
            $rawFilter = $this->requestConnector->getRawFilter();
        } catch (NoParamException $exception) {
            return $filter;
        }

        foreach ($this->parser->getFilterParams($rawFilter) as $param) {
            $filter->addParam($param);
        }

        return $filter;
    }

    /**
     * @return Sorter
     */
    public function getSorter() : Sorter
    {
        $sorter = new Sorter();

        try {
            $rawSorter = $this->requestConnector->getRawSorter();
        } catch (NoParamException $exception) {
            return $sorter;
        }

        foreach ($this->parser->getSorterParams($rawSorter) as $param) {
            $sorter->addParam($param);
        }

        return $sorter;
    }

    /**
     * @return Pager
     */
    public function getPager() : Pager
    {
        $pager = new Pager();

        $pager->setOffset($this->parser->getOffset($this->requestConnector->getRawOffset()));
        $pager->setLimit($this->parser->getLimit($this->requestConnector->getRawLimit()));

        return $pager;
    }
}