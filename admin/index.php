<?php
session_start();
require_once "includes/db_connect.php";
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Xtreme Fitness|Admin</title>
    <link rel="stylesheet" href="css/mystyle.css?v=<?php echo time(); ?>">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Sharp" rel="stylesheet">
</head>

<body>
    <div class="container">
        <?php
        $activemenu="home";
        include "includes/menu.php";
        $fNameQuery = "SELECT user_details.firstname FROM user_details WHERE email='".$_SESSION['username']."'";
        $nameResult = $conn->query($fNameQuery);
        $fName = $nameResult->fetch(PDO::FETCH_ASSOC);
        ?>
        <main>
            <h1>Xtreme Fitness Dashboard</h1>
            <div class="date">
                <?php 
                    echo date("l")." ".date("d/m/y");
                ?>
            </div>

            <div class="insights">
                <!---monthly users----->
                <div class="sales">
                    <span class="material-icons-sharp">analytics</span>
                    <div class="middle">
                        <div class="left">
                            <h3>Monthly users</h3>
                            <h1>100</h1>
                        </div>
                        <div class="progress">
                            <svg>
                                <circle cx='38' cy='38' r='36'></circle>
                            </svg>
                            <div class="number">
                                <p>81%</p>
                            </div>
                        </div>

                    </div>

                    <small class="text-muted">Last 24h</small>
                </div>
                <!--- end monthly users----->


                <!---yearly users----->
                <div class="expenses">
                    <span class="material-icons-sharp">analytics</span>
                    <div class="middle">
                        <div class="left">
                            <h3>Yearly users</h3>
                            <h1>100</h1>
                        </div>
                        <div class="progress">
                            <svg>
                                <circle cx='38' cy='38' r='36'></circle>
                            </svg>
                            <div class="number">
                                <p>81%</p>
                            </div>
                        </div>

                    </div>

                    <small class="text-muted">Last 24h</small>
                </div>
                <!--- end yearly users----->

                <!---total users----->
                <div class="income">
                    <span class="material-icons-sharp">analytics</span>
                    <div class="middle">
                        <div class="left">
                            <h3>Total users</h3>
                            <h1>100</h1>
                        </div>
                        <div class="progress">
                            <svg>
                                <circle cx='38' cy='38' r='36'></circle>
                            </svg>
                            <div class="number">
                                <p>81%</p>
                            </div>
                        </div>

                    </div>

                    <small class="text-muted">Last 24h</small>
                </div>
                <!--- end total users----->

            </div>
            <!----end of insights---------->

            <div class="recent-orders">
                <h2>Payments</h2>
                <table>
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Date</th>
                            <th>Amount</th>
                            <th>Status</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Tom Sawyer</td>
                            <td>24 July 2022</td>
                            <td>Rs 3000</td>
                            <td class="warning">Pending</td>
                            <td class="primary">Details</td>
                        </tr>

                        <tr>
                            <td>Tom Holland</td>
                            <td>24 July 2022</td>
                            <td>Rs 3000</td>
                            <td class="warning">Pending</td>
                            <td class="primary">Details</td>
                        </tr>

                        <tr>
                            <td>Tom Mauritius</td>
                            <td>24 July 2022</td>
                            <td>Rs 3000</td>
                            <td class="warning">Pending</td>
                            <td class="primary">Details</td>
                        </tr>

                        <tr>
                            <td>Tom Curepipe</td>
                            <td>24 July 2022</td>
                            <td>Rs 3000</td>
                            <td class="danger">Due</td>
                            <td class="primary">Details</td>
                        </tr>
                    </tbody>
                </table>
                <a href="#">Show All</a>
            </div>

        </main>


        <div class="right">
            <div class="top">

                <div class="profile">
                    <div class="info">
                        <p><b><?php echo $fName['firstname']; ?></b></p>
                        <small class="text-muted">Admin</small>
                    </div>
                    <div class="profile-photo">
                        <span class="material-icons-sharp">account_circle</span>
                    </div>
                </div>
            </div>

            <!------------end of top---->
            <div class="recent-updates">
                <h2>Recent Comments</h2>
                <div class="updates">
                    <div class="update">
                        <div class="profile-photo">
                            <span class="material-icons-sharp">account_circle</span>
                        </div>
                        <div class="message">
                            <p><b>Mike Tyzong</b> commented bad gym</p>
                            <small class="text-muted">2 min ago</small>
                        </div>
                    </div>

                    <div class="update">
                        <div class="profile-photo">
                            <span class="material-icons-sharp">account_circle</span>
                        </div>
                        <div class="message">
                            <p><b>Mike Remapart </b>commented bad gym</p>
                            <small class="text-muted">2 min ago</small>
                        </div>
                    </div>


                    <div class="update">
                        <div class="profile-photo">
                            <span class="material-icons-sharp">account_circle</span>
                        </div>
                        <div class="message">
                            <p><b>Mike Montagne </b>commented bad gym</p>
                            <small class="text-muted">2 min ago</small>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</body>

</html>