<?php

namespace Lle\CruditBundle\Filter\FilterType;

use Doctrine\ORM\QueryBuilder;

/**
 * NumberFilterType
 *
 * For numbers.
 */
class NumberFilterType extends AbstractFilterType
{
    public static function new(string $fieldname): self
    {
        return new self($fieldname);
    }

    public function getOperators(): array
    {
        return [
            "eq" => ["icon" => "fas fa-equals"],
            "neq" => ["icon" => "fas fa-not-equal"],
            "lt" => ["icon" => "fas fa-less-than"],
            "lte" => ["icon" => "fas fa-less-than-equal"],
            "gt" => ["icon" => "fas fa-greater-than"],
            "gte" => ["icon" => "fas fa-greater-than-equal"],
            "isnull" => ["icon" => "far fa-square"],
            "isnotnull" => ["icon" => "fas fa-square"],
        ];
    }

    public function apply(QueryBuilder $queryBuilder): void
    {
        list($column, $alias, $paramname) = $this->getQueryParams($queryBuilder);

        if (isset($this->data["op"]) && in_array($this->data["op"], ["isnull", "isnotnull"])) {
            switch ($this->data['op']) {
                case 'isnotnull':
                    $queryBuilder->andWhere($queryBuilder->expr()->isNotNull($alias . $column));
                    break;
                case 'isnull':
                default:
                    $queryBuilder->andWhere($queryBuilder->expr()->isNull($alias . $column));
            }
        } else if (isset($this->data['value']) && $this->data['value']) {
            switch ($this->data['op']) {
                case 'neq':
                    $queryBuilder->andWhere($queryBuilder->expr()->neq($alias . $column, ':' . $paramname));
                    break;
                case 'lt':
                    $queryBuilder->andWhere($queryBuilder->expr()->lt($alias . $column, ':' . $paramname));
                    break;
                case 'lte':
                    $queryBuilder->andWhere($queryBuilder->expr()->lte($alias . $column, ':' . $paramname));
                    break;
                case 'gt':
                    $queryBuilder->andWhere($queryBuilder->expr()->gt($alias . $column, ':' . $paramname));
                    break;
                case 'gte':
                    $queryBuilder->andWhere($queryBuilder->expr()->gte($alias . $column, ':' . $paramname));
                    break;
                case 'eq':
                default:
                    $queryBuilder->andWhere($queryBuilder->expr()->eq($alias . $column, ':' . $paramname));
            }

            $queryBuilder->setParameter($paramname, $this->data['value']);
        }
    }
}
