<?php
require_once "pdo.php";
session_start();
$stmt = $pdo->query("SELECT id, sender, receiver, amount, datetime FROM transaction");
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Basic Banking System</title>
        <!-- Latest compiled and minified CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
        <link rel="icon" type="image/png" href="—Pngtree—concept banking logo_4017929.png"/>   
        <script src="https://kit.fontawesome.com/b812635867.js" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="bbs.css"/>
    </head>
    <body>
        <header>
        <nav class="navbar navbar-expand-lg ">
            <div class="container-fluid">
                <span class="navbar-brand fs-1" href="#">
                    <img src="—Pngtree—concept banking logo_4017929.png" alt="" width="85" height="60" class="d-inline-block align-top">
                    The Bank
                </span>
              <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
              </button>
              <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                <div class="navbar-nav fs-4">
                  <a class="nav-link" href="index.php"><i class="fas fa-home">Home</i></a>
                  <a class="nav-link" href="customers.php"><i class="fas fa-users">Customers</i></a>
                  <a class="nav-link active" aria-current="page" href="transactions.php"><i class="fas fa-history">Transactions</i></a>
                </div>
              </div>
            </div>
          </nav>
        </header>
        <main>
            <div class="flex-container" style="background-image: url(bank-notes-941246.jpg);   filter: blur(8px);
        -webkit-filter: blur(8px); opacity: 0.3" id="bg-image">
            </div>
        <section>
            <table class="table table-striped fs-5" id="custo">
                <thead>
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">From</th>
                    <th scope="col">To</th>
                    <th scope="col">Amount</th>  
                    <th scope="col">Timestamp</th>    
                  </tr>
                </thead>
                <tbody>
                  <?php
                  foreach ($rows as $row) {
                    $_SESSION['id'] = $row["id"];
                  echo"<tr>";
                    echo'<th scope="row">'.htmlentities($row["id"]).'</th>';
                    echo'<td>'.htmlentities($row["sender"]).'</td>';
                    echo'<td>'.htmlentities($row["receiver"]).'</td>';
                    echo'<td>&#8377;'.htmlentities($row["amount"]).'</td>';
                    echo'<td>'.htmlentities($row["datetime"]).'</td>';
                  echo"</tr>";
                  }
                  ?>
                </tbody>
              </table>
        </section>
        </main>
        <footer class="flex-container1 fs-5">
            <i class="fab fa-linkedin fa-2x"></i>
            <i class="fab fa-twitter fa-2x"></i>
            <i class="fab fa-facebook-f fa-2x"></i>
            <a href="#">Contact Us </a>
            <a href="#">Help</a>
            <div class="fs-6 ">Image by<a href="https://pixabay.com/users/tbit-715211/?utm_source=link-attribution&amp;utm_medium=referral&amp;utm_campaign=image&amp;utm_content=941246">Thomas Breher</a> from <a href="https://pixabay.com/?utm_source=link-attribution&amp;utm_medium=referral&amp;utm_campaign=image&amp;utm_content=941246">Pixabay</a>
            <a href='https://pngtree.com/so/account'>account png from pngtree.com</a>
            </div>
        </footer>
        <!-- Latest compiled and minified JavaScript -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>
    </body>
</html>