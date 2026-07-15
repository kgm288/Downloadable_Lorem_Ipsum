<?php

declare(strict_types=1);

require_once __DIR__ . '/vendor/autoload.php';

use Helpers\RandomGenerator;

// POST以外のアクセスを拒否する
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    header('Allow: POST');

    exit('Method Not Allowed');
}

// 必要なPOSTパラメータ
$requiredParameters = [
    'employeeCount',
    'minimumSalary',
    'maximumSalary',
    'locationCount',
    'minimumZipCode',
    'maximumZipCode',
    'format',
];

foreach ($requiredParameters as $parameter) {
    if (!isset($_POST[$parameter])) {
        http_response_code(422);

        exit(
            'Missing parameter: ' .
            $parameter
        );
    }
}

// POSTデータを受け取る
$employeeCountInput = $_POST['employeeCount'];
$minimumSalaryInput = $_POST['minimumSalary'];
$maximumSalaryInput = $_POST['maximumSalary'];
$locationCountInput = $_POST['locationCount'];
$minimumZipCodeInput = $_POST['minimumZipCode'];
$maximumZipCodeInput = $_POST['maximumZipCode'];
$format = $_POST['format'];

// 従業員数を検証する
$employeeCount = filter_var(
    $employeeCountInput,
    FILTER_VALIDATE_INT,
    [
        'options' => [
            'min_range' => 1,
            'max_range' => 100,
        ],
    ]
);

if ($employeeCount === false) {
    http_response_code(422);

    exit(
        'Employee count must be an integer ' .
        'between 1 and 100.'
    );
}

// 給与を検証する
$minimumSalary = filter_var(
    $minimumSalaryInput,
    FILTER_VALIDATE_FLOAT
);

$maximumSalary = filter_var(
    $maximumSalaryInput,
    FILTER_VALIDATE_FLOAT
);

if (
    $minimumSalary === false ||
    $maximumSalary === false ||
    $minimumSalary < 0 ||
    $maximumSalary < $minimumSalary
) {
    http_response_code(422);

    exit(
        'Invalid salary range. ' .
        'Maximum salary must be greater than or equal ' .
        'to minimum salary.'
    );
}

// 店舗数を検証する
$locationCount = filter_var(
    $locationCountInput,
    FILTER_VALIDATE_INT,
    [
        'options' => [
            'min_range' => 1,
            'max_range' => 50,
        ],
    ]
);

if ($locationCount === false) {
    http_response_code(422);

    exit(
        'Location count must be an integer ' .
        'between 1 and 50.'
    );
}

// 郵便番号を検証する
$minimumZipCode = filter_var(
    $minimumZipCodeInput,
    FILTER_VALIDATE_INT,
    [
        'options' => [
            'min_range' => 10000,
            'max_range' => 99999,
        ],
    ]
);

$maximumZipCode = filter_var(
    $maximumZipCodeInput,
    FILTER_VALIDATE_INT,
    [
        'options' => [
            'min_range' => 10000,
            'max_range' => 99999,
        ],
    ]
);

if (
    $minimumZipCode === false ||
    $maximumZipCode === false ||
    $maximumZipCode < $minimumZipCode
) {
    http_response_code(422);

    exit(
        'Invalid zip code range. ' .
        'Use values between 10000 and 99999.'
    );
}

// 出力形式を検証する
$allowedFormats = [
    'html',
    'json',
    'txt',
    'markdown',
];

if (
    !is_string($format) ||
    !in_array($format, $allowedFormats, true)
) {
    http_response_code(422);

    exit(
        'Invalid format. Must be one of: ' .
        implode(', ', $allowedFormats)
    );
}

// フォームの条件を使ってRestaurantChainを生成する
$restaurantChain = RandomGenerator::restaurantChain(
    $employeeCount,
    (float) $minimumSalary,
    (float) $maximumSalary,
    $locationCount,
    $minimumZipCode,
    $maximumZipCode
);

switch ($format) {
    case 'markdown':
        header(
            'Content-Type: text/markdown; charset=UTF-8'
        );
        header(
            'Content-Disposition: attachment; ' .
            'filename="restaurant-chain.md"'
        );

        echo $restaurantChain->toMarkdown();
        break;

    case 'json':
        header(
            'Content-Type: application/json; charset=UTF-8'
        );
        header(
            'Content-Disposition: attachment; ' .
            'filename="restaurant-chain.json"'
        );

        try {
            echo json_encode(
                $restaurantChain->toArray(),
                JSON_PRETTY_PRINT |
                JSON_UNESCAPED_UNICODE |
                JSON_UNESCAPED_SLASHES |
                JSON_THROW_ON_ERROR
            );
        } catch (\JsonException $exception) {
            http_response_code(500);

            exit(
                'Failed to encode restaurant chain as JSON.'
            );
        }

        break;

    case 'txt':
        header(
            'Content-Type: text/plain; charset=UTF-8'
        );
        header(
            'Content-Disposition: attachment; ' .
            'filename="restaurant-chain.txt"'
        );

        echo $restaurantChain->toString();
        break;

    case 'html':
        header(
            'Content-Type: text/html; charset=UTF-8'
        );
        header(
            'Content-Disposition: attachment; ' .
            'filename="restaurant-chain.html"'
        );

        $restaurantChainHTML =
            $restaurantChain->toHTML();

        echo '<!DOCTYPE html>';
        echo '<html lang="en">';
        echo '<head>';
        echo '<meta charset="UTF-8">';
        echo '<meta name="viewport" ';
        echo 'content="width=device-width, initial-scale=1.0">';
        echo '<title>Generated Restaurant Chain</title>';

        echo '<style>';
        echo 'body {';
        echo 'max-width: 1100px;';
        echo 'margin: 0 auto;';
        echo 'padding: 24px;';
        echo 'font-family: Arial, sans-serif;';
        echo 'line-height: 1.6;';
        echo '}';
        echo '.restaurant-chain,';
        echo '.company,';
        echo '.restaurant-location,';
        echo '.employee,';
        echo '.user {';
        echo 'margin-bottom: 20px;';
        echo 'padding: 20px;';
        echo 'border: 1px solid #cccccc;';
        echo 'border-radius: 8px;';
        echo '}';
        echo '</style>';

        echo '</head>';
        echo '<body>';
        echo $restaurantChainHTML;
        echo '</body>';
        echo '</html>';
        break;
}