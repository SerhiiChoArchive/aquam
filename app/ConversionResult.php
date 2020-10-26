<?php

declare(strict_types=1);

namespace App;

class ConversionResult
{
    const PRICE_LIST = 'price-list';
    const EQUIPMENT = 'equipment';
    const FEED = 'feed';
    const CHEMISTRY = 'chemistry';

    /**
     * @var array[]
     */
    private $price_list;

    /**
     * @var array[]
     */
    private $equipment;

    /**
     * @var array[]
     */
    private $feed;

    /**
     * @var array[]
     */
    private $chemistry;

    /**
     * ConversionResult constructor.
     *
     * @param array[] $price_list
     * @param array[] $equipment
     * @param array[] $feed
     * @param array[] $chemistry
     */
    public function __construct(array $price_list, array $equipment, array $feed, array $chemistry)
    {
        $this->price_list = $price_list;
        $this->equipment = $equipment;
        $this->feed = $feed;
        $this->chemistry = $chemistry;
    }

    /**
     * @return array[]
     */
    public function getPriceList(): array
    {
        return $this->price_list;
    }

    /**
     * @return array[]
     */
    public function getEquipment(): array
    {
        return $this->equipment;
    }

    /**
     * @return array[]
     */
    public function getFeed(): array
    {
        return $this->feed;
    }

    /**
     * @return array[]
     */
    public function getChemistry(): array
    {
        return $this->chemistry;
    }
}