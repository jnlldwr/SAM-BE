<?php
$servername = "localhost"; 
$username = "root";         
$password = "";            
$dbname = "corememories"; 

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM islandsofpersonality"; 
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $islandsofpersonality = [];
    while($row = $result->fetch_assoc()) {
        $islandsofpersonality[] = $row; 
    }
} else {
    echo "0 results";
}

$conn->close();
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
      /* Align text to the bottom */
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

  <!-- Modal -->
  <div id="id01" class="w3-modal">
    <div class="w3-modal-content w3-card-4 w3-animate-top">
      <header class="w3-container w3-teal w3-display-container">
        <span onclick="document.getElementById('id01').style.display='none'"
          class="w3-button w3-teal w3-display-topright"><i class="fa fa-remove"></i></span>
        <h4>Title</h4>
        <h5>Description</h5>
      </header>
      <div class="w3-container">
        <p>Text</p>
        <p>Text</p>
      </div>
      <footer class="w3-container w3-teal">
        <p>Modal footer</p>
      </footer>
    </div>
  </div>

  <!-- Islands Container -->
  <div class="container my-5">
    <h1 class="text-center mb-4">Islands of Personality</h1>
    <div class="row g-4">

    <?php
      foreach ($islandsofpersonality as $island) {
          echo '<div class="col-12 col-sm-6 col-md-3">';
          echo '  <div class="card h-100">';
          echo '    <img src="' . $island['image'] . '" class="card-img-top" alt="' . $island['name'] . '">';
          echo '    <div class="card-body d-flex flex-column">';
          echo '      <h5 class="card-title ">' . $island['name'] . ' Island</h5>';
          echo '      <p class="card-text">' . $island['shortDescription'] . '</p>';
          echo '    </div>';
          echo '  </div>';
          echo '</div>';
      }
    ?>
    </div>
  </div>

  <div class="container m-5">
    <div class="row">
      <div class="col-md-4">
        <div class="card">
          <img src="https://via.placeholder.com/400" class="card-img-top" alt="Card Image">
          <div class="card-body">
            <h5 class="card-title">Card Title</h5>
            <p class="card-text">This is the description of the card. The image is centered, and the text is aligned at
              the bottom.</p>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card">
          <img src="https://via.placeholder.com/400" class="card-img-top" alt="Card Image">
          <div class="card-body">
            <h5 class="card-title">Another Card Title</h5>
            <p class="card-text">This is another card with the same layout, where the text is aligned at the bottom.</p>
          </div>
        </div>
      </div>
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
  <!-- <script>
    // Toggle the "See More" and "See Less" functionality
    const toggleBtns = document.querySelectorAll('.toggle-btn');
    toggleBtns.forEach(btn => {
      btn.addEventListener('click', () => {
        const accordionItem = btn.closest('.accordion-item');
        const longDesc = accordionItem.querySelector('.long-description');
        const extraContent = accordionItem.querySelector('.extra-content');
        
        // Collapse all other sections
        document.querySelectorAll('.accordion-item').forEach(item => {
          if (item !== accordionItem) {
            item.querySelector('.long-description').classList.add('d-none');
            item.querySelector('.extra-content').classList.add('d-none');
            item.querySelector('.toggle-btn').textContent = 'See More';
          }
        });
        
        // Toggle current section
        if (longDesc.classList.contains('d-none')) {
          longDesc.classList.remove('d-none');
          extraContent.classList.remove('d-none');
          btn.textContent = 'See Less';
        } else {
          longDesc.classList.add('d-none');
          extraContent.classList.add('d-none');
          btn.textContent = 'See More';
        }
      });
    });
  </script> -->
</body>

</html>