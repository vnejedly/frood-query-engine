<?php
namespace Hooloovoo\QueryEngine\Query\Parser;

use Hooloovoo\QueryEngine\Filter;
use Hooloovoo\QueryEngine\Query\Param\FilterParam;
use Hooloovoo\QueryEngine\Query\Param\SorterParam;
use Hooloovoo\QueryEngine\Query\Parser\Exception\ParamFormatException;
use Hooloovoo\QueryEngine\Sorter;

/**
 * Class StdFormat
 */
class StdFormat implements ParserInterface
{
    const DELIMITER = '|';

    const FILTER_PATTERN = '/^([\w,\.]+)\:(\w{2})\:(.*)$/';
    const FILTER_PATTERN_NO_VALUE = '/^([\w,\.]+)\:(\w{2})$/';
    const SORTER_PATTERN = '/^(-?)([\w,\.]+)$/';

    const FILTER_TYPES = [
        'eq' => Filter::TYPE_EQ,
        'ne' => Filter::TYPE_NE,
        'gt' => Filter::TYPE_GT,
        'ge' => Filter::TYPE_GE,
        'lt' => Filter::TYPE_LT,
        'le' => Filter::TYPE_LE,
        'ct' => Filter::TYPE_CT,
        'nc' => Filter::TYPE_NC,
        'sw' => Filter::TYPE_SW,
        'ew' => Filter::TYPE_EW,
    ];

    const FILTER_TYPES_NO_VALUE = [
        'nl' => Filter::TYPE_NL,
        'nn' => Filter::TYPE_NN,
    ];

    const SORTER_DIRECTIONS = [
        '+' => Sorter::DIRECTION_ASC,
        '-' => Sorter::DIRECTION_DESC,
    ];

    /**
     * @param mixed $rawFilter
     * @return FilterParam[]
     * @throws ParamFormatException
     */
    public function getFilterParams($rawFilter) : array
    {
        $params = [];
        foreach ($this->explodeParams($rawFilter) as $rawParam) {
            try {
                $params[] = $this->resolveFilterParam($rawParam);
            } catch (ParamFormatException $exception) {
                $params[] = $this->resolveFilterParamNoValue($rawParam);
            }
        }

        return $params;
    }

    /**
     * @param mixed $rawSorter
     * @return SorterParam[]
     */
    public function getSorterParams($rawSorter) : array
    {
        $params = [];
        foreach ($this->explodeParams($rawSorter) as $rawParam) {
            $matches = $this->matchRawParam(self::SORTER_PATTERN, $rawParam);
            $params[] = new SorterParam($matches[2], $this->getSorterDirection($matches[1]));
        }

        return $params;
    }

    /**
     * @param mixed $rawOffset
     * @return int
     */
    public function getOffset($rawOffset) : int
    {
        return (int) $rawOffset;
    }

    /**
     * @param mixed $rawLimit
     * @return int
     */
    public function getLimit($rawLimit) : int
    {
        return (int) $rawLimit;
    }

    /**
     * @param string $rawParam
     * @return FilterParam
     * @throws ParamFormatException
     */
    protected function resolveFilterParam(string $rawParam) : FilterParam
    {
        $matches = $this->matchRawParam(self::FILTER_PATTERN, $rawParam);

        if (!array_key_exists($matches[2], static::FILTER_TYPES)) {
            throw new ParamFormatException("Unknown filter type: {$matches[2]}");
        }

        return new FilterParam($matches[1], $this->getFilterType($matches[2]), $matches[3]);
    }

    /**
     * @param string $rawParam
     * @return FilterParam
     * @throws ParamFormatException
     */
    protected function resolveFilterParamNoValue(string $rawParam) : FilterParam
    {
        $matches = $this->matchRawParam(self::FILTER_PATTERN_NO_VALUE, $rawParam);

        if (!array_key_exists($matches[2], static::FILTER_TYPES_NO_VALUE)) {
            throw new ParamFormatException("Unknown filter type: {$matches[2]}");
        }

        return new FilterParam($matches[1], $this->getFilterTypeNoValue($matches[2]), null);
    }

    /**
     * @param string $typeStr
     * @return int
     */
    protected function getFilterType(string $typeStr) : int
    {
        return static::FILTER_TYPES[$typeStr];
    }

    /**
     * @param string $typeStr
     * @return int
     */
    protected function getFilterTypeNoValue(string $typeStr) : int
    {
        return static::FILTER_TYPES_NO_VALUE[$typeStr];
    }

    /**
     * @param string $typeStr
     * @return bool
     * @throws ParamFormatException
     */
    protected function getSorterDirection(string $typeStr) : bool
    {
        if ($typeStr === '') {
            $typeStr = '+';
        }

        if (!array_key_exists($typeStr, self::SORTER_DIRECTIONS)) {
            throw new ParamFormatException("Wrong direction type $typeStr");
        }

        return static::SORTER_DIRECTIONS[$typeStr];
    }

    /**
     * @param string $pattern
     * @param string $rawParam
     * @return array
     * @throws ParamFormatException
     */
    protected function matchRawParam(string $pattern, string $rawParam) : array
    {
        if (!preg_match($pattern, $rawParam, $matches)) {
            throw new ParamFormatException("Wrong parameter format: $rawParam");
        }

        return $matches;
    }

    /**
     * @param string $paramsStr
     * @return array
     */
    protected function explodeParams(string $paramsStr) : array
    {
        return explode(self::DELIMITER, $paramsStr);
    }
}
