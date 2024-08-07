<?php
$city = $_GET['city'];
$apiKey = 'Your api key';
$url = "http://api.openweathermap.org/data/2.5/weather?q=$city&appid=$apiKey&units=metric";
$response = file_get_contents($url);
$data = json_decode($response, true);
$weatherData = array(
    'city' => $data['name'],
    'temperature' => $data['main']['temp'],
    'humidity' => $data['main']['humidity'],
    'windSpeed' => $data['wind']['speed'],
    'description' => ucfirst($data['weather'][0]['description']),
);
?>
<html>
<head>
    <title>Weather App</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
        }
        #weather-data {
            width: 50%;
            margin: 40px auto;
            padding: 20px;
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        #weather-data ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        #weather-data li {
            margin-bottom: 10px;
        }
        #weather-data li span {
            font-weight: bold;
        }
    </style>
</head>
<body>
    <h1>Weather App</h1>
    <form>
        <input type="text" name="city" placeholder="Enter city name">
        <button type="submit">Get Weather</button>
    </form>
    <div id="weather-data">
        <h2>Weather in:  <?php echo $weatherData['city']; ?></h2>
        <ul>
            <li>Temperature: <span><?php echo $weatherData['temperature']; ?>°C</span></li>
            <li>Humidity: <span><?php echo $weatherData['humidity']; ?>%</span></li>
            <li>Wind Speed: <span><?php echo $weatherData['windSpeed']; ?> m/s</span></li>
            <li>Description: <span><?php echo $weatherData['description']; ?></span></li>
        </ul>
    </div>
</body>
</html>