<?php

namespace EzSolrWorkshopBundle\API\Facet;

use eZ\Publish\API\Repository\Values\Content\Search\Facet;

/**
 * Holds custom field facet terms and counts.
 */
class CustomFieldFacet extends Facet
{
    /**
     * An array of terms (key) and counts (value).
     *
     * @var array
     */
    public $entries;
}
