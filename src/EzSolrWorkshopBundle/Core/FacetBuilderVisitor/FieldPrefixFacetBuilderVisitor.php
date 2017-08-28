<?php

namespace EzSolrWorkshopBundle\Core\FacetBuilderVisitor;

use EzSolrWorkshopBundle\API\Facet\FieldPrefixFacet;
use EzSolrWorkshopBundle\API\FacetBuilder\FieldPrefixFacetBuilder;
use EzSystems\EzPlatformSolrSearchEngine\Query\FacetFieldVisitor;
use EzSystems\EzPlatformSolrSearchEngine\Query\FacetBuilderVisitor;
use eZ\Publish\API\Repository\Values\Content\Query\FacetBuilder;

/**
 * Visits the FieldPrefix facet builder.
 */
class FieldPrefixFacetBuilderVisitor extends FacetBuilderVisitor implements FacetFieldVisitor
{
    public function canVisit(FacetBuilder $facetBuilder)
    {
        return $facetBuilder instanceof FieldPrefixFacetBuilder;
    }

    public function mapField($field, array $data, FacetBuilder $facetBuilder)
    {
        return new FieldPrefixFacet([
            'name' => $facetBuilder->name,
            'entries' => $this->mapData($data),
        ]);
    }

    public function visitBuilder(FacetBuilder $facetBuilder, $fieldId)
    {
        // TODO: return Solr representation of the $facetBuilder
    }
}
