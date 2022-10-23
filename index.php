
<?php

$apikey = "eeae4be2b869d5fe5cb98dfcc48dbcc4";
$city = "London";

if(isset($_POST['submit'])){
    $city = $_POST['city'];
}

$url = "https://api.openweathermap.org/data/2.5/weather?q=" .$city. "&appid=".$apikey."&units=metric";
$weatherdata = json_decode(@file_get_contents($url), true);

if (strpos($http_response_header[0], "200")) { 
    
 } else { 
    $weatherdata = json_decode(file_get_contents("https://api.openweathermap.org/data/2.5/weather?q=london&appid=".$apikey."&units=metric"), true);
    $error = "Invalid city name";
 }

$tmzoffset = $weatherdata['timezone'];

$sunriseunix = $weatherdata['sys']['sunrise'];
$sunsetunix = $weatherdata['sys']['sunset'];

$tmz = timezone_name_from_abbr("",$tmzoffset,0);
$dt = new DateTime('now', new DateTimeZone($tmz));

$dt->setTimestamp($sunriseunix);
$sunrise = $dt->format('H:i');

$dt->setTimestamp($sunsetunix);
$sunset = $dt->format('G:i');

$high = round($weatherdata['main']['temp_max']).'°C';
$low = round($weatherdata['main']['temp_min']).'°C';
$celsius = round($weatherdata['main']['temp']).'°C';
$feels = round($weatherdata['main']['feels_like']).'°C';
$pressure = $weatherdata['main']['pressure'].' hPa';
$humidity = $weatherdata['main']['humidity'].'%';
$wind = $weatherdata['wind']['speed'].' m/s';
$clouds = $weatherdata['clouds']['all'].'%';
$visibility = $weatherdata['visibility'].' km';
$bgsrc = '';

$weathermain = $weatherdata['weather'][0]['main'];
if($weathermain =='Clouds'){
    $bgsrc = './backgrounds/haze.mp4'; 
}elseif($weathermain =='Rain'){
    $bgsrc = './backgrounds/rains.mp4';
}elseif($weathermain =='Thunderstorm'){
    $bgsrc = './backgrounds/lightning.mp4';
}elseif($weathermain =='Drizzle'){
    $bgsrc = './backgrounds/rain.mp4';
}elseif($weathermain =='Snow'){
    $bgsrc = './backgrounds/snow.mp4';
}elseif($weathermain =='Clear'){
    $bgsrc = './backgrounds/clear.mp4';
}elseif($weathermain =='Haze'){
    $bgsrc = './backgrounds/haze.mp4';
}elseif($weathermain =='Mist'){
    $bgsrc = './backgrounds/fog.mp4';
}elseif($weathermain =='Fog'){
    $bgsrc = './backgrounds/fog.mp4';
}



echo '<pre>';
print_r($weatherdata);
echo '</pre>';


?>
<style>
<?php include 'index.css'; ?>
</style>

<!DOCTYPE html>
<html>
    <head>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Roboto+Mono:wght@100;500&display=swap" rel="stylesheet">
        <meta content="width=device-width, initial-scale=1" name="viewport" />
    </head>
    <body>
        <div class='app-body'>
            <div class='form'> 
                <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST" >
                    <label for="city">Find Your City:</label><br>
                    <input type="text" id="city" name="city" placeholder="e.g London"><br><br>
                    <input type="submit" value="submit" name="submit">
                    <div class="error-box">
                    <?php if(isset($error)){?>
                    <div class="error"> 
                        <h6><?= $error?></h6>
                    </div>
                    <?php } ?>
                </div>
                </form> 
              
            </div>
            <div class='weather-container'>
                <video autoplay muted loop class='video'>
                    <source src=<?= $bgsrc?> type="video/mp4" >
                </video>
                <div class='weather-header'>
                    <h1><?= $weatherdata['name']?>  </h1>
                    <h1><?= $celsius?></h1>
                    <h4><?= $weatherdata['weather'][0]['description']?></h4>
                    <h6><?= 'H'.$high.'  |  L'.$low  ?> </h6>
                </div>
                <div class='weather-data'>
                    <div class="row">
                        <div class="column">
                            <p>SUNRISE</p><h4><?= $sunrise ?></h4>
                            <p>PRESSURE</p><h4><?= $pressure ?></h4>
                            <p>WIND SPEED</p><h4><?= $wind ?></h4>
                            <p>VISIBILITY</p><h4><?= $visibility ?></h4>
                        </div>
                        <div class="column">
                        <p>SUNSET</p><h4><?= $sunset ?></h4>
                        <p>FEELS LIKE</p><h4><?= $feels ?></h4>
                        <p>HUMIDITY</p><h4><?= $humidity ?></h4>
                        <p>CLOUDS</p><h4><?= $clouds ?></h4>
                        </div>
                    </div>  
                </div>
            </div>
        </div>
    </body>
</hmtl>