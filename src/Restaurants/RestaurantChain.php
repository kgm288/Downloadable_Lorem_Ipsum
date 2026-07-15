<?php

declare(strict_types=1);

namespace Restaurants;

use Companies\Company;

class RestaurantChain extends Company
{
    protected int $chainId;

    /**
     * @var RestaurantLocation[]
     */
    protected array $restaurantLocations;

    protected string $cuisineType;
    protected int $numberOfLocations;
    protected bool $hasDriveThru;
    protected int $yearFounded;
    protected string $parentCompany;

    /**
     * @param RestaurantLocation[] $restaurantLocations
     */
    public function __construct(
        string $name,
        int $foundingYear,
        string $description,
        string $website,
        string $phone,
        string $industry,
        string $ceo,
        bool $isPubliclyTraded,
        string $country,
        string $founder,
        int $totalEmployees,
        int $chainId,
        array $restaurantLocations,
        string $cuisineType,
        bool $hasDriveThru,
        int $yearFounded,
        string $parentCompany
    ) {
        parent::__construct(
            $name,
            $foundingYear,
            $description,
            $website,
            $phone,
            $industry,
            $ceo,
            $isPubliclyTraded,
            $country,
            $founder,
            $totalEmployees
        );

        $this->chainId = $chainId;
        $this->restaurantLocations = $restaurantLocations;
        $this->cuisineType = $cuisineType;
        $this->numberOfLocations = count($restaurantLocations);
        $this->hasDriveThru = $hasDriveThru;
        $this->yearFounded = $yearFounded;
        $this->parentCompany = $parentCompany;
    }

    public function addRestaurantLocation(
        RestaurantLocation $restaurantLocation
    ): void {
        $this->restaurantLocations[] = $restaurantLocation;
        $this->numberOfLocations = count(
            $this->restaurantLocations
        );
    }

    public function toString(): string
    {
        $locationStrings = [];

        foreach (
            $this->restaurantLocations
            as $restaurantLocation
        ) {
            $locationStrings[] =
                $restaurantLocation->toString();
        }

        return parent::toString() .
            sprintf(
                "\nChain ID: %d\n" .
                "Cuisine Type: %s\n" .
                "Number of Locations: %d\n" .
                "Drive-Thru: %s\n" .
                "Year Founded: %d\n" .
                "Parent Company: %s\n" .
                "Restaurant Locations:\n%s",
                $this->chainId,
                $this->cuisineType,
                $this->numberOfLocations,
                $this->hasDriveThru ? 'Yes' : 'No',
                $this->yearFounded,
                $this->parentCompany,
                implode("\n", $locationStrings)
            );
    }

    public function toHTML(): string
    {
        $locationsHTML = '';

        foreach (
            $this->restaurantLocations
            as $restaurantLocation
        ) {
            $locationsHTML .=
                $restaurantLocation->toHTML();
        }

        return sprintf(
            '<section class="restaurant-chain">
                <h1>Restaurant Chain %s</h1>

                <div class="company-information">
                    %s
                </div>

                <div class="chain-information">
                    <p>Chain ID: %d</p>
                    <p>Cuisine Type: %s</p>
                    <p>Number of Locations: %d</p>
                    <p>Drive-Thru: %s</p>
                    <p>Year Founded: %d</p>
                    <p>Parent Company: %s</p>
                </div>

                <div class="restaurant-locations">
                    <h2>Restaurant Locations</h2>
                    %s
                </div>
            </section>',
            htmlspecialchars(
                $this->name,
                ENT_QUOTES,
                'UTF-8'
            ),
            parent::toHTML(),
            $this->chainId,
            htmlspecialchars(
                $this->cuisineType,
                ENT_QUOTES,
                'UTF-8'
            ),
            $this->numberOfLocations,
            $this->hasDriveThru ? 'Yes' : 'No',
            $this->yearFounded,
            htmlspecialchars(
                $this->parentCompany,
                ENT_QUOTES,
                'UTF-8'
            ),
            $locationsHTML
        );
    }

    public function toMarkdown(): string
    {
        $locationsMarkdown = '';

        foreach (
            $this->restaurantLocations
            as $restaurantLocation
        ) {
            $locationsMarkdown .=
                $restaurantLocation->toMarkdown() .
                "\n\n";
        }

        return parent::toMarkdown() .
            sprintf(
                "\n### Restaurant Chain Information\n\n" .
                "- Chain ID: %d\n" .
                "- Cuisine Type: %s\n" .
                "- Number of Locations: %d\n" .
                "- Drive-Thru: %s\n" .
                "- Year Founded: %d\n" .
                "- Parent Company: %s\n\n" .
                "## Restaurant Locations\n\n%s",
                $this->chainId,
                $this->cuisineType,
                $this->numberOfLocations,
                $this->hasDriveThru ? 'Yes' : 'No',
                $this->yearFounded,
                $this->parentCompany,
                $locationsMarkdown
            );
    }

    public function toArray(): array
    {
        $locationArrays = [];

        foreach (
            $this->restaurantLocations
            as $restaurantLocation
        ) {
            $locationArrays[] =
                $restaurantLocation->toArray();
        }

        return array_merge(
            parent::toArray(),
            [
                'chainId' => $this->chainId,
                'restaurantLocations' =>
                    $locationArrays,
                'cuisineType' => $this->cuisineType,
                'numberOfLocations' =>
                    $this->numberOfLocations,
                'hasDriveThru' =>
                    $this->hasDriveThru,
                'yearFounded' =>
                    $this->yearFounded,
                'parentCompany' =>
                    $this->parentCompany,
            ]
        );
    }
}