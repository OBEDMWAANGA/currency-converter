<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RMB to ZMW Calculator</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #2c2c2c;
            color: #ffffff;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .container {
            text-align: center;
            background-color: #333333;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
        }

        .converter {
            margin-bottom: 20px;
        }

        input {
            padding: 10px;
            border-radius: 5px;
            border: none;
            margin-right: 10px;
        }

        button {
            padding: 10px 20px;
            border-radius: 5px;
            border: none;
            background-color: #4caf50;
            color: #ffffff;
            cursor: pointer;
        }

        button:hover {
            background-color: #45a049;
        }

        .result {
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>RMB to ZMW Calculator</h1>
        <div class="converter">
            <form id="converterForm">
                <label for="amount">Amount in RMB:</label>
                <input type="text" id="amount" name="amount" required>
                <button type="submit">Calculate</button>
                <a href="set_rate.php"><button type="button">Admin</button></a>
            </form>
        </div>
        <div class="result" id="result"></div>
    </div>

    <script>
        async function getExchangeRate() {
            try {
                const response = await fetch('get_rate.php');
                if (!response.ok) {
                    throw new Error('Error fetching exchange rate.');
                }
                const data = await response.json();
                return data.rate;
            } catch (error) {
                console.error(error);
                return null;
            }
        }

        function getCharge(amountInKwacha) {
            const charges = [
                [100, 500, 30],
                [501, 1500, 55],
                [1501, 3000, 100],
                [3001, 4500, 130],
                [4501, 6000, 180],
                [6001, 7500, 230],
                [7501, 9000, 280],
                [9001, 11000, 350],
                [11001, 13000, 400],
                [13001, 15000, 500],
                [15001, 20000, 550],
                [20001, 25000, 600],
                [25001, 35000, 750],
                [35001, 45000, 1000],
                [50001, 70000, 1200],
                [70001, 100000, 1500],
            ];

            for (const [min, max, charge] of charges) {
                if (amountInKwacha >= min && amountInKwacha <= max) {
                    return charge;
                }
            }
            return 0; // Default if no tier is met
        }

        document.getElementById('converterForm').addEventListener('submit', async (event) => {
            event.preventDefault();

            const amountInRMB = parseFloat(document.getElementById('amount').value);
            if (isNaN(amountInRMB) || amountInRMB <= 0) {
                document.getElementById('result').innerHTML = "Invalid amount.";
                return;
            }

            const rate = await getExchangeRate();
            if (rate === null) {
                document.getElementById('result').innerHTML = "Error fetching exchange rate.";
                return;
            }

            const amountInKwacha = amountInRMB * rate;
            const charge = getCharge(amountInKwacha);
            const totalAmount = amountInKwacha + charge;
            document.getElementById('result').innerHTML = `Amount in Kwacha: K${amountInKwacha.toFixed(2)}<br>Charge: K${charge.toFixed(2)}<br>Total amount: K${totalAmount.toFixed(2)}`;
        });
    </script>
</body>
</html>
