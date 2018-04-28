<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class Post extends Resource
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
            'id' => $this->id,
            'name' => $this->content,
            'user' => $this->user_id,
            'secret' => $this -> when(0, 'secret'),
            $this->mergeWhen(1, [
                'first-secret' => function() {return 'value';},
                'second-secret' => 'value',
            ]),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'links' => [
                'self' => 'link-value',
            ],
        ];
    }
}
