<?php 

namespace App\Filters;

use App\Filters\ApiFilters;

class RoomFilter extends ApiFilters {
   public function __construct()
   {
      parent::__construct();

      $this->safeParms = [
         'roomNo' => ['eq', 'like'],
         'roomType' => ['eq', 'like'],
         'roomSize' => ['eq'],
         'isAvailable' => ['eq', 'like'],
         'mainDescription' => ['like'],
         'subDescription' => ['like'],
         'numGuest' => ['eq', 'gte'],
         'bedType' => ['eq', 'like'],
         'floor' => ['eq', 'like'],
         'guest' => ['eq', 'lt'],
         'price' => ['eq', 'gte', 'lt', 'lte'],
      ];
   
      $this->columnMap = [
         'roomNo' => 'room_no',
         'roomType' => 'name',
         'roomSize' => 'room_size',
         'bedType' => 'bed_type',
         'mainDescription' => 'main_description',
         'subDescription' => 'sub_description',
         'numGuest' => 'num_guest',
         'isAvailable' => 'is_available',
      ];
   
      $this->operatorMap = [
         'eq' => '=',
         'lt' => '<',
         'lte' => '<=',
         'gt' => '>',
         'gte' => '>=',
         'like' => 'like',
      ];
   }
   
}