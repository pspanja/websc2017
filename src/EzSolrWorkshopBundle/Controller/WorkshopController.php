<?php

namespace EzSolrWorkshopBundle\Controller;

use eZ\Publish\API\Repository\ContentTypeService;
use eZ\Publish\API\Repository\SearchService;
use eZ\Publish\API\Repository\Values\Content\Query;
use eZ\Publish\API\Repository\Values\Content\Query\Criterion;
use EzSolrWorkshopBundle\API\Criterion\IsFieldEmpty;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class WorkshopController extends Controller
{
    /**
     * @var \eZ\Publish\API\Repository\SearchService
     */
    private $searchService;

    /**
     * @var \eZ\Publish\API\Repository\ContentTypeService
     */
    private $contentTypeService;

    /**
     * @param \eZ\Publish\API\Repository\SearchService $searchService
     * @param \eZ\Publish\API\Repository\ContentTypeService $contentTypeService
     */
    public function __construct(SearchService $searchService, ContentTypeService $contentTypeService)
    {
        $this->searchService = $searchService;
        $this->contentTypeService = $contentTypeService;
    }

    /**
     * Index parent data for Fulltext search.
     *
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \eZ\Publish\API\Repository\Exceptions\InvalidArgumentException
     */
    public function indexParentAction()
    {
        $query = new Query([
            'query' => new Criterion\FullText('project'),
        ]);

        $searchResult = $this->searchService->findContent($query);

        return $this->render(
            'EzSolrWorkshopBundle::index_parent.html.twig',
            [
                'search_result' => $searchResult,
                'content_type_map' => $this->getContentTypeIdentifierMap(),
            ]
        );
    }

    /**
     * Index info on whether the Content field is empty.
     *
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \eZ\Publish\API\Repository\Exceptions\InvalidArgumentException
     * @throws \InvalidArgumentException
     */
    public function isEmptyFieldAction()
    {
        $query = new Query([
            'filter' => new Criterion\LogicalAnd([
                new Criterion\ContentTypeIdentifier('image'),
                new IsFieldEmpty('caption', IsFieldEmpty::IS_NOT_EMPTY),
            ]),
        ]);

        $searchResult = $this->searchService->findContent($query);

        return $this->render(
            'EzSolrWorkshopBundle::is_field_empty.html.twig',
            [
                'search_result' => $searchResult,
                'content_type_map' => $this->getContentTypeIdentifierMap(),
            ]
        );
    }

    /**
     * Index children data for Fulltext search.
     *
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \eZ\Publish\API\Repository\Exceptions\InvalidArgumentException
     */
    public function indexChildrenAction()
    {
        $query = new Query([
            'query' => new Criterion\FullText('dufresne')
        ]);

        $searchResult = $this->searchService->findContent($query);

        return $this->render(
            'EzSolrWorkshopBundle::index_children.html.twig',
            [
                'search_result' => $searchResult,
                'content_type_map' => $this->getContentTypeIdentifierMap(),
            ]
        );
    }

    /**
     * Return a map of ContentType id to identifier.
     *
     * @return array
     */
    private function getContentTypeIdentifierMap()
    {
        $contentTypeIdentifierMap = [];
        $contentTypeGroups = $this->contentTypeService->loadContentTypeGroups();

        foreach ($contentTypeGroups as $contentTypeGroup) {
            $contentTypes = $this->contentTypeService->loadContentTypes($contentTypeGroup);

            foreach ($contentTypes as $contentType) {
                $contentTypeIdentifierMap[$contentType->id] = $contentType->identifier;
            }
        }

        return $contentTypeIdentifierMap;
    }
}
