<?php
namespace Hooloovoo\QueryEngine;

use Hooloovoo\QueryEngine\Query\RequestConnector\ConnectorInterface as RequestConnector;
use Hooloovoo\QueryEngine\Query\Parser\ParserInterface;
use Hooloovoo\QueryEngine\Query\Query;

/**
 * Class QueryFactory
 */
class QueryFactory
{
    /** @var ParserInterface */
    private $parser;

    /**
     * QueryHandlerService constructor.
     * @param ParserInterface $parser
     */
    public function __construct(ParserInterface $parser)
    {
        $this->parser = $parser;
    }

    /**
     * @param RequestConnector $requestConnector
     * @return Query
     */
    public function getQuery(RequestConnector $requestConnector) : Query
    {
        return new Query($requestConnector, $this->parser);
    }
}