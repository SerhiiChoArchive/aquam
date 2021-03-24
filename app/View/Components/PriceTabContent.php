<?php

namespace App\View\Components;

use Illuminate\View\Component;

class PriceTabContent extends Component
{
    public array $categories;
    public array $names;
    public array $keys;
    public string $category;

    public function __construct(?array $categories, string $names, string $keys, string $category)
    {
        $this->categories = $categories ?? [];
        $this->names = explode(',', $names);
        $this->keys = explode(',', $keys);
        $this->category = $category;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.price-tab-content');
    }
}
