<?php

namespace App\Http\Resources\Product;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
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
            'name' =>  $this->name,
            'detail' => $this->deatil,
            'price' => $this->price,
            'stock' => $this->stock == 0 ? 'Out of Stock' : $this->stock,
            "realprice" => round( (1- ($this->discount/100)) * $this->price, 2),
            'discount' => $this->discount,
            'rating' => $this->reviews->sum('star') ? round($this->reviews->sum('star')/$this->reviews->count()) : 0,
            'link' => [
                'href' => route('review.index', $this->id)
            ]
        ];
    }
}
