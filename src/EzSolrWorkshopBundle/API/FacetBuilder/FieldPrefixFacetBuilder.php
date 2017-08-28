<?php

namespace EzSolrWorkshopBundle\API\FacetBuilder;

use eZ\Publish\API\Repository\Values\Content\Query\FacetBuilder;

/**
 * Builds a field prefix facet.
 */
class FieldPrefixFacetBuilder extends FacetBuilder
{
    /**
     * Prefix for the facet field.
     *
     * @var string
     */
    public $prefix;

    /**
     * Name of the field in the Solr backend.
     *
     * @var string
     */
    public $fieldName;
}
