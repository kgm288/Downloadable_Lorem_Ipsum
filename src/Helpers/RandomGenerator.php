<?php

declare(strict_types=1);

namespace Helpers;

use Faker\Factory;
use Faker\Generator;
use Persons\Employee;
use Restaurants\RestaurantChain;
use Restaurants\RestaurantLocation;

class RandomGenerator
{
    private static ?Generator $faker = null;

    /**
     * Fakerオブジェクトを1つだけ生成し、使い回す。
     */
    private static function faker(): Generator
    {
        if (self::$faker === null) {
            self::$faker = Factory::create('en_US');
        }

        return self::$faker;
    }

    /**
     * Employeeオブジェクトを1人生成する。
     */
    public static function employee(
        float $minimumSalary,
        float $maximumSalary
    ): Employee {
        if ($minimumSalary < 0) {
            throw new \InvalidArgumentException(
                'Minimum salary must be zero or greater.'
            );
        }

        if ($maximumSalary < $minimumSalary) {
            throw new \InvalidArgumentException(
                'Maximum salary must be greater than or equal to minimum salary.'
            );
        }

        $faker = self::faker();

        $birthDate = new \DateTimeImmutable(
            $faker
                ->dateTimeBetween('-65 years', '-18 years')
                ->format('Y-m-d')
        );

        $membershipExpirationDate = new \DateTimeImmutable(
            $faker
                ->dateTimeBetween('now', '+3 years')
                ->format('Y-m-d')
        );

        $startDate = new \DateTimeImmutable(
            $faker
                ->dateTimeBetween('-15 years', 'now')
                ->format('Y-m-d')
        );

        $jobTitle = $faker->randomElement([
            'Chef',
            'Cashier',
            'Manager',
            'Server',
            'Kitchen Staff',
        ]);

        $responsibilities = $faker->randomElements(
            [
                'Customer service',
                'Food preparation',
                'Cash handling',
                'Inventory management',
                'Staff training',
                'Cleaning',
                'Order management',
            ],
            $faker->numberBetween(2, 4)
        );

        return new Employee(
            $faker->unique()->numberBetween(1, 1000000),
            $faker->firstName(),
            $faker->lastName(),
            $faker->unique()->safeEmail(),
            password_hash(
                'password123',
                PASSWORD_DEFAULT
            ),
            $faker->phoneNumber(),
            $faker->streetAddress(),
            $birthDate,
            $membershipExpirationDate,
            'employee',
            $jobTitle,
            $faker->randomFloat(
                2,
                $minimumSalary,
                $maximumSalary
            ),
            $startDate,
            $responsibilities
        );
    }

    /**
     * 指定人数分のEmployeeを生成する。
     *
     * @return Employee[]
     */
    public static function employees(
        int $employeeCount,
        float $minimumSalary,
        float $maximumSalary
    ): array {
        if ($employeeCount < 1 || $employeeCount > 100) {
            throw new \InvalidArgumentException(
                'Employee count must be between 1 and 100.'
            );
        }

        $employees = [];

        for ($i = 0; $i < $employeeCount; $i++) {
            $employees[] = self::employee(
                $minimumSalary,
                $maximumSalary
            );
        }

        return $employees;
    }

    /**
     * RestaurantLocationオブジェクトを1店舗生成する。
     */
    public static function restaurantLocation(
        int $employeeCount,
        float $minimumSalary,
        float $maximumSalary,
        int $minimumZipCode,
        int $maximumZipCode
    ): RestaurantLocation {
        if (
            $minimumZipCode < 10000 ||
            $maximumZipCode > 99999 ||
            $maximumZipCode < $minimumZipCode
        ) {
            throw new \InvalidArgumentException(
                'Zip code range must be between 10000 and 99999.'
            );
        }

        $faker = self::faker();

        $city = $faker->city();

        return new RestaurantLocation(
            $city . ' Branch',
            $faker->streetAddress(),
            $city,
            $faker->stateAbbr(),
            (string) $faker->numberBetween(
                $minimumZipCode,
                $maximumZipCode
            ),
            self::employees(
                $employeeCount,
                $minimumSalary,
                $maximumSalary
            ),
            $faker->boolean(85)
        );
    }

    /**
     * 指定店舗数分のRestaurantLocationを生成する。
     *
     * @return RestaurantLocation[]
     */
    public static function restaurantLocations(
        int $locationCount,
        int $employeeCount,
        float $minimumSalary,
        float $maximumSalary,
        int $minimumZipCode,
        int $maximumZipCode
    ): array {
        if ($locationCount < 1 || $locationCount > 50) {
            throw new \InvalidArgumentException(
                'Location count must be between 1 and 50.'
            );
        }

        $restaurantLocations = [];

        for ($i = 0; $i < $locationCount; $i++) {
            $restaurantLocations[] =
                self::restaurantLocation(
                    $employeeCount,
                    $minimumSalary,
                    $maximumSalary,
                    $minimumZipCode,
                    $maximumZipCode
                );
        }

        return $restaurantLocations;
    }

    /**
     * フォーム条件に合わせてRestaurantChainを1つ生成する。
     */
    public static function restaurantChain(
        int $employeeCount,
        float $minimumSalary,
        float $maximumSalary,
        int $locationCount,
        int $minimumZipCode,
        int $maximumZipCode
    ): RestaurantChain {
        $faker = self::faker();

        $restaurantLocations =
            self::restaurantLocations(
                $locationCount,
                $employeeCount,
                $minimumSalary,
                $maximumSalary,
                $minimumZipCode,
                $maximumZipCode
            );

        $companyFoundingYear =
            $faker->numberBetween(1950, 2005);

        $chainFoundingYear =
            $faker->numberBetween(
                $companyFoundingYear,
                2020
            );

        return new RestaurantChain(
            // Companyから継承する情報
            $faker->company(),
            $companyFoundingYear,
            $faker->sentence(12),
            $faker->url(),
            $faker->phoneNumber(),
            'Food Service',
            $faker->name(),
            $faker->boolean(),
            $faker->country(),
            $faker->name(),
            $faker->numberBetween(100, 50000),

            // RestaurantChain固有の情報
            $faker->unique()->numberBetween(1, 100000),
            $restaurantLocations,
            $faker->randomElement([
                'Italian',
                'Japanese',
                'Mexican',
                'American',
                'Chinese',
                'French',
                'Indian',
            ]),
            $faker->boolean(),
            $chainFoundingYear,
            $faker->company()
        );
    }
}