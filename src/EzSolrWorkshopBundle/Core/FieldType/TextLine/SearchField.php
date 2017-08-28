<?php

namespace EzSolrWorkshopBundle\Core\FieldType\TextLine;

use eZ\Publish\Core\FieldType\TextLine\SearchField as TextLineSearchField;
use eZ\Publish\SPI\Persistence\Content\Field;
use eZ\Publish\SPI\Persistence\Content\Type\FieldDefinition;
use eZ\Publish\SPI\Search;
use EzSolrWorkshopBundle\SPI\SearchFieldType\CaseSensitiveString;

/**
 * Override of the Core SearchField for TextLine field type.
 */
class SearchField extends TextLineSearchField
{
    public function getIndexData(Field $field, FieldDefinition $fieldDefinition)
    {
        $baseFields = parent::getIndexData($field, $fieldDefinition);

        $baseFields[] = new Search\Field(
            'cs_value',
            $field->value->data,
            new CaseSensitiveString()
        );

        return $baseFields;
    }

    public function getIndexDefinition()
    {
        $baseDefinition = parent::getIndexDefinition();

        $baseDefinition['cs_value'] = new CaseSensitiveString();

        return $baseDefinition;
    }
}
