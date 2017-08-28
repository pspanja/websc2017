<?php

namespace EzSolrWorkshopBundle\API\FacetBuilder;

use eZ\Publish\API\Repository\Values\Content\Query\FacetBuilder;

/**
 * Builds a custom field facet.
 */
class CustomFieldFacetBuilder extends FacetBuilder
{
    /**
     * Sort by facet count descending.
     */
    const COUNT_DESC = 1;

    /**
     * Sort by facet term ascending.
     */
    const TERM_ASC = 2;

    /**
     * Name of the field in the Solr backend.
     *
     * @var string
     */
    public $fieldName;

    /**
     * The sort order of the terms.
     *
     * One of CustomFieldFacetBuilder::COUNT_DESC, CustomFieldFacetBuilder::TERM_ASC.
     *
     * @var mixed
     */
    public $sort;
}
