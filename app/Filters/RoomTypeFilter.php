<?php

   namespace App\Filters;

   use Illuminate\Http\Request;
   use App\Filters\ApiFilters;


class RoomTypeFilter extends ApiFilters {
   // Lines of codes for new version
   public function __construct()
   {
      parent::__construct();

      $this->safeParms = [
         'name' => ['eq', 'like'],
         'price' => ['eq', 'gt', 'lt'],
         'floor' => ['eq'],
         'numGuest' => ['eq', 'gt', 'lt'],
      ];

      $this->columnMap = [
         'numGuest' => 'num_guest',
      ];
   }
}