<?php
$status = "";
$msg = "";
$city = "";
$api = 'your_api_key';

if (isset($_POST['submit'])) {
    $city = $_POST['city'];
    $url = "http://api.openweathermap.org/data/2.5/weather?q=$city&appid=$api";
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $result = curl_exec($ch);

    if ($result === false) {
        $msg = "cURL Error: " . curl_error($ch);
    } else {
        $result = json_decode($result, true);
        if (isset($result['cod']) && $result['cod'] == 200) {
            $status = "yes";
        } else {
            $msg = isset($result['message']) ? $result['message'] : "Unknown error";
        }
    }

    curl_close($ch);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Weather App</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        body {
            background: linear-gradient(to right, #d3cce3, #e9e4f0);
            font-family: 'Arial', sans-serif;
        }
        .container {
            max-width: 600px;
        }
        .card {
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
        }
        .card-header {
            background-color: #007bff;
            color: white;
            text-align: center;
            padding: 20px;
        }
        .card-header img {
            width: 80px;
        }
        .card-body {
            background-color: #f8f9fa;
            padding: 20px;
        }
        .card-footer {
            background-color: #007bff;
            color: white;
            text-align: center;
            padding: 5px;
        }
        .btn-custom {
            background-color: #007bff;
            color: white;
        }
        .btn-custom:hover {
            background-color: #0056b3;
        }
        .form-group input {
            border-radius: 25px;
        }
        .alert {
            border-radius: 25px;
        }
        .info-div {
            display: none;
            margin-top: 20px;
            padding: 20px;
            border: 1px solid #007bff;
            border-radius: 10px;
            background-color: #e9f7ff;
        }
        .info-div.show {
            display: block;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                
                <form method="post" class="mb-4">
                    <h2 class="text-center mb-4"><u>Check the Weather</u></h2>
                    <div class="form-group">
                        <input type="text" class="form-control form-control-lg" placeholder="Enter city name" name="city" value="<?php echo htmlspecialchars($city) ?>">
                    </div>
                    <br>
                    <button type="submit" class="btn btn-custom btn-lg w-100" name="submit">Click to Get Weather Details</button>
                    <?php if ($msg) { ?>
                        <div class="alert alert-danger mt-3"><?php echo ($msg) ?></div>
                    <?php } ?>
                </form>
            </div>
        </div>
    </div>

    <?php if ($status == "yes") { ?>
        <div class="container mt-5">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <img src="http://openweathermap.org/img/wn/<?php echo ($result['weather'][0]['icon']) ?>@4x.png" alt="Weather Icon" />
                        </div>
                        <div class="card-body">
                            <h5 class="card-title text-center"><?php echo ($result['name']) ?></h5>
                            <p class="card-text">Temperature: <?php echo round($result['main']['temp'] - 273.15) ?>°C</p>
                            <p class="card-text">Weather Condition: <?php echo ($result['weather'][0]['main']) ?></p>
                            <p class="card-text">Wind Speed: <?php echo ($result['wind']['speed']) ?> m/h</p>
                        </div>
                        <div class="card-footer">
                            <p class="card-text mb-0"><?php echo date('d M', $result['dt']) ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
