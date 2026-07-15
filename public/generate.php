<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Restaurant Chain Generator</title>

    <style>
        body {
            max-width: 700px;
            margin: 0 auto;
            padding: 32px;
            font-family: Arial, sans-serif;
            line-height: 1.6;
            background: #f4f4f4;
        }

        form {
            padding: 24px;
            border: 1px solid #cccccc;
            border-radius: 8px;
            background: #ffffff;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 6px;
            font-weight: bold;
        }

        input,
        select,
        button {
            width: 100%;
            box-sizing: border-box;
            padding: 10px;
        }

        .range-inputs {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
        }

        button {
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
    </style>
</head>

<body>
    <h1>Restaurant Chain Generator</h1>

    <p>
        Select the conditions used to generate a restaurant chain.
    </p>

    <form action="download.php" method="post">
        <div class="form-group">
            <label for="employeeCount">
                Number of Employees per Location:
            </label>

            <input
                type="number"
                id="employeeCount"
                name="employeeCount"
                min="1"
                max="100"
                value="5"
                required
            >
        </div>

        <div class="form-group">
            <label>Employee Salary Range:</label>

            <div class="range-inputs">
                <input
                    type="number"
                    name="minimumSalary"
                    min="0"
                    value="30000"
                    step="1000"
                    placeholder="Minimum salary"
                    required
                >

                <input
                    type="number"
                    name="maximumSalary"
                    min="0"
                    value="100000"
                    step="1000"
                    placeholder="Maximum salary"
                    required
                >
            </div>
        </div>

        <div class="form-group">
            <label for="locationCount">
                Number of Restaurant Locations:
            </label>

            <input
                type="number"
                id="locationCount"
                name="locationCount"
                min="1"
                max="50"
                value="3"
                required
            >
        </div>

        <div class="form-group">
            <label>Zip Code Range:</label>

            <div class="range-inputs">
                <input
                    type="number"
                    name="minimumZipCode"
                    min="10000"
                    max="99999"
                    value="10000"
                    placeholder="Minimum zip code"
                    required
                >

                <input
                    type="number"
                    name="maximumZipCode"
                    min="10000"
                    max="99999"
                    value="99999"
                    placeholder="Maximum zip code"
                    required
                >
            </div>
        </div>

        <div class="form-group">
            <label for="format">
                Download Format:
            </label>

            <select id="format" name="format" required>
                <option value="html">HTML</option>
                <option value="json">JSON</option>
                <option value="txt">Text</option>
                <option value="markdown">Markdown</option>
            </select>
        </div>

        <button type="submit">
            Generate Restaurant Chain
        </button>
    </form>
</body>
</html>