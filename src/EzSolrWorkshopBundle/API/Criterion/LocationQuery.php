<?php

namespace EzSolrWorkshopBundle\API\Criterion;

use eZ\Publish\API\Repository\Values\Content\Query\Criterion;
use eZ\Publish\API\Repository\Values\Content\Query\Criterion\Operator;
use eZ\Publish\API\Repository\Values\Content\Query\Criterion\Operator\Specifications;
use eZ\Publish\API\Repository\Values\Content\Query\CriterionInterface;

class LocationQuery extends Criterion implements CriterionInterface
{
    /**
     * @param \eZ\Publish\API\Repository\Values\Content\Query\Criterion $locationCriteria
     *
     * @throws \InvalidArgumentException
     */
    public function __construct(Criterion $locationCriteria)
    {
        parent::__construct(null, null, $locationCriteria);
    }

    public function getSpecifications()
    {
        return [
            new Specifications(Operator::EQ, Specifications::FORMAT_SINGLE),
        ];
    }

    public static function createFromQueryBuilder($target, $operator, $value)
    {
    }
}
