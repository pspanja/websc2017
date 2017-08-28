<?php

namespace EzSolrWorkshopBundle\SPI\SearchFieldType;

use eZ\Publish\SPI\Search\FieldType\StringField;

/**
 * Represents a case-sensitive string field type in the search backend.
 */
class CaseSensitiveString extends StringField
{
    protected $type = 'ez_case_sensitive_string';
}
