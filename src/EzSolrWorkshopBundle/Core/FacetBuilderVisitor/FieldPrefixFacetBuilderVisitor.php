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
        /** @var \EzSolrWorkshopBundle\API\FacetBuilder\FieldPrefixFacetBuilder $facetBuilder */
        $fieldName = $facetBuilder->fieldName;

        return [
            'facet.field' => "{!ex=dt key={$fieldId}}{$fieldName}",
            "f.{$fieldName}.facet.prefix" => $facetBuilder->prefix,
            "f.{$fieldName}.facet.limit" => $facetBuilder->limit,
            "f.{$fieldName}.facet.mincount" => $facetBuilder->minCount,
        ];
    }
}
