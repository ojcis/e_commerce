<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

class Product extends Model implements ProductInterface
{
    use HasFactory;

    private MoneyInterface $money;
    protected $fillable=[
        'name',
        'available',
        'price',
        'vat_rate'
    ];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->money = App::make(MoneyInterface::class);
    }

    public function setName(string $name): ProductInterface
    {
        $this->name=$name;
        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setAvailable(int $available): ProductInterface
    {
        $this->available=$available;
        return $this;
    }

    public function getAvailable(): int
    {
        return $this->available;
    }

    public function setPrice(MoneyInterface $price): ProductInterface
    {
        $this->price=$price->getEuros()*100+$price->getCents();
        return $this;
    }

    public function getPrice(): MoneyInterface
    {
        $cents=$this->price%100;
        $euros=($this->price-$cents)/100;
        return new $this->money($cents,$euros);
    }

    public function setVatRate(float $vat): ProductInterface
    {
        $this->vat_rate=$vat;
        return $this;
    }

    public function getVatRate(): float
    {
        return $this->vat_rate;
    }

    public function getId(): int
    {
        return $this->id;
    }
}
