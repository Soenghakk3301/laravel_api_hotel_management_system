<?php 

namespace app\Filters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class BaseService
{
    protected $safeParms = [];

    protected $columnMap = [];

    protected $operatorMap = [];

    protected $relatedFields = [];

    protected function getQuery()
    {
        return new Builder();
    }

    public function transform(Request $request): Builder
    {
      //   $query = $this->getQuery();
        $query = $this->getQuery();

        // Search for columns in the main table
        foreach ($this->safeParms as $parm => $operators) {
            $queryParm = $request->query($parm);

            if (!isset($queryParm)) {
                continue;
            }

            $column = $this->columnMap[$parm] ?? $parm;

            foreach ($operators as $operator) {
                $value = isset($queryParm[$operator]) ? ($operator === 'like' ? '%' . $queryParm[$operator] . '%' : $queryParm[$operator]) : null;

                if (isset($value)) {
                    $query->where($column, $this->operatorMap[$operator], $value);
                }
            }
        }

        // Search for related fields
        foreach ($request->query() as $field => $value) {
            if (isset($this->safeParms[$field])) {
                $related = $this->relatedFields[$field] ?? null;
                $method = $related ? 'whereHas' : 'where';
                $column = $related ? $related . '.id' : $field;
                $query->$method($related, function ($query) use ($column, $value, $field) {
                    $query->where(function ($query) use ($column, $value, $field) {
                        foreach ($this->relatedFields[$field] as $relatedColumn) {
                            $query->orWhere($relatedColumn, 'like', '%' . $value . '%');
                        }
                    });
                }, '>', 0, 'and', function ($query) use ($field, $value) {
                    $query->where($field, 'like', '%' . $value . '%');
                });
            }
        }

        return $query;
    }
}