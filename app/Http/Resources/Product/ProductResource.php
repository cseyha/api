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
        // return parent::toArray($request);
        return [
            'name' => $this->name,
            'description' => $this->detail,
            'price' => $this->price,
            'stock' => $this->stock == 0 ? 'Out of Stock' : $this->stock,
            'discount' => $this->discount,
            // 17/100 = .17
            // 1 - .17 = .83
            // .83 * 404
            'totalPrice' => round((1 - ($this->discount/100)) * $this->price,2),
            //app/Model/Product.php/public function reviews
            'rating' => $this->reviews->count() > 0 ? round($this->reviews->sum('star')/$this->reviews->count(),2) : 'No rating yet',
            'href' => [
                //php artisan route:list
                'reviews' => route('reviews.index',$this->id) 
            ]
        ];
    }
}
