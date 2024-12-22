<?php
$servername = "localhost"; 
$username = "root";         
$password = "";            
$dbname = "corememories"; 

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql_islands = "SELECT * FROM islandsofpersonality"; 
$result_islands = $conn->query($sql_islands);

$islandsofpersonality = [];
if ($result_islands->num_rows > 0) {
    while($row = $result_islands->fetch_assoc()) {
        $islandsofpersonality[] = $row; 
    }
} else {
    echo "No islands found.";
}


$sql_contents = "SELECT * FROM islandcontents";
$result_contents = $conn->query($sql_contents);

$contents = [];
if ($result_contents->num_rows > 0) {
    while($row = $result_contents->fetch_assoc()) {
        $contents[] = $row;
    }
} else {
    echo "No contents found.";
}
?>

<!DOCTYPE html>
<html>

<head>
  <title>Inside Out</title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
  <link rel="stylesheet" href="https://www.w3schools.com/lib/w3-theme-black.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link href="https://fonts.cdnfonts.com/css/open-sauce-one" rel="stylesheet">
  <link href="https://github.com/jnlldwr/SAM-BE/blob/main/A05/assets/Icon.png?raw=true" rel="icon" type="image/x-icon">
  <link href="https://fonts.cdnfonts.com/css/inside-out" rel="stylesheet">

  <style>
    body,
    p {
      font-family: 'Open Sauce One', sans-serif;
    }

    h1,
    h2,
    h3,
    h4,
    h5,
    h6 {
      font-family: 'Inside Out', sans-serif;
    }

    .card {
      height: 100%;
      display: flex;
      flex-direction: column;
    }

    .card-img-top {
      object-fit: cover;
      display: block;
      margin: 0 auto;
    }

    .card-body {
      display: flex;
      flex-direction: column;
      justify-content: flex-end;
    }

    .navbar {
      background-color: #c89ee6;
    }
  </style>
</head>

<body id="myPage">

  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg fixed-top" style="background-color: #c89ee6;">
    <div class="container-fluid">
      <a class="navbar-brand" href="index.html">
        <img src="https://github.com/jnlldwr/jnlldwr.github.io/blob/main/assets/logo.png?raw=true" height="35">
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#navbarOffcanvasLg"
        aria-controls="navbarOffcanvasLg" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="offcanvas offcanvas-end" tabindex="-1" id="navbarOffcanvasLg"
        aria-labelledby="navbarOffcanvasLgLabel">
        <div class="offcanvas-header">
          <h5 class="offcanvas-title" id="offcanvasNavbarLabel">Inside Out</h5>
          <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
          <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="index.html">Home</a>
            </li>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                aria-expanded="false">
                Personalities
              </a>
              <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="#Music">Music</a></li>
                <li><a class="dropdown-item" href="#Friendship">Friendship</a></li>
                <li><a class="dropdown-item" href="#Gaming">Gaming</a></li>
                <li><a class="dropdown-item" href="#Concert">Concert</a></li>
              </ul>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </nav>

  <!-- Header -->
  <div class="w3-display-container w3-animate-opacity object-fit-cover">
    <img
      src="https://images.squarespace-cdn.com/content/v1/60241cb68df65b530cd84d95/be0e10ca-a260-4f15-a12a-2da19a6c3a1e/i015_11a_bg.bkgd16.1329.jpg?format=2500w"
      style="width:100%;max-height:600px;">
    <div class="card-img-overlay d-flex flex-column justify-content-center align-items-center text-center">
      <h1 class="card-title text-white display-1 fw-bold">Janelle's Personalities</h1>
    </div>
  </div>

  <!-- Islands Container -->
  <div class="container my-5">
    <h1 class="text-center mb-4">Islands of Personality</h1>
    <div class="row g-4">
    <?php
      foreach ($islandsofpersonality as $index => $island) {
          echo '<div class="col-12 col-sm-6 col-md-3">';
          echo '  <div class="card h-100">';
          echo '    <img src="' . $island['image'] . '" class="card-img-top" alt="' . $island['name'] . '">';
          echo '    <div class="card-body d-flex flex-column">';
          echo '      <h5 class="card-title">' . $island['name'] . ' Island</h5>';
          echo '      <p class="card-text">' . $island['shortDescription'] . '</p>';
          echo '    </div>';
          echo '  </div>';
          echo '</div>';

          $startIndex = $index * 3;
          $endIndex = $startIndex + 3;
          $contentIndex = 0;

          for ($i = $startIndex; $i < $endIndex; $i++) {
              if (isset($contents[$i])) {
                  $content = $contents[$i];
                  echo '<div class="col-12 col-sm-6 col-md-3">';
                  echo '  <div class="card h-100">';
                  echo '    <img src="' . $content['image'] . '" class="card-img-top img-fluid" alt="Island Image" style="object-fit: cover; height: 400px;">';
                  echo '    <div class="card-body d-flex flex-column">';
                  echo '      <p class="card-text">' . $content['content'] . '</p>';
                  echo '    </div>';
                  echo '  </div>';
                  echo '</div>';
              }
          }
      }
    ?>
    </div>
  </div>

  <!-- Footer -->
  <footer class="w3-container w3-padding-32 text-white w3-center" style="background-color: #c89ee6;">
    <a class="btn btn-link btn-floating btn-lg text-white m-1" href="https://github.com/jnlldwr/" role="button"><i
        class="fa fa-linkedin"></i></a>
    <a class="btn btn-link btn-floating btn-lg text-white m-1" href="https://www.linkedin.com/in/janelle-diawara/"
      role="button"><i class="fa fa-github"></i></a>
    <a class="btn btn-link btn-floating btn-lg text-white m-1" href="mailto:diawarajanelle@gmail.com" role="button"><i
        class="fa fa-envelope"></i></a>
    <p> &copy 2024 Janelle Diawara. </p>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous"></script>

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</body>

</html>
