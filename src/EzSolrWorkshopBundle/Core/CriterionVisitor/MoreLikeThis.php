<?php

namespace EzSolrWorkshopBundle\Core\CriterionVisitor;

use eZ\Publish\API\Repository\Values\Content\Query\Criterion;
use EzSystems\EzPlatformSolrSearchEngine\DocumentMapper;
use EzSystems\EzPlatformSolrSearchEngine\Query\CriterionVisitor;
use EzSolrWorkshopBundle\API\Criterion\MoreLikeThis as MoreLikeThisCriterion;

/**
 * Visits the MoreLikeThis criterion.
 */
class MoreLikeThis extends CriterionVisitor
{
    /**
     * @var \EzSystems\EzPlatformSolrSearchEngine\DocumentMapper
     */
    private $documentMapper;

    /**
     * @param \EzSystems\EzPlatformSolrSearchEngine\DocumentMapper $documentMapper
     */
    public function __construct(DocumentMapper $documentMapper)
    {
        $this->documentMapper = $documentMapper;
    }

    public function canVisit(Criterion $criterion)
    {
        return $criterion instanceof MoreLikeThisCriterion;
    }

    public function visit(Criterion $criterion, CriterionVisitor $subVisitor = null)
    {
        // TODO: return MoreLikeThis query for Solr
        // https://cwiki.apache.org/confluence/display/solr/MoreLikeThis
        // https://cwiki.apache.org/confluence/display/solr/Other+Parsers#OtherParsers-MoreLikeThisQueryParser
    }
}
