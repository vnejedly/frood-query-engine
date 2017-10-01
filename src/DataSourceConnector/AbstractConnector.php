<?php
namespace Hooloovoo\QueryEngine\DataSourceConnector;

use Hooloovoo\QueryEngine\DataSourceConnector\Exception\FieldNameException;

/**
 * Class AbstractConnector
 */
abstract class AbstractConnector implements ConnectorInterface
{
    /**
     * @param string $fieldAlias
     * @param array $fieldMapping
     * @return string
     * @throws FieldNameException
     */
    protected function translateField(string $fieldAlias, array $fieldMapping) : string
    {
        if (!array_key_exists($fieldAlias, $fieldMapping)) {
            throw new FieldNameException("Unknown field $fieldAlias");
        }

        return $fieldMapping[$fieldAlias];
    }
}