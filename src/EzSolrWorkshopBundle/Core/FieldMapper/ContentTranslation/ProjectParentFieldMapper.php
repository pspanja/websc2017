<?php

namespace EzSolrWorkshopBundle\Core\FieldMapper\ContentTranslation;

use eZ\Publish\SPI\Persistence\Content as SPIContent;
use eZ\Publish\SPI\Search\FieldType\TextField;
use EzSystems\EzPlatformSolrSearchEngine\FieldMapper\ContentTranslationFieldMapper;
use eZ\Publish\SPI\Persistence\Content\Handler as ContentHandler;
use eZ\Publish\SPI\Persistence\Content\Type\Handler as ContentTypeHandler;
use eZ\Publish\SPI\Persistence\Content\Location\Handler as LocationHandler;
use eZ\Publish\SPI\Search\Field;

/**
 * Provides fields for indexing data from the parent Content.
 */
class ProjectParentFieldMapper extends ContentTranslationFieldMapper
{
    /**
     * @var \eZ\Publish\SPI\Persistence\Content\Handler
     */
    private $contentHandler;

    /**
     * @var \eZ\Publish\SPI\Persistence\Content\Location\Handler
     */
    private $locationHandler;

    /**
     * @var \eZ\Publish\SPI\Persistence\Content\Type\Handler
     */
    private $contentTypeHandler;

    /**
     * @param \eZ\Publish\SPI\Persistence\Content\Handler $contentHandler
     * @param \eZ\Publish\SPI\Persistence\Content\Location\Handler $locationHandler
     * @param \eZ\Publish\SPI\Persistence\Content\Type\Handler $contentTypeHandler
     */
    public function __construct(
        ContentHandler $contentHandler,
        LocationHandler $locationHandler,
        ContentTypeHandler $contentTypeHandler
    ) {
        $this->contentHandler = $contentHandler;
        $this->locationHandler = $locationHandler;
        $this->contentTypeHandler = $contentTypeHandler;
    }

    public function accept(SPIContent $content, $languageCode)
    {
        return $content->versionInfo->contentInfo->contentTypeId === 5 && $languageCode === 'eng-GB';
    }

    public function mapFields(SPIContent $content, $languageCode)
    {
        $parentTitle = '';

        // TODO: get parent title

        return [
            new Field(
                'meta_content__text',
                $parentTitle,
                new TextField()
            )
        ];
    }
}
