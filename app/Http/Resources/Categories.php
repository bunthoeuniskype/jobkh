<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Collection;

class Categories extends ResourceCollection
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
     public function toArray($request)
    {
        return [
            'data' => Category::collection($this->collection),
        ];
    }

    // public function with($request)
    // {
    //     $comments = $this->collection->flatMap(
    //         function ($article) {
    //             return $article->comments;
    //         }
    //     );
    //     $authors  = $this->collection->map(
    //         function ($article) {
    //             return $article->author;
    //         }
    //     );
    //     $included = $authors->merge($comments)->unique();

    //     return [
    //         'links'    => [
    //             'self' => route('articles.index'),
    //         ],
    //         'included' => $this->withIncluded($included),
    //     ];
    // }

    // private function withIncluded(Collection $included)
    // {
    //     return $included->map(
    //         function ($include) {
    //             if ($include instanceof People) {
    //                 return new PeopleResource($include);
    //             }
    //             if ($include instanceof Comment) {
    //                 return new CommentResource($include);
    //             }
    //         }
    //     );
    // }
}
