<?php

namespace app\Filters\UtilFilters;

use app\Filters\UtilFilters\ColumnMapper;
use app\Filters\UtilFilters\OperatorMapper;
use app\Filters\UtilFilters\ParameterValidator;
use app\Filters\UtilFilters\QueryBuilder;
use Illuminate\Http\Request;

class BaseFilters {
   protected $safeParams;
   protected $relatedFields;

   public function __construct($safeParams, $relatedFields) {
      $this->safeParams = $safeParams;
      $this->relatedFields = $relatedFields;
   }

   /**
    * Apply the given filters to the query using the ParameterValidator,
    * OperatorMapper, ColumnMapper, and QueryBuilder classes
    */
   public function applyFilters(Request $request, $query) {
      // Instantiate the necessary classes
      $parameterValidator = new ParameterValidator($this->safeParams);
      $operatorMapper = new OperatorMapper();
      $columnMapper = new ColumnMapper($this->relatedFields);
      $queryBuilder = new QueryBuilder();

      // Validate the request parameters
      $validParams = $parameterValidator->validate($request->all());

      // Apply the valid filters to the query
      $query = $queryBuilder->applyFilters($query, $validParams, $operatorMapper, $columnMapper);

      return $query;
   }
}