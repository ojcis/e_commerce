<?php

namespace App\Models;

class Money implements MoneyInterface
{
    private ?int $cents;
    private ?int $euros;

    public function __construct(?int $cents=0, ?int $euros=0)
    {
        $this->cents = $cents;
        $this->euros = $euros;
    }

    public function setCents(int $cents): MoneyInterface
    {
        $this->cents=$cents;
        return $this;
    }

    public function getCents(): int
    {
        return $this->cents;
    }

    public function setEuros(int $euros): MoneyInterface
    {
        $this->euros=$euros;
        return $this;
    }

    public function getEuros(): int
    {
        return $this->euros;
    }
}
