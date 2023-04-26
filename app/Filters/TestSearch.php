<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Builder;

// class SearchService
// {
//     protected $allowedFields = [];

//     protected $relatedFields = [];

//     public function search(array $criteria = []): Builder
//     {
//         $query = $this->getQuery();

//         foreach ($criteria as $field => $value) {
//             if (in_array($field, $this->allowedFields)) {
//                 $related = $this->relatedFields[$field] ?? null;
//                 $method = $related ? 'whereHas' : 'where';
//                 $column = $related ? $related . '.id' : $field;
//                 $query->$method($related, function ($query) use ($column, $value) {
//                     $query->where($column, $value);
//                 }, '>', 0, 'and', function ($query) use ($field, $value) {
//                     $query->where($field, 'like', '%' . $value . '%');
//                 });
//             }
//         }

//         return $query;
//     }

//     protected function getQuery(): Builder
//     {
//         return new Builder();
//     }
// }

// class PostSearchService extends SearchService
// {
//     protected $allowedFields = ['title', 'body', 'category_id', 'tag_id'];

//     protected $relatedFields = [
//         'category_id' => 'category',
//         'tag_id' => 'tags',
//     ];

//     protected function getQuery(): Builder
//     {
//         return Post::query();
//     }
// }