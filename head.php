<!-- head.php -->
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title><?= isset($title) ? $title : "Codelabs | Simple CRUD" ?></title>
    
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css"
      rel="stylesheet"
      crossorigin="anonymous"
    />

    <style>
      /* Tema Pink Navbar */
      .navbar-pink {
        background-color: rgb(225, 173, 230)  !important; 
      }
      .navbar-pink .navbar-brand,
      .navbar-pink .nav-link {
        color: white !important;
      }
      .navbar-pink .nav-link:hover {
        color:rgb(241, 212, 237) !important;
      }
      .navbar-toggler {
        border-color: white;
      }
      .navbar-toggler-icon {
        background-image: url("data:image/svg+xml,%3csvg viewBox='0 0 30 30' xmlns='http://www.w3.org/2000/svg'%3e%3cpath stroke='rgba%28255,255,255,1%29)' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
      }
    </style>
  </head>
  <body>
<nav class="navbar navbar-expand-lg navbar-pink">
  <div class="container">
    <a class="navbar-brand" href="./index.php">Simple CRUD</a>
    <button
      class="navbar-toggler"
      type="button"
      data-bs-toggle="collapse"
      data-bs-target="#navbarNavAltMarkup"
      aria-controls="navbarNavAltMarkup"
      aria-expanded="false"
      aria-label="Toggle navigation"
    >
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
      <div class="navbar-nav">
        <a class="nav-link" href="./index.php">Manajement User</a>
        <a class="nav-link" href="./create_user.php">Login User</a>
      </div>
    </div>
  </div>
</nav>