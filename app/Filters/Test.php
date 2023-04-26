<?php


namespace App\Filters;

use Illuminate\Http\Request;


class ApiFilters {
   protected $safeParms = [
      'name' => ['eq', 'like'],
      'price' => ['eq', 'gt', 'lt'],
      'floor' => ['eq'],
      'numGuest' => ['eq', 'gt', 'lt'],
   ];

   protected $columnMap = [
      'numGuest' => 'num_guest',
   ];

   protected $operatorMap = [
      'eq' => '=',
      'lt' => '<',
      'lte' => '<=',
      'gt' => '>',
      'gte' => '>=',
      'like' => 'like',
   ];

  

   public function transform(Request $request) {
      $eloQuery = [];

      foreach($this->safeParms as $parm => $operators) {
         $query = $request->query($parm);

         if(!isset($query)) continue;

         $column = $this->columnMap[$parm] ?? $parm;

         foreach($operators as $operator) {
            // Use a ternary operator to set the filter value based on whether the query parameter is set and whether the operator is 'like'
            $value = isset($query[$operator]) ? ($operator === 'like' ? '%' . $query[$operator] . '%' : $query[$operator]) : null;

            // If the filter value is set, add it to the filter conditions array
            if(isset($value)) 
               $eloQuery[] = [$column, $this->operatorMap[$operator], $value];
         }
      }


      
      return $eloQuery;
   }

   protected $sortableColumns = [
      'name',
      'price',
      'floor',
      'numGuest',
  ];

   // Construct sorting clause
   $sortClause = $this->sort($request);

   if (isset($sortClause)) {
      $eloQuery[] = ['order_by', $sortClause];
   }


   public function sort(Request $request) {
      $sort = $request->query('sort');
  
      if (!isset($sort)) return null;
  
      $parts = explode(',', $sort);
  
      $sortClauses = [];
  
      foreach ($parts as $part) {
          $direction = 'asc';
          $column = $part;
  
          if (substr($part, 0, 1) === '-') {
              $direction = 'desc';
              $column = substr($part, 1);
          }
  
          if (!in_array($column, $this->sortableColumns)) continue;
  
          $column = $this->columnMap[$column] ?? $column;
  
          $sortClauses[] = $column . ' ' . $direction;
      }
  
      if (count($sortClauses) === 0) return null;
  
      return implode(', ', $sortClauses);
  }

      // public function transform(Request $request) {
   //    $eloQuery = [];

   //    foreach($this->safeParms as $parm => $operators) {
   //       $query = $request->query($parm);

   //       if(!isset($query)) continue;

   //       $column = $this->columnMap[$parm] ?? $parm;
         
   //       // version 1 without like operator
   //       // foreach($operators as $operator) {
   //       //    if(isset($query[$operator])) 
   //       //       $eloQuery[] = [$column, $this->operatorMap[$operator], $query[$operator]];
   //       // }

   //       // version 2 with like operator
   //       foreach($operators as $operator) {
   //          // Use a ternary operator to set the filter value based on whether the query parameter is set and whether the operator is 'like'
   //          $value = isset($query[$operator]) ? ($operator === 'like' ? '%' . $query[$operator] . '%' : $query[$operator]) : null;

   //          // If the filter value is set, add it to the filter conditions array
   //          if(isset($value)) 
   //             $eloQuery[] = [$column, $this->operatorMap[$operator], $value];
   //       }
   //    }

   //    return $eloQuery;
   // }

    
}


// W