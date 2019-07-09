<!DOCTYPE html>
<html lang="en">
<html>
<head>
    <meta charset="UTF-8">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
<link rel="stylesheet" type="text/css" href="main.css">
    <title>Słownik - Marta Kaszuba</title>
</head>
<body>
<p>Uwaga: wyszukiwarka nie gwarantuje, że wszystkie odpowiedzi będą prawidłowe, w razie nieprawidłowości
proszę sprawdzić słowo w innym słowniku</p>
    <div id="main">
    <form method="get">
    <div class="form-group">
    <h5>Wpisz szukane słowo:</h5>
    <input type="text" id="text" class="form-control" name="text">
    <button type="submit" name ="submit" class="btn btn-success">Szukaj</button>
    </div>
    </form>
    </div> 
<?php
if (isset($_GET["submit"]) && (!empty(trim($_GET["text"])))){
   $txt = trim($_GET["text"]);
   for($i=0; $i<strlen($txt); $i++){
    if ($txt[$i] === " "){
        $txt[$i] ="+";
    }
}

   $str = file_get_contents("https://www.diki.pl/slownik-angielskiego?q=".$txt);
preg_match_all('/<a href=.*? class="plainLink">.*?a>/',$str, $match);
$str2 = file_get_contents("https://www.diki.pl/slownik-niemieckiego?q=".$txt);
preg_match_all('/<a href=.*? class="plainLink">.*?a>/',$str2, $match2);
if (count($match[0]) ===0 || count($match2[0]) ===0){
echo '<div class="bg-danger text-white err"><h5>Nie znaleziono wyniku!</h5></div>';
}
    
else {
    $ind = strpos($match[0][0], ">");
    $match[0][0] = substr($match[0][0], $ind+1);
    $ind2 = strpos($match2[0][0], ">");
    $match2[0][0] = substr($match2[0][0], $ind2+1);
    $searcheng = $match[0][0];
    $searchdeutsch = $match2[0][0];
    for($j=0; $j<strlen($txt); $j++){
        if ($txt[$j] === "+"){
            $txt[$j] =" ";
        }
    }
    
    echo '<div class="result border bg-light shadow p-3 mb-5">';
    echo "<h4>".$txt."</h4>";
    echo '<h5>'.$txt. ' po angielsku to :<span class="text-primary">'.$searcheng.'</h5>';
    echo '<h5>'.$txt. ' po niemiecku to : <span class="text-primary">'.$searchdeutsch.'</span></h5>';
    echo "</div>";
}
}
?>
</body>
</html>




