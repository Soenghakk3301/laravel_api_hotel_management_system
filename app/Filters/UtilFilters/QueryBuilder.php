<?php 

namespace app\Filters\UtilFilters;

class QueryBuilder {
   /**
    * Apply the given filters to the query using the operator and column mappers
    */
   public function applyFilters($query, $params, $operatorMapper, $columnMapper) {
      foreach ($params as $field => $operators) {
         foreach ($operators as $operator => $value) {
            
            $column = $columnMapper->getColumn($field, $operator);
            $symbol = $operatorMapper->map($operator);

            $operator === 'like' ? $query->orWhere($column, 'like', "%{$value}%") : $query->where($column, $symbol, $value);
         }
      }
      return $query;
   }
}