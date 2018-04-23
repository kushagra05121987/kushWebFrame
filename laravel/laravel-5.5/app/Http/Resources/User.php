<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class User extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
//        return parent::toArray($request);
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'posts' => \App\Http\Resources\Post::collection($this -> posts),
            'password' => $this -> when(1, $this -> password),
            'double' => \App\Http\Resources\Post::collection($this->whenLoaded('posts')),
            'role' => \App\Http\Resources\Role::collection($this->whenLoaded('roles')),
            'pivot' => \App\Http\Resources\User::collection($this->whenPivotLoaded('UserRoles', function($q) {
                return $this -> pivot -> user_id;
            })),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'links' => [
                'self' => 'Resource link-value',
            ],
        ];
    }
    public function withResponse($request, $response)
    {
        $response->header('X-Value', 'True');
    }
}
