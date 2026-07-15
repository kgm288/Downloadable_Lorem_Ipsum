<?php

declare(strict_types=1);

namespace Companies;

use Interfaces\FileConvertible;

class Company implements FileConvertible
{
    protected string $name;
    protected int $foundingYear;
    protected string $description;
    protected string $website;
    protected string $phone;
    protected string $industry;
    protected string $ceo;
    protected bool $isPubliclyTraded;
    protected string $country;
    protected string $founder;
    protected int $totalEmployees;

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
        int $totalEmployees
    ) {
        $this->name = $name;
        $this->foundingYear = $foundingYear;
        $this->description = $description;
        $this->website = $website;
        $this->phone = $phone;
        $this->industry = $industry;
        $this->ceo = $ceo;
        $this->isPubliclyTraded = $isPubliclyTraded;
        $this->country = $country;
        $this->founder = $founder;
        $this->totalEmployees = $totalEmployees;
    }

    public function toString(): string
    {
        return sprintf(
            'Company Name: %s, Founding Year: %d, Description: %s, Website: %s, Phone: %s, Industry: %s, CEO: %s, Publicly Traded: %s, Country: %s, Founder: %s, Total Employees: %d',
            $this->name,
            $this->foundingYear,
            $this->description,
            $this->website,
            $this->phone,
            $this->industry,
            $this->ceo,
            $this->isPubliclyTraded ? 'Yes' : 'No',
            $this->country,
            $this->founder,
            $this->totalEmployees
        );
    }

    public function toHTML(): string
    {
        return sprintf(
            '<div class="company">
                <h2>%s</h2>

                <p>Founding Year: %d</p>
                <p>Description: %s</p>

                <p>
                    Website:
                    <a href="%s" target="_blank" rel="noopener noreferrer">
                        %s
                    </a>
                </p>

                <p>Phone: %s</p>
                <p>Industry: %s</p>
                <p>CEO: %s</p>
                <p>Publicly Traded: %s</p>
                <p>Country: %s</p>
                <p>Founder: %s</p>
                <p>Total Employees: %d</p>
            </div>',
            htmlspecialchars(
                $this->name,
                ENT_QUOTES,
                'UTF-8'
            ),
            $this->foundingYear,
            htmlspecialchars(
                $this->description,
                ENT_QUOTES,
                'UTF-8'
            ),
            htmlspecialchars(
                $this->website,
                ENT_QUOTES,
                'UTF-8'
            ),
            htmlspecialchars(
                $this->website,
                ENT_QUOTES,
                'UTF-8'
            ),
            htmlspecialchars(
                $this->phone,
                ENT_QUOTES,
                'UTF-8'
            ),
            htmlspecialchars(
                $this->industry,
                ENT_QUOTES,
                'UTF-8'
            ),
            htmlspecialchars(
                $this->ceo,
                ENT_QUOTES,
                'UTF-8'
            ),
            $this->isPubliclyTraded ? 'Yes' : 'No',
            htmlspecialchars(
                $this->country,
                ENT_QUOTES,
                'UTF-8'
            ),
            htmlspecialchars(
                $this->founder,
                ENT_QUOTES,
                'UTF-8'
            ),
            $this->totalEmployees
        );
    }

    public function toMarkdown(): string
    {
        return sprintf(
            "## %s\n\n" .
            "- Founding Year: %d\n" .
            "- Description: %s\n" .
            "- Website: %s\n" .
            "- Phone: %s\n" .
            "- Industry: %s\n" .
            "- CEO: %s\n" .
            "- Publicly Traded: %s\n" .
            "- Country: %s\n" .
            "- Founder: %s\n" .
            "- Total Employees: %d\n",
            $this->name,
            $this->foundingYear,
            $this->description,
            $this->website,
            $this->phone,
            $this->industry,
            $this->ceo,
            $this->isPubliclyTraded ? 'Yes' : 'No',
            $this->country,
            $this->founder,
            $this->totalEmployees
        );
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'foundingYear' => $this->foundingYear,
            'description' => $this->description,
            'website' => $this->website,
            'phone' => $this->phone,
            'industry' => $this->industry,
            'ceo' => $this->ceo,
            'isPubliclyTraded' => $this->isPubliclyTraded,
            'country' => $this->country,
            'founder' => $this->founder,
            'totalEmployees' => $this->totalEmployees,
        ];
    }
}