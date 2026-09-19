<?php 

function getMovies (string $endpoint) {
     $curl = curl_init();

    curl_setopt_array($curl, [
        CURLOPT_URL => $endpoint, 
        CURLOPT_RETURNTRANSFER => true, 
        CURLOPT_HTTPHEADER => [ 
        'Authorization: Bearer eyJhbGciOiJIUzI1NiJ9.eyJhdWQiOiI2NDNkN2EyMzVmNDkxZmRlZDZjMGViMjIzYTJjOTE0YyIsIm5iZiI6MTc4OTM1Mjg3Ny45ODUsInN1YiI6IjZhYTc1YmFkYjQ2MzEwZWM3NGMxODBmMSIsInNjb3BlcyI6WyJhcGlfcmVhZCJdLCJ2ZXJzaW9uIjoxfQ.QYPxMwAfCpbUYuQlIFj_ITgtDIZW7xSjAFkqflsZdz0', 
        'Accepts: application/json']
    ]);


    $response = curl_exec($curl); 
    $results = json_decode($response, true )["results"];
    return $results;
}


if(isset($_GET["search"])) {

    $judul_film =urlencode ($_GET["search"]);
    $endpoint = "https://api.themoviedb.org/3/search/movie?query=$judul_film";
    $movies = getMovies($endpoint);
   
} else {
    $endpoint= "https://api.themoviedb.org/3/movie/popular";
    $movies = getMovies($endpoint);
  
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Web Film</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <form action="" method="get" class="search-form"> 
        <input type="text" name="search" placeholder="Cari Film...">
        <button type="submit">Cari</button>
    </form>


    <?php if (isset($movies)): ?>
        <div class="movie-list">
            <?php foreach ($movies as $movie): ?>
                <div class="card">
                    <img src="https://image.tmdb.org/t/p/w500<?= $movie["poster_path"]?>" alt=""  width="200px">
                    <div class="card-body">
                        <h3><?= $movie["title"]; ?></h3>
                        <p class="rating">Rating: <?= $movie["vote_average"]; ?></p>
                        <p class="date">Tanggal Rilis: <?= $movie["release_date"]; ?></p>
                        <p class="overview">Sinopsis: <?= $movie["overview"]; ?></p>
                    </div>
                </div>
            <?php endforeach ?>
        </div>
    <?php endif ?>

</body>
</html>
