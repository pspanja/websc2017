<?php

namespace EzSolrWorkshopBundle\Controller;

use eZ\Publish\API\Repository\ContentTypeService;
use eZ\Publish\API\Repository\SearchService;
use eZ\Publish\API\Repository\Values\Content\Query;
use eZ\Publish\API\Repository\Values\Content\Query\Criterion;
use EzSolrWorkshopBundle\API\Criterion\IsFieldEmpty;
use EzSolrWorkshopBundle\API\Criterion\LocationQuery as LocationQueryCriterion;
use EzSolrWorkshopBundle\API\Criterion\MoreLikeThis;
use EzSolrWorkshopBundle\API\FacetBuilder\CustomFieldFacetBuilder;
use EzSolrWorkshopBundle\API\FacetBuilder\FieldPrefixFacetBuilder;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

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
     * Search with LocationQuery Criterion.
     *
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \eZ\Publish\API\Repository\Exceptions\InvalidArgumentException
     * @throws \InvalidArgumentException
     */
    public function locationQueryCriterionAction()
    {
        $query = new Query([
            'filter' => new Criterion\LogicalAnd([
                new Criterion\ContentId(62),
                new LocationQueryCriterion(
                    new Criterion\LogicalAnd([
                        new Criterion\LocationId(64),
                        new Criterion\Visibility(Criterion\Visibility::HIDDEN),
                    ])
                ),
                new LocationQueryCriterion(
                    new Criterion\Visibility(Criterion\Visibility::VISIBLE)
                )
            ]),
        ]);

        $searchResult = $this->searchService->findContent($query);

        return $this->render(
            'EzSolrWorkshopBundle::location_query_criterion.html.twig',
            [
                'search_result' => $searchResult,
                'content_type_map' => $this->getContentTypeIdentifierMap(),
            ]
        );
    }

    /**
     * Search with improved Fulltext criterion.
     *
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \eZ\Publish\API\Repository\Exceptions\InvalidArgumentException
     * @throws \InvalidArgumentException
     */
    public function betterFulltextAction(Request $request)
    {
        $queryString = $request->request->get('query_string');
        $query = new Query([
            'query' => new Criterion\FullText($queryString),
            'filter' => new Criterion\ContentTypeIdentifier('image'),
        ]);

        $searchResult = $this->searchService->findContent($query);

        return $this->render(
            'EzSolrWorkshopBundle::better_fulltext.html.twig',
            [
                'search_result' => $searchResult,
                'query_string' => $queryString,
                'content_type_map' => $this->getContentTypeIdentifierMap(),
            ]
        );
    }

    /**
     * Search with MoreLikeThis criterion.
     *
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \eZ\Publish\API\Repository\Exceptions\InvalidArgumentException
     * @throws \InvalidArgumentException
     */
    public function moreLikeThisAction()
    {
        $query = new Query([
            'filter' => new Criterion\LogicalAnd([
                new MoreLikeThis(79, 'engGB'),
            ])
        ]);

        $searchResult = $this->searchService->findContent($query);

        return $this->render(
            'EzSolrWorkshopBundle::more_like_this.html.twig',
            [
                'search_result' => $searchResult,
                'content_type_map' => $this->getContentTypeIdentifierMap(),
            ]
        );
    }

    /**
     * Search with CustomField Facet.
     *
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \eZ\Publish\API\Repository\Exceptions\InvalidArgumentException
     * @throws \InvalidArgumentException
     */
    public function customFieldFacetAction()
    {
        $facetBuilder = new CustomFieldFacetBuilder([
            'limit' => 15,
            'sort' => CustomFieldFacetBuilder::COUNT_DESC,
            'name' => 'type',
            'fieldName' => 'image_name_cs_value_css',
        ]);

        $query = new Query([
            'facetBuilders' => [$facetBuilder],
        ]);

        $searchResult = $this->searchService->findContent($query);

        return $this->render(
            'EzSolrWorkshopBundle::custom_field_facet.html.twig',
            [
                'search_result' => $searchResult,
                'content_type_map' => $this->getContentTypeIdentifierMap(),
            ]
        );
    }

    /**
     * Autocomplete through FieldPrefix Facet.
     *
     * @param string $prefix
     *
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \eZ\Publish\API\Repository\Exceptions\InvalidArgumentException
     * @throws \InvalidArgumentException
     */
    public function autocompleteAction($prefix)
    {
        $query = new Query([
            'filter' => new Criterion\ContentTypeIdentifier('image'),
            'limit' => 0,
            'facetBuilders' => [
                new FieldPrefixFacetBuilder([
                    'name' => 'autocomplete',
                    'prefix' => strtolower($prefix),
                    'fieldName' => 'meta_content__text_t',
                    'limit' => 10,
                ]),
            ],
        ]);

        $searchResult = $this->searchService->findContent($query);

        return $this->render(
            'EzSolrWorkshopBundle::field_prefix_facet.html.twig',
            ['search_result' => $searchResult]
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
