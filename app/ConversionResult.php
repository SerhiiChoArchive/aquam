<?php

declare(strict_types=1);

namespace App;

class ConversionResult
{
    /**
     * @var array[]
     */
    private array $fish;

    /**
     * @var array[]
     */
    private array $equipment;

    /**
     * @var array[]
     */
    private array $feed;

    /**
     * @var array[]
     */
    private array $chemistry;

    /**
     * @var array[]
     */
    private array $aquariums;

    /**
     * ConversionResult constructor.
     *
     * @param array[] $fish
     * @param array[] $equipment
     * @param array[] $feed
     * @param array[] $chemistry
     * @param array $aquariums
     */
    public function __construct(array $fish, array $equipment, array $feed, array $chemistry, array $aquariums)
    {
        $this->fish = $fish;
        $this->equipment = $equipment;
        $this->feed = $feed;
        $this->chemistry = $chemistry;
        $this->aquariums = $aquariums;
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

    /**
     * @return array[]
     */
    public function getAquariums(): array
    {
        return $this->aquariums;
    }
}