<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'available' => $this->available,
            'price' => $this->price/100,
            'vat' => round ($this->vat_rate*$this->price/100,2),
            'vat_rate' => $this->vat_rate,
            'full_price' => round(($this->vat_rate*$this->price+$this->price)/100, 2),
        ];
    }
}
