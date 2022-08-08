<?php
if (!empty($_GET['location'])) {
    // acceder à l'url de google map
    $maps_url = 'https://maps.googleapis.com/maps/api/geocode/json?address=' . urlencode($_GET['location']);
    $maps_json = file_get_contents($maps_url);
    // transformer le fichier json renvoyé par le lien en un array php
    $maps_array = json_decode($maps_json, true);

    $lat = $maps_array['results'][0]['geometry']['location']['lat'];
    $lng = $maps_array['results'][0]['geometry']['location']['lng'];

    // acceder à l'url (api instagram) 
    $insta_url = 'https://api.instagram.com/v1/media/search?lat=' . $lat .'&lng=' . $lng .'&client_id=59cd273f121d4139b97a8a027a993ddf';

    $insta_json = file_get_contents($insta_url);
    $insta_array = json_decode($insta_json, true);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <title>API GOOGLE/INSTAGRAM</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
</head>
<body>
<form action="" method="get">
    <input type="text" name="location"/>
    <button type="submit">Submit</button>
</form>
<br/>
<div id="results" data-url="<?php if (!empty( $insta_url)) echo  $insta_url ?>">
    <?php
    if (!empty($insta_array)) {
        foreach ($insta_array['data'] as $image) {
            echo '<img src="' . $image['images']['low_resolution']['url'] . '" alt=""/><br/>';
        }
    }
    ?>
</div>
</body>
</html>