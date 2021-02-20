<?php
require_once "pdo.php";
session_start();

if ( isset($_POST['id']) ){
    $_SESSION['id'] = $_POST['id'];
    header("Location: transfer.php");
    return;
}
if ( isset($_POST['email1']) ){
    $_SESSION['email1'] = $_POST['email1'];
    header("Location: transfer.php");
    return;
}
if ( isset($_POST['amount']) ){
    $_SESSION['amount'] = $_POST['amount'];
    header("Location: transfer.php");
    return;
}
if ( isset($_SESSION['amount']) ){
    $amount = "UPDATE customers SET balance = balance + :amount WHERE email = :email1";
    $stmt = $pdo->prepare($amount);
    $stmt-> execute(array(
        ':amount'=>$_SESSION['amount'],
        ':email1'=>$_SESSION['email1']
    ));
    
    $amount = "UPDATE customers SET balance = balance - :amount WHERE id = :id";
    $stmt = $pdo->prepare($amount);
    $stmt-> execute(array(
        ':amount'=>$_SESSION['amount'],
        ':id'=>$_SESSION['id'] 
    ));
    

}
$result = $pdo->query("SELECT id, name, email, balance FROM customers WHERE id = '".$_SESSION['id']."'");
$row = $result->fetch(PDO::FETCH_ASSOC);
if ( isset($_SESSION['email1']) ){
    $result = $pdo->query("SELECT id, name, email, balance FROM customers WHERE email = '".$_SESSION['email1']."'");
    $row1 = $result->fetch(PDO::FETCH_ASSOC);
        if($row1===false){
            $_SESSION['error'] = 'Account not found !';
        }
        else{
            unset($_SESSION['error']);
        }
}

if ( isset($_SESSION['amount']) ){
    
    $sql = "INSERT INTO transaction(sender, receiver, amount) VALUES (:sender, :receiver, :amount)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(':sender'=>$row['name'], ':receiver'=>$row1['name'], ':amount'=>$_SESSION['amount']));
    $_SESSION['success'] = 'Transaction Successful !';
    
}


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
        <nav class="navbar navbar-expand-lg">
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
                  <a class="nav-link" href="transactions.php"><i class="fas fa-history">Transactions</i></a>
                </div>
              </div>
            </div>
          </nav>
        </header>
        <main>
            <div class="flex-container" style="background-image: url(bank-notes-941246.jpg);   filter: blur(8px);
        -webkit-filter: blur(8px); opacity: 0.3" id="bg-image">
            </div>
        <section id="transfer">
        <h2>Sender</h2>
        <table class="table table-striped fs-5">
            <thead>
                <tr>
                <th scope="col">#</th>
                <th scope="col">Name</th>
                <th scope="col">Email</th>
                <th scope="col">Balance</th>
                </tr>
            </thead>
            <?php
            echo '<tbody>
                <tr>
                <th scope="row">1</th>
                <td>'.$row["name"].'</td>
                <td>'.$row["email"].'</td>
                <td>&#8377; '.$row["balance"].'</td>
                </tr>
            </tbody>';
            ?>
        </table>
        <h2>Receiver</h2><br>
        <form action="transfer.php" method="post">
            <label id='srch'>Transfer to: <input type='email' placeholder='  Enter email-id' name='email1'> </label> <button type="submit" style="border-radius: 30px"><i class="fas fa-search"></i></button> <?php
            if ( isset($_SESSION['error']) ) {
              echo('<span style="color: red;">'.htmlentities($_SESSION['error'])."</span>\n");
              unset($_SESSION['error']);
            }
            ?>
        </form>
        <table class="table table-striped fs-5">
            <thead>
                <tr>
                <th scope="col">#</th>
                <th scope="col">Name</th>
                <th scope="col">Email</th>
                <th scope="col">Balance</th>
                </tr>
            </thead>
            <?php
            if ( isset($_SESSION['email1']) ){
                if(!$row1===false){
                    echo '<tbody>
                    <tr>
                    <th scope="row">1</th>
                    <td>'.$row1["name"].'</td>
                    <td>'.$row1["email"].'</td>
                    <td>*********</td>
                    </tr>
                </tbody>';
                }
                else{
                    echo '<tbody>
                    <tr>
                    <th scope="row">-</th>
                    <td>-</td>
                    <td>-</td>
                    <td>-</td>
                    </tr>
                </tbody>';
                }
            }
            else{
                echo '<tbody>
                    <tr>
                    <th scope="row">-</th>
                    <td>-</td>
                    <td>-</td>
                    <td>-</td>
                    </tr>
                </tbody>';
            }
            
            unset($_SESSION['error']);
            if ( isset($_SESSION['amount']) ){
                unset($_SESSION['email1']);
                unset($_SESSION['amount']);
            }
            ?>
        </table>
        <form action="transfer.php" method="post">
            <label id='srch'>Amount: <input type='number' placeholder='  &#8377;' name = 'amount'> <button type="submit" id='transferbut'>Transfer</button></label> <?php
        if ( isset($_SESSION['success']) ) {
            echo '<p style="color:green">'.$_SESSION['success']."</p>\n";
            unset($_SESSION['success']);
            }
        ?>
        </form>
        
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