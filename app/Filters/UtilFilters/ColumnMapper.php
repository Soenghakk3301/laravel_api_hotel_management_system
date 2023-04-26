<?php

namespace app\Filters\UtilFilters;

class ColumnMapper {
   protected $relatedFields;

   public function __construct($relatedFields) {
      $this->relatedFields = $relatedFields;
   }

   /**
    * Get the corresponding column for the given field and operator,
    * taking into account related fields and the operator's symbol
    */
   public function getColumn($field, $operator) {
      
      $isRelatedField = array_key_exists($field, $this->relatedFields);
      $column = $isRelatedField ? $this->relatedFields[$field] : $field;
      $operatorSymbol = $isRelatedField && $operator === 'like' ? 'like' : $operator;
      
      return "{$column} {$operatorSymbol}";
   }
}