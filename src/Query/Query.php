<?php
namespace Hooloovoo\QueryEngine\Query;

use Hooloovoo\QueryEngine\Query\Param\FilterParam;
use Hooloovoo\QueryEngine\Query\Param\SorterParam;
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
    protected $requestConnector;

    /** @var ParserInterface */
    protected $parser;

    /** @var bool */
    protected $suppressFilter = false;

    /** @var string[] */
    protected $suppressedFilterParams = [];

    /** @var SorterParam[] */
    protected $emptySorterParams = [];
    
    /** @var FilterParam[] */
    protected $defaultFilterParams = [];

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
        
        foreach ($this->defaultFilterParams as $param) {
            $filter->addParam($param);
        }

        if ($this->suppressFilter) {
            return $filter;
        }

        try {
            $rawFilter = $this->requestConnector->getRawFilter();
        } catch (NoParamException $exception) {
            return $filter;
        }

        foreach ($this->parser->getFilterParams($rawFilter) as $param) {
            if (!array_key_exists($param->getName(), $this->suppressedFilterParams)) {
                $filter->addParam($param);
            }
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
            foreach ($this->emptySorterParams as $param) {
                $sorter->addParam($param);
            }
            
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

    /**
     * @param string $filterParamName
     * @return bool
     */
    protected function isSuppressed(string $filterParamName) : bool
    {
        return array_key_exists($filterParamName, $this->suppressedFilterParams);
    }

    /**
     * @param FilterParam $filterParam
     */
    public function addDefaultFilterParam(FilterParam $filterParam)
    {
        $this->defaultFilterParams[] = $filterParam;
    }

    /**
     * @param SorterParam $sorterParam
     */
    public function addEmptySorterParam(SorterParam $sorterParam)
    {
        $this->emptySorterParams[] = $sorterParam;
    }

    /**
     * @param bool $suppress
     */
    public function suppressFilter(bool $suppress = true)
    {
        $this->suppressFilter = $suppress;
    }

    /**
     * @param string $paramName
     */
    public function suppressFilterParam(string $paramName)
    {
        $this->suppressedFilterParams[$paramName] = true;
    }

    /**
     * @param string $paramName
     */
    public function unSuppressFilterParam(string $paramName)
    {
        if ($this->isSuppressed($paramName)) {
            unset($this->suppressedFilterParams[$paramName]);
        }
    }

    /**
     * Un-suppresses all filter params
     */
    public function unSuppressFilterParams()
    {
        $this->suppressedFilterParams = [];
    }
}