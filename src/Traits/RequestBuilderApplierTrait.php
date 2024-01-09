<?php

namespace LumenRequestParser\Traits;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use LumenRequestParser\Parameters\Filter;
use LumenRequestParser\Parameters\Sort;
use LumenRequestParser\Parameters\Parameter;
use LumenRequestParser\Interfaces\RequestInterface;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

// BuilderParamsApplierTrait
trait RequestBuilderApplierTrait
{
    public function applyParams(Builder $query, RequestInterface $params): LengthAwarePaginator
    {
        if ($params->hasFilter()) {
            foreach ($params->getFilters() as $filter) {
                $this->applyFilter($query, $filter);
            }
        }

        if ($params->hasSort()) {
            foreach ($params->getSorts() as $sort) {
                $this->applySort($query, $sort);
            }
        }

        if ($params->hasPagination()) {
            $pagination = $params->getPagination();
            $query->limit($pagination->getLimit());
            $query->offset($pagination->getPage() * $pagination->getLimit());

            $paginator = $query->paginate(
                $params->getPagination()->getLimit(),
                ['*'],
                'page',
                $params->getPagination()->getPage()
            );
        } else {
            $paginator = $query->paginate($query->count(), ['*'], 'page', 1);
        }

        if ($params->hasParameters()) {
            foreach ($params->getParameters() as $parameter) {
                $paginator = $this->appendsParameter($paginator, $parameter);
            }
        }

        return $paginator;
    }

    protected function applyFilter(Builder $query, Filter $filter): void
    {
        $table = $query->getModel()->getTable();
        $field = sprintf('%s.%s', $table, $filter->getField());
        $operator = $filter->getOperator();
        $value = $filter->getValue();
        $method = 'where';
        $clauseOperator = null;

        if ($operator === 'in') {
            $query->whereIn($filter->getField(), explode('|', $value));
        } else {
            switch ($operator) {
                case 'ct':
                    $value = '%' . $value . '%';
                    $clauseOperator = 'LIKE';
                    break;
                case 'nct':
                    $value = '%' . $value . '%';
                    $clauseOperator = 'NOT LIKE';
                    break;
                case 'sw':
                    $value .= '%';
                    $clauseOperator = 'LIKE';
                    break;
                case 'ew':
                    $value = '%' . $value;
                    $clauseOperator = 'LIKE';
                    break;
                case 'eq':
                    $clauseOperator = '=';
                    break;
                case 'ne':
                    $clauseOperator = '!=';
                    break;
                case 'gt':
                    $clauseOperator = '>';
                    break;
                case 'ge':
                    $clauseOperator = '>=';
                    break;
                case 'lt':
                    $clauseOperator = '<';
                    break;
                case 'le':
                    $clauseOperator = '<=';
                    break;
                default:
                    throw new BadRequestHttpException(sprintf('Not allowed operator: %s', $operator));
            }

            call_user_func_array(
                [$query, $method],
                [$field, $clauseOperator, $value]
            );
        }
    }

    protected function applySort(Builder $query, Sort $sort): void
    {
        $query->orderBy($sort->getField(), $sort->getDirection());
    }

    protected function appendsParameter(LengthAwarePaginator $paginator, Parameter $parameter): LengthAwarePaginator
    {
        return $paginator->appends($parameter->getField(), urldecode($parameter->getValue()));
    }
}
