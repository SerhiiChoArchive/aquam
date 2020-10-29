<?php

namespace App\View\Components;

use App\Helper;
use App\Models\PriceList;
use Illuminate\View\Component;

class PriceListTabs extends Component
{
    public ?PriceList $price;

    public function __construct(?PriceList $price)
    {
        $this->price = $price;
    }

    public function count_fish(): int
    {
        return $this->price ? Helper::countArrayItems($this->price->fish) : 0;
    }

    public function count_equipment(): int
    {
        return $this->price ? Helper::countArrayItems($this->price->equipment) : 0;
    }

    public function count_feed(): int
    {
        return $this->price ? Helper::countArrayItems($this->price->feed) : 0;
    }

    public function count_chemistry(): int
    {
        return $this->price ? Helper::countArrayItems($this->price->chemistry) : 0;
    }

    public function count_aquariums(): int
    {
        return $this->price ? Helper::countArrayItems($this->price->aquariums) : 0;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.price-list-tabs');
    }
}
