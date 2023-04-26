<?php 

namespace app\Filters\UtilFilters;

class ParameterValidator {
   protected $safeParams;

   public function __construct($safeParams) {
      $this->safeParams = $safeParams;
   }

   /**
    * Validate the given parameters against the safeParams property
    * and return an array containing only the valid parameters and operators
    */
   public function validate($params) {
      $validParams = [];
      foreach ($params as $field => $value) {
         if (array_key_exists($field, $this->safeParams)) {
            $allowedOperators = $this->safeParams[$field];
            if (is_array($value)) {
               foreach ($value as $operator => $filterValue) {
                  if (in_array($operator, $allowedOperators)) {
                     $validParams[$field][$operator] = $filterValue;
                  }
               }
            } else {
               $validParams[$field]['eq'] = $value;
            }
            
         }
      }
      return $validParams;
   }
}