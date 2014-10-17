<?php

namespace Bigfoot\Bundle\CoreBundle\Entity;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;

/**
 * TranslatableLabelRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class TranslatableLabelRepository extends EntityRepository
{
    /**
     * @param $locale
     * @param $domain
     */
    public function findAllForLocaleAndDomain($locale, $domain)
    {
        return $this
            ->createQueryBuilder('t')
            ->andWhere('t.domain = :domain')
            ->setParameter(':domain', $domain)
            ->getQuery()
            ->setHint(
                \Doctrine\ORM\Query::HINT_CUSTOM_OUTPUT_WALKER,
                'Gedmo\\Translatable\\Query\\TreeWalker\\TranslationWalker'
            )
            ->setHint(
                \Gedmo\Translatable\TranslatableListener::HINT_TRANSLATABLE_LOCALE,
                $locale
            )
            ->setHint(
                \Gedmo\Translatable\TranslatableListener::HINT_FALLBACK,
                0
            )
            ->getResult()
        ;
    }

    public function getCategories()
    {
        $results = $this
            ->createQueryBuilder('e')
            ->select('SUBSTRING_INDEX(SUBSTRING_INDEX(e.name, \'.\', 2), \'.\', -2) as category')
            ->distinct()
            ->orderBy('category')
            ->getQuery()
            ->getResult()
        ;

        $toReturn = array();
        
        foreach ($results as $result) {
            $toReturn[$result['category']] = $result['category'];
        }

        return $toReturn;
    }

    public function addCategoryFilter(QueryBuilder $query, $search)
    {
        $search .= '.%';
        return $query->andWhere('e.name LIKE :search')->setParameter(':search', $search);
    }
}
