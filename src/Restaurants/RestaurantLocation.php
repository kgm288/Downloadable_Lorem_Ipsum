<?php

declare(strict_types=1);

namespace Restaurants;

use Interfaces\FileConvertible;
use Persons\Employee;

class RestaurantLocation implements FileConvertible
{
    protected string $name;
    protected string $address;
    protected string $city;
    protected string $state;
    protected string $zipCode;

    /**
     * @var Employee[]
     */
    protected array $employees;

    protected bool $isOpen;

    /**
     * @param Employee[] $employees
     */
    public function __construct(
        string $name,
        string $address,
        string $city,
        string $state,
        string $zipCode,
        array $employees,
        bool $isOpen
    ) {
        $this->name = $name;
        $this->address = $address;
        $this->city = $city;
        $this->state = $state;
        $this->zipCode = $zipCode;
        $this->employees = $employees;
        $this->isOpen = $isOpen;
    }

    public function addEmployee(Employee $employee): void
    {
        $this->employees[] = $employee;
    }

    public function open(): void
    {
        $this->isOpen = true;
    }

    public function close(): void
    {
        $this->isOpen = false;
    }

    public function toString(): string
    {
        $employeeStrings = [];

        foreach ($this->employees as $employee) {
            $employeeStrings[] = $employee->toString();
        }

        return sprintf(
            "Location Name: %s\n" .
            "Address: %s, %s, %s %s\n" .
            "Status: %s\n" .
            "Employees:\n%s",
            $this->name,
            $this->address,
            $this->city,
            $this->state,
            $this->zipCode,
            $this->isOpen ? 'Open' : 'Closed',
            implode("\n", $employeeStrings)
        );
    }

    public function toHTML(): string
    {
        $employeesHTML = '';

        foreach ($this->employees as $employee) {
            $employeesHTML .= $employee->toHTML();
        }

        return sprintf(
            '<section class="restaurant-location">
                <h3>%s</h3>

                <p>
                    Address:
                    %s, %s, %s %s
                </p>

                <p>Status: %s</p>

                <div class="employees">
                    <h4>Employees</h4>
                    %s
                </div>
            </section>',
            htmlspecialchars($this->name, ENT_QUOTES, 'UTF-8'),
            htmlspecialchars($this->address, ENT_QUOTES, 'UTF-8'),
            htmlspecialchars($this->city, ENT_QUOTES, 'UTF-8'),
            htmlspecialchars($this->state, ENT_QUOTES, 'UTF-8'),
            htmlspecialchars($this->zipCode, ENT_QUOTES, 'UTF-8'),
            $this->isOpen ? 'Open' : 'Closed',
            $employeesHTML
        );
    }

    public function toMarkdown(): string
    {
        $employeesMarkdown = '';

        foreach ($this->employees as $employee) {
            $employeesMarkdown .=
                $employee->toMarkdown() . "\n";
        }

        return sprintf(
            "## %s\n\n" .
            "- Address: %s, %s, %s %s\n" .
            "- Status: %s\n\n" .
            "### Employees\n\n%s",
            $this->name,
            $this->address,
            $this->city,
            $this->state,
            $this->zipCode,
            $this->isOpen ? 'Open' : 'Closed',
            $employeesMarkdown
        );
    }

    public function toArray(): array
    {
        $employeeArrays = [];

        foreach ($this->employees as $employee) {
            $employeeArrays[] = $employee->toArray();
        }

        return [
            'name' => $this->name,
            'address' => $this->address,
            'city' => $this->city,
            'state' => $this->state,
            'zipCode' => $this->zipCode,
            'employees' => $employeeArrays,
            'isOpen' => $this->isOpen,
        ];
    }
}