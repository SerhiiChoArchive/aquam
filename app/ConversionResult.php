<?php

declare(strict_types=1);

namespace App;

class ConversionResult
{
    const FISH = 'fish';
    const EQUIPMENT = 'equipment';
    const FEED = 'feed';
    const CHEMISTRY = 'chemistry';

    /**
     * @var array[]
     */
    private $fish;

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
     * @param array[] $fish
     * @param array[] $equipment
     * @param array[] $feed
     * @param array[] $chemistry
     */
    public function __construct(array $fish, array $equipment, array $feed, array $chemistry)
    {
        $this->fish = $fish;
        $this->equipment = $equipment;
        $this->feed = $feed;
        $this->chemistry = $chemistry;
    }

    /**
     * @return array[]
     */
    public function getFish(): array
    {
        return $this->fish;
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