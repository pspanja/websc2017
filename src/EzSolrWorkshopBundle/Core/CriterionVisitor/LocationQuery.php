<?php

namespace EzSolrWorkshopBundle\Core\CriterionVisitor;

use eZ\Publish\API\Repository\Values\Content\Query\Criterion;
use EzSystems\EzPlatformSolrSearchEngine\Query\CriterionVisitor;
use EzSolrWorkshopBundle\API\Criterion\LocationQuery as LocationQueryCriterion;

/**
 * Visits the LocationQuery criterion.
 */
class LocationQuery extends CriterionVisitor
{
    /**
     * @var \EzSystems\EzPlatformSolrSearchEngine\Query\CriterionVisitor
     */
    private $locationQueryCriterionVisitor;

    /**
     * @param \EzSystems\EzPlatformSolrSearchEngine\Query\CriterionVisitor $locationQueryCriterionVisitor
     */
    public function __construct(CriterionVisitor $locationQueryCriterionVisitor)
    {
        $this->locationQueryCriterionVisitor = $locationQueryCriterionVisitor;
    }

    public function canVisit(Criterion $criterion)
    {
        return $criterion instanceof LocationQueryCriterion;
    }

    public function visit(Criterion $criterion, CriterionVisitor $subVisitor = null)
    {
        // TODO: get Location condition

        $locationCondition = str_replace('/', '\\/', $locationCondition);

        // TODO: return Location condition in Block Join Parent Query Parser
        // https://cwiki.apache.org/confluence/display/solr/Other+Parsers#OtherParsers-BlockJoinQueryParsers
    }
}
