<?php

namespace EzSolrWorkshopBundle\Core\FieldMapper\Content;

use eZ\Publish\Core\Persistence\FieldTypeRegistry;
use EzSystems\EzPlatformSolrSearchEngine\FieldMapper\ContentFieldMapper;
use eZ\Publish\SPI\Persistence\Content;
use eZ\Publish\Core\Search\Common\FieldNameGenerator;
use eZ\Publish\SPI\Persistence\Content\Type\Handler as ContentTypeHandler;
use eZ\Publish\SPI\Search\Field;
use eZ\Publish\SPI\Search\FieldType;

/**
 * Indexes information whether Content field is empty.
 */
class IsFieldEmptyFieldMapper extends ContentFieldMapper
{
    /**
     * @var \eZ\Publish\SPI\Persistence\Content\Type\Handler
     */
    private $contentTypeHandler;

    /**
     * @var \eZ\Publish\Core\Search\Common\FieldNameGenerator
     */
    private $fieldNameGenerator;

    /**
     * @var \eZ\Publish\Core\Persistence\FieldTypeRegistry
     */
    private $fieldTypeRegistry;

    /**
     * @param \eZ\Publish\SPI\Persistence\Content\Type\Handler $contentTypeHandler
     * @param \eZ\Publish\Core\Search\Common\FieldNameGenerator $fieldNameGenerator
     * @param \eZ\Publish\Core\Persistence\FieldTypeRegistry $fieldTypeRegistry
     */
    public function __construct(
        ContentTypeHandler $contentTypeHandler,
        FieldNameGenerator $fieldNameGenerator,
        FieldTypeRegistry $fieldTypeRegistry
    ) {
        $this->contentTypeHandler = $contentTypeHandler;
        $this->fieldNameGenerator = $fieldNameGenerator;
        $this->fieldTypeRegistry = $fieldTypeRegistry;
    }

    public function accept(Content $content)
    {
        return true;
    }

    public function mapFields(Content $content)
    {
        $fields = [];
        $contentType = $this->contentTypeHandler->load(
            $content->versionInfo->contentInfo->contentTypeId
        );

        foreach ($content->fields as $field) {
            foreach ($contentType->fieldDefinitions as $fieldDefinition) {
                if ($fieldDefinition->id !== $field->fieldDefinitionId) {
                    continue;
                }

                /** @var \EzSolrWorkshopBundle\Core\Persistence\FieldType $fieldType */
                $fieldType = $this->fieldTypeRegistry->getFieldType($fieldDefinition->fieldType);

                $fields[] = new Field(
                    $name = $this->fieldNameGenerator->getName(
                        'is_empty',
                        $fieldDefinition->identifier,
                        $contentType->identifier
                    ),
                    $fieldType->isEmptyValue($field->value),
                    new FieldType\BooleanField()
                );
            }
        }

        //return [];
        return $fields;
    }
}
