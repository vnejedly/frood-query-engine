<?php
namespace Hooloovoo\QueryEngine\Query\RequestConnector;

use Hooloovoo\QueryEngine\Query\RequestConnector\Exception\NoParamException;

/**
 * Interface ConnectorInterface
 */
interface ConnectorInterface
{
    /**
     * @return mixed
     * @throws NoParamException
     */
    public function getRawFilter();

    /**
     * @return mixed
     * @throws NoParamException
     */
    public function getRawSorter();

    /**
     * @return mixed
     */
    public function getRawOffset();

    /**
     * @return mixed
     */
    public function getRawLimit();
}