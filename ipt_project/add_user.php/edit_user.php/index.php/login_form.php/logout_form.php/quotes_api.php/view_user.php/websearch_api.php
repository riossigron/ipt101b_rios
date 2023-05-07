<!DOCTYPE html>
<html lang="en">
<head>
  <title>JoJ Web Search API</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <style>
    body {
      background-image: url("../ipt_project/bg_color.jpg");
      background-size: cover;
    }

    .result {
      margin-bottom: 20px;
      padding: 20px;
      background-color: #f8f8f8;
      border-radius: 5px;
    }

    .result-title {
      font-size: 18px;
      font-weight: bold;
    }

    .result-url {
      font-size: 14px;
      color: #666;
    }

    .result-description {
      margin-top: 10px;
      font-size: 16px;
    }
  </style>
</head>
<body>
<br><br>

<div class="container">
  <h2>Web Search</h2><br>
  
  <form action="" method="get">
    <div class="form-group">
    <label for="searchQuery" style="font-size: 17px; margin-top: 1px;">Search Query:</label>
    <br><br>
    <input type="text" class="form-control" style="margin-bottom: 1px;" placeholder="Enter search query" name="searchQuery" required>
    </div>
    <input type="submit" name="search-btn" class="btn btn-success" value="Search">
  </form>
  <div style="margin-top: 10px;">
    <a class="btn btn-primary" href="index.php">Home</a>
  </div>
  <br>

  <?php
    if (isset($_GET['search-btn'])) {
      $searchQuery = $_GET['searchQuery'];

      $curl = curl_init();

      curl_setopt_array($curl, [
        CURLOPT_URL => "https://joj-web-search.p.rapidapi.com/?query=" . urlencode($searchQuery) . "&limit=10&related_keywords=true",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => [
          "X-RapidAPI-Host: joj-web-search.p.rapidapi.com",
          "X-RapidAPI-Key: a5e279f135msh297719df972ddcfp1b4112jsn628b175192fd"
        ],
      ]);

      $response = curl_exec($curl);
      $err = curl_error($curl);

      curl_close($curl);

      if ($err) {
        echo "cURL Error #:" . $err;
        }else {
        $results = json_decode($response, true);

        if ($results && isset($results['results'])) {
            foreach ($results['results'] as $result) {
                echo '<div class="result">';
                echo '<h3 class="result-title">' . $result['title'] . '</h3>';

                if (isset($result['url'])) {
                echo '<a class="result-url" href="' . $result['url'] . '">' . $result['url'] . '</a>';
                    }

                echo '<p class="result-description">' . $result['description'] . '</p>';

                echo '</div>';
                }
            }else {
                echo '<p>No Results found for the search query: <strong>' . $searchQuery . '</strong></p>';
                }
            }
        }
    ?>
        
    </div>
</body>
</html>
