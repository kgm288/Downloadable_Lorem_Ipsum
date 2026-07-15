<?php

declare(strict_types=1);

namespace Persons;

use Interfaces\FileConvertible;

class User implements FileConvertible
{
    protected int $id;
    protected string $firstName;
    protected string $lastName;
    protected string $email;
    protected string $hashedPassword;
    protected string $phoneNumber;
    protected string $address;
    protected \DateTimeImmutable $birthDate;
    protected \DateTimeImmutable $membershipExpirationDate;
    protected string $role;

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
        string $role
    ) {
        $this->id = $id;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->email = $email;
        $this->hashedPassword = $hashedPassword;
        $this->phoneNumber = $phoneNumber;
        $this->address = $address;
        $this->birthDate = $birthDate;
        $this->membershipExpirationDate =
            $membershipExpirationDate;
        $this->role = $role;
    }

    public function login(string $password): bool
    {
        return password_verify(
            $password,
            $this->hashedPassword
        );
    }

    public function updateProfile(
        string $address,
        string $phoneNumber
    ): void {
        $this->address = $address;
        $this->phoneNumber = $phoneNumber;
    }

    public function renewMembership(
        \DateTimeImmutable $expirationDate
    ): void {
        $this->membershipExpirationDate =
            $expirationDate;
    }

    public function changePassword(
        string $newPassword
    ): void {
        $this->hashedPassword = password_hash(
            $newPassword,
            PASSWORD_DEFAULT
        );
    }

    public function hasMembershipExpired(): bool
    {
        $today = new \DateTimeImmutable('today');

        return $this->membershipExpirationDate < $today;
    }

    public function toString(): string
    {
        return sprintf(
            "ID: %d\n" .
            "Name: %s %s\n" .
            "Email: %s\n" .
            "Phone: %s\n" .
            "Address: %s\n" .
            "Birth Date: %s\n" .
            "Membership Expiration Date: %s\n" .
            "Role: %s\n",
            $this->id,
            $this->firstName,
            $this->lastName,
            $this->email,
            $this->phoneNumber,
            $this->address,
            $this->birthDate->format('Y-m-d'),
            $this->membershipExpirationDate->format('Y-m-d'),
            $this->role
        );
    }

    public function toHTML(): string
    {
        return sprintf(
            '<article class="user">
                <p>ID: %d</p>
                <p>Name: %s %s</p>
                <p>Email: %s</p>
                <p>Phone: %s</p>
                <p>Address: %s</p>
                <p>Birth Date: %s</p>
                <p>Membership Expiration Date: %s</p>
                <p>Role: %s</p>
            </article>',
            $this->id,
            htmlspecialchars(
                $this->firstName,
                ENT_QUOTES,
                'UTF-8'
            ),
            htmlspecialchars(
                $this->lastName,
                ENT_QUOTES,
                'UTF-8'
            ),
            htmlspecialchars(
                $this->email,
                ENT_QUOTES,
                'UTF-8'
            ),
            htmlspecialchars(
                $this->phoneNumber,
                ENT_QUOTES,
                'UTF-8'
            ),
            htmlspecialchars(
                $this->address,
                ENT_QUOTES,
                'UTF-8'
            ),
            $this->birthDate->format('Y-m-d'),
            $this->membershipExpirationDate->format('Y-m-d'),
            htmlspecialchars(
                $this->role,
                ENT_QUOTES,
                'UTF-8'
            )
        );
    }

    public function toMarkdown(): string
    {
        return sprintf(
            "### %s %s\n\n" .
            "- ID: %d\n" .
            "- Email: %s\n" .
            "- Phone: %s\n" .
            "- Address: %s\n" .
            "- Birth Date: %s\n" .
            "- Membership Expiration Date: %s\n" .
            "- Role: %s\n",
            $this->firstName,
            $this->lastName,
            $this->id,
            $this->email,
            $this->phoneNumber,
            $this->address,
            $this->birthDate->format('Y-m-d'),
            $this->membershipExpirationDate->format('Y-m-d'),
            $this->role
        );
    }

    /**
     * @return array<string, int|string>
     */
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'firstName' => $this->firstName,
            'lastName' => $this->lastName,
            'email' => $this->email,
            'phoneNumber' => $this->phoneNumber,
            'address' => $this->address,
            'birthDate' =>
                $this->birthDate->format('Y-m-d'),
            'membershipExpirationDate' =>
                $this->membershipExpirationDate->format('Y-m-d'),
            'role' => $this->role,
        ];
    }
}