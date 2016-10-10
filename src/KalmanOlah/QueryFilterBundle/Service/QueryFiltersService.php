<?php

namespace KalmanOlah\QueryFilterBundle\Service;

use KalmanOlah\QueryFilter\FilterSet;

/**
 * Service class easing creation of filter sets.
 *
 * @author Kalman Olah <hello+php-qf@kalmanolah.net>
 * @license MIT
 */
class QueryFiltersService
{
    /**
     * @var array
     */
    protected $defaults = [
        'mongodb' => [
            'filters' => [
                'KalmanOlah\QueryFilter\MongoDB\Filter\EqualsFilter',
                'KalmanOlah\QueryFilter\MongoDB\Filter\NotEqualsFilter',
                'KalmanOlah\QueryFilter\MongoDB\Filter\LikeFilter',
                'KalmanOlah\QueryFilter\MongoDB\Filter\FalseFilter',
                'KalmanOlah\QueryFilter\MongoDB\Filter\TrueFilter',
                'KalmanOlah\QueryFilter\MongoDB\Filter\GreaterThanFilter',
                'KalmanOlah\QueryFilter\MongoDB\Filter\GreaterThanOrEqualToFilter',
                'KalmanOlah\QueryFilter\MongoDB\Filter\LessThanFilter',
                'KalmanOlah\QueryFilter\MongoDB\Filter\LessThanOrEqualToFilter',
                'KalmanOlah\QueryFilter\MongoDB\Filter\NullFilter',
                'KalmanOlah\QueryFilter\MongoDB\Filter\NotNullFilter',
                'KalmanOlah\QueryFilter\MongoDB\Filter\GeoNearFilter',
                'KalmanOlah\QueryFilter\MongoDB\Filter\OrFilter',
            ],
            'transformers' => [
                'KalmanOlah\QueryFilter\Transformer\FloatTransformer',
                'KalmanOlah\QueryFilter\Transformer\IntegerTransformer',
                'KalmanOlah\QueryFilter\MongoDB\Transformer\MongoDateTransformer',
                'KalmanOlah\QueryFilter\MongoDB\Transformer\MongoIdTransformer',
            ],
        ],

        'doctrine_orm' => [
            'filters' => [
                'KalmanOlah\QueryFilter\Doctrine\ORM\Filter\EqualsFilter',
                'KalmanOlah\QueryFilter\Doctrine\ORM\Filter\NotEqualsFilter',
                'KalmanOlah\QueryFilter\Doctrine\ORM\Filter\LikeFilter',
                'KalmanOlah\QueryFilter\Doctrine\ORM\Filter\FalseFilter',
                'KalmanOlah\QueryFilter\Doctrine\ORM\Filter\TrueFilter',
                'KalmanOlah\QueryFilter\Doctrine\ORM\Filter\GreaterThanFilter',
                'KalmanOlah\QueryFilter\Doctrine\ORM\Filter\GreaterThanOrEqualToFilter',
                'KalmanOlah\QueryFilter\Doctrine\ORM\Filter\LessThanFilter',
                'KalmanOlah\QueryFilter\Doctrine\ORM\Filter\LessThanOrEqualToFilter',
                'KalmanOlah\QueryFilter\Doctrine\ORM\Filter\NullFilter',
                'KalmanOlah\QueryFilter\Doctrine\ORM\Filter\NotNullFilter',
                'KalmanOlah\QueryFilter\Doctrine\ORM\Filter\OrFilter',
            ],
            'transformers' => [
                'KalmanOlah\QueryFilter\Transformer\FloatTransformer',
                'KalmanOlah\QueryFilter\Transformer\IntegerTransformer',
                'KalmanOlah\QueryFilter\Doctrine\ORM\Transformer\DateTimeTransformer',
            ],
        ],
    ];

    /**
     * @var array
     */
    protected $configurations = [];

    /**
     * @var array<string,FilterSet>
     */
    protected $filterSets = [];

    /**
     * Set query filter set configurations.
     *
     * @param array $configurations
     * @return QueryFiltersService
     */
    public function setConfigurations(array $configurations)
    {
        $configurations = array_replace($this->defaults, $configurations);
        $this->configurations = $configurations;

        return $this;
    }

    /**
     * Get a the given filter set by its ID.
     * If the filter set has not been generated yet,
     * it will be generated before it is returned.
     *
     * @param  string $filterSetId
     * @return FilterSet
     */
    public function get($filterSetId)
    {
        if (!isset($this->filterSets[$filterSetId])) {
            $cfg = $this->configurations[$filterSetId];

            $filters = isset($cfg['filters']) ? $cfg['filters'] : [];
            $transformers = isset($cfg['transformers']) ? $cfg['transformers'] : [];

            $filterSet = new FilterSet();

            foreach ($filters as $filter) {
                $filterSet->registerFilter(new $filter());
            }

            foreach ($transformers as $transformer) {
                $filterSet->registerTransformer(new $transformer());
            }

            $this->filterSets[$filterSetId] = $filterSet;
        }

        return $this->filterSets[$filterSetId];
    }
}
