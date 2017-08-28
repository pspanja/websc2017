<?php

namespace EzSolrWorkshopBundle\API\Criterion;

use eZ\Publish\API\Repository\Values\Content\Query\Criterion;
use eZ\Publish\API\Repository\Values\Content\Query\Criterion\Operator;
use eZ\Publish\API\Repository\Values\Content\Query\Criterion\Operator\Specifications;
use eZ\Publish\API\Repository\Values\Content\Query\CriterionInterface;
use EzSolrWorkshopBundle\API\Criterion\Value\LanguageValue;

/**
 * MoreLikeThis criterion matches Content which contains similar terms
 * found in the given Content.
 */
class MoreLikeThis extends Criterion implements CriterionInterface
{
    /**
     * @inheritdoc
     *
     * @param int|string $contentId
     * @param string $languageCode
     */
    public function __construct($contentId, $languageCode)
    {
        $languageValue = new LanguageValue($languageCode);

        parent::__construct(null, null, $contentId, $languageValue);
    }

    public function getSpecifications()
    {
        return [
            new Specifications(
                Operator::EQ,
                Specifications::FORMAT_SINGLE,
                Specifications::TYPE_INTEGER | Specifications::TYPE_STRING
            ),
        ];
    }
}
