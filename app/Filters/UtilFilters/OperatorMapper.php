<?php 

namespace app\Filters\UtilFilters;

class OperatorMapper {
   protected $operatorMap = [
      'eq' => '=',
      'lt' => '<',
      'lte' => '<=',
      'gt' => '>',
      'gte' => '>=',
      'like' => 'like',
   ];

   /**
    * Map the given operator to its corresponding symbol
    */
   public function map($operator) {
      return $this->operatorMap[$operator];
   }
}