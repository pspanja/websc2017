<?php

namespace EzSolrWorkshopBundle\API\Criterion\Value;

use eZ\Publish\API\Repository\Values\Content\Query\Criterion\Value;

/**
 * Struct that stores extra value information for a MoreLikeThis Criterion object.
 */
class LanguageValue extends Value
{
    /**
     * Language code
     *
     * @var string
     */
    public $languageCode;

    /**
     * @param string $languageCode
     */
    public function __construct($languageCode)
    {
        $this->languageCode = $languageCode;
    }
}
