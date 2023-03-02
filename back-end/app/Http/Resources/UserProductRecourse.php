<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserProductRecourse extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'product' => new ProductResource($this->product),
            'amount' => $this->amount,
            'full_price' =>round(($this->product->vat_rate*$this->product->price+$this->product->price)/100*$this->amount,2)
        ];
    }
}
