<?php

namespace EzSolrWorkshopBundle\Core\FacetBuilderVisitor;

use EzSystems\EzPlatformSolrSearchEngine\Query\FacetBuilderVisitor;
use EzSystems\EzPlatformSolrSearchEngine\Query\FacetFieldVisitor;
use eZ\Publish\API\Repository\Values\Content\Query\FacetBuilder;
use EzSolrWorkshopBundle\API\Facet\CustomFieldFacet;
use EzSolrWorkshopBundle\API\FacetBuilder\CustomFieldFacetBuilder;

/**
 * Visits the CustomField facet builder.
 */
class CustomFieldFacetBuilderVisitor extends FacetBuilderVisitor implements FacetFieldVisitor
{
    public function canVisit(FacetBuilder $facetBuilder)
    {
        return $facetBuilder instanceof CustomFieldFacetBuilder;
    }

    /**
     * Returns facet sort parameter.
     *
     * @param \EzSolrWorkshopBundle\API\FacetBuilder\CustomFieldFacetBuilder $facetBuilder
     *
     * @return string
     */
    private function getSort(CustomFieldFacetBuilder $facetBuilder)
    {
        switch ($facetBuilder->sort) {
            case CustomFieldFacetBuilder::COUNT_DESC:
                return 'count';
            case CustomFieldFacetBuilder::TERM_ASC:
                return 'index';
        }

        return 'index';
    }

    public function mapField($field, array $data, FacetBuilder $facetBuilder)
    {
        return new CustomFieldFacet(
            [
                'name' => $facetBuilder->name,
                'entries' => $this->mapData($data),
            ]
        );
    }

    public function visitBuilder(FacetBuilder $facetBuilder, $fieldId)
    {
        /** @var \EzSolrWorkshopBundle\API\FacetBuilder\CustomFieldFacetBuilder $facetBuilder */
        $fieldName = $facetBuilder->fieldName;

        return [
            'facet.field' => "{!ex=dt key={$fieldId}}{$fieldName}",
            "f.{$fieldName}.facet.limit" => $facetBuilder->limit,
            "f.{$fieldName}.facet.mincount" => $facetBuilder->minCount,
            "f.{$fieldName}.facet.sort" => $this->getSort($facetBuilder),
        ];
    }
}
