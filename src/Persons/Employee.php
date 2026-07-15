<?php

declare(strict_types=1);

namespace Persons;

class Employee extends User
{
    protected string $jobTitle;
    protected float $salary;
    protected \DateTimeImmutable $startDate;
    protected array $responsibilities;

    public function __construct(
        int $id,
        string $firstName,
        string $lastName,
        string $email,
        string $hashedPassword,
        string $phoneNumber,
        string $address,
        \DateTimeImmutable $birthDate,
        \DateTimeImmutable $membershipExpirationDate,
        string $role,
        string $jobTitle,
        float $salary,
        \DateTimeImmutable $startDate,
        array $responsibilities
    ) {
        parent::__construct(
            $id,
            $firstName,
            $lastName,
            $email,
            $hashedPassword,
            $phoneNumber,
            $address,
            $birthDate,
            $membershipExpirationDate,
            $role
        );

        $this->jobTitle = $jobTitle;
        $this->salary = $salary;
        $this->startDate = $startDate;
        $this->responsibilities = $responsibilities;
    }

    public function toString(): string
    {
        return parent::toString() . sprintf(
            ', Job Title: %s, Salary: %.2f, Start Date: %s, Responsibilities: %s',
            $this->jobTitle,
            $this->salary,
            $this->startDate->format('Y-m-d'),
            implode(', ', $this->responsibilities)
        );
    }

    public function toHTML(): string
    {
        $responsibilitiesHTML = '';

        foreach ($this->responsibilities as $responsibility) {
            $responsibilitiesHTML .= sprintf(
                '<li>%s</li>',
                htmlspecialchars(
                    (string) $responsibility,
                    ENT_QUOTES,
                    'UTF-8'
                )
            );
        }

        return sprintf(
            '<div class="employee">
                %s
                <p>Job Title: %s</p>
                <p>Salary: %.2f</p>
                <p>Start Date: %s</p>
                <p>Responsibilities:</p>
                <ul>%s</ul>
            </div>',
            parent::toHTML(),
            htmlspecialchars($this->jobTitle, ENT_QUOTES, 'UTF-8'),
            $this->salary,
            $this->startDate->format('Y-m-d'),
            $responsibilitiesHTML
        );
    }

    public function toMarkdown(): string
    {
        $responsibilitiesMarkdown = '';

        foreach ($this->responsibilities as $responsibility) {
            $responsibilitiesMarkdown .=
                sprintf("  - %s\n", $responsibility);
        }

        return parent::toMarkdown() .
            sprintf(
                "- Job Title: %s\n" .
                "- Salary: %.2f\n" .
                "- Start Date: %s\n" .
                "- Responsibilities:\n%s",
                $this->jobTitle,
                $this->salary,
                $this->startDate->format('Y-m-d'),
                $responsibilitiesMarkdown
            );
    }

    public function toArray(): array
    {
        return array_merge(
            parent::toArray(),
            [
                'jobTitle' => $this->jobTitle,
                'salary' => $this->salary,
                'startDate' => $this->startDate->format('Y-m-d'),
                'responsibilities' => $this->responsibilities,
            ]
        );
    }
}