<?php
namespace Hooloovoo\QueryEngine\DataSourceConnector;

use Hooloovoo\QueryEngine\DataSourceConnector\Exception\FieldNameException;
use Hooloovoo\QueryEngine\Query\Query;

/**
 * Interface ConnectorInterface
 */
interface ConnectorInterface
{
    /**
     * @param Query $query
     * @throws FieldNameException
     */
    public function applyQuery(Query $query);
}