<?php

namespace EzSolrWorkshopBundle\API\Facet;

use eZ\Publish\API\Repository\Values\Content\Search\Facet;

/**
 * Holds field prefix facet terms and counts.
 */
class FieldPrefixFacet extends Facet
{
    /**
     * An array of terms (key) and counts (value).
     *
     * @var array
     */
    public $entries;
}
