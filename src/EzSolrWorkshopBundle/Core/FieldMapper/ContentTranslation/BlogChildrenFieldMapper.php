<?php

namespace EzSolrWorkshopBundle\Core\FieldMapper\ContentTranslation;

use eZ\Publish\API\Repository\SearchService;
use eZ\Publish\API\Repository\Values\Content\Content;
use eZ\Publish\API\Repository\Values\Content\Query;
use eZ\Publish\API\Repository\Values\Content\Query\Criterion;
use eZ\Publish\Core\FieldType\Author\Value;
use eZ\Publish\SPI\Persistence\Content as SPIContent;
use eZ\Publish\SPI\Search\FieldType\TextField;
use EzSystems\EzPlatformSolrSearchEngine\FieldMapper\ContentTranslationFieldMapper;
use eZ\Publish\SPI\Search\Field;

/**
 * Provides fields for indexing data from the children Content.
 */
class BlogChildrenFieldMapper extends ContentTranslationFieldMapper
{
    /**
     * @var \eZ\Publish\API\Repository\SearchService
     */
    private $filterService;

    /**
     * @param \eZ\Publish\API\Repository\SearchService $filterService
     */
    public function __construct(SearchService $filterService)
    {
        $this->filterService = $filterService;
    }

    public function accept(SPIContent $content, $languageCode)
    {
        return $content->versionInfo->contentInfo->contentTypeId === 17 && $languageCode === 'eng-GB';
    }

    public function mapFields(SPIContent $content, $languageCode)
    {
        $authorSets = [];

        // TODO: fetch authors from $content (main Location) children

        $authors = array_merge(...$authorSets);

        return [
            new Field(
                'meta_content__text',
                array_filter($authors),
                new TextField()
            )
        ];
    }

    /**
     * Extracts author names from the given Author $value.
     *
     * @param \eZ\Publish\Core\FieldType\Author\Value $value
     *
     * @return string[]
     */
    private function getAuthors(Value $value)
    {
        $authorNames = [];

        foreach ($value->authors as $author) {
            $authorNames[] = $author->name;
        }

        return $authorNames;
    }
}
