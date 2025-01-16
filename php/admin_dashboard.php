<?php
include('../php/connection.php');

$sql = "SELECT id, username, role, logged_in FROM users";  
$result_users = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="../css/styles.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Salon Elegance</title>
    <link rel="stylesheet" href="../css/header.css">
    
    
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</head>
<style>
        body {
    font-family: 'Times New Roman', Times, serif;
    margin: 0;
    padding: 0;
    background-color: #f4f4f4;
    color: #333; /* Change text color to improve readability */
}

.table-container {
    width: 95%;
    margin: 50px auto;
    padding: 20px;
    background-color: #fff;
    border-radius: 10px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1); /* Slightly deeper shadow for depth */
}

h1, h2 {
    text-align: center;
    color: #f76c6c; /* Keep header color for consistency */
}

h2 {
    margin-top: 20px; /* Add margin for spacing */
    color: #1f2937;
}

/* Improved button styling */
input[type="submit"] {
    background-color: #4CAF50; /* Default to green */
    color: white;
    border: none;
    padding: 8px 15px;
    border-radius: 5px; /* Rounded corners */
    cursor: pointer;
    transition: background-color 0.3s; /* Smooth transition */
}

input[type="submit"]:hover {
    background-color: #45a049; /* Darker green on hover */
}
table {
    width: 100%;
    border-collapse: collapse;
    margin: 20px 0;
    font-size: 16px;
    text-align: left;
}

th, td {
    padding: 12px 15px;
    border: 1px solid #ddd;
}

th {
    background-color:#4f7aa5; /* Header background color */
    color: #333;
    font-weight: bold; /* Make header text bold */
}

tr:nth-child(even) {
    background-color: #f9f9f9; /* Light gray for even rows */
}

tr:hover {
    background-color: #f1f1f1; /* Slightly darker on hover */
}
.dropdown {
    position: relative;
    display: inline-block;
}

.dropdown-content {
    display: none;
    position: absolute;
    background-color: #fff;
    min-width: 160px;
    box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
    z-index: 1;
}

.dropdown:hover .dropdown-content {
    display: block; /* Show dropdown on hover */
}

.dropdown-content p, .dropdown-content a {
    color: #333; /* Color for dropdown items */
    padding: 12px 16px;
    text-decoration: none;
    display: block;
}

.dropdown-content a:hover {
    background-color: #f1f1f1; /* Background color on hover */
}
@media screen and (max-width: 600px) {
    .table-container {
        width: 100%; /* Make tables full width on smaller screens */
    }

    th, td {
        font-size: 14px; /* Slightly smaller font size */
    }

    input[type="submit"] {
        padding: 5px; /* Adjust padding for smaller screens */
    }
}

    </style>
<body>
    <div class="video-background">
        <video autoplay muted loop id="background-video">
            <source src="../image/adbg2.mp4" type="video/mp4">
        </video>
    </div>
    <?php session_start(); ?>
    <header>
        <div class="header-container">
            <div class="logo">
                <img src="../image/logo.png" alt="Salon Elegance logo" class="logo-img">
            </div>
            <nav class="main-nav">
                <div class="salon-info">
                    <h1 class="salon-title">Elegance</h1>
                    <h2 class="salon-subtitle">Hair and Beauty Salon</h2>
                </div>
                <ul>
                    <li class="<?php echo basename($_SERVER['PHP_SELF']) == 'index.php' ? 'active' : ''; ?>"><a href="../index.php">Home</a></li>
                    <li><a href="../index.php#services">Services</a></li>
                    <li><a href="../about.html">About Us</a></li>
                    <li><a href="../php/contact.php">Contact</a></li>
                    <li><a href="../php/products.php">Products</a></li>
                    <li><a href="../php/cart.php">Cart</a></li>
                </ul>
            </nav>
            <div class="header-right">
                <form action="../php/search.php" method="GET" class="search-form">
                    <input type="text" name="query" placeholder="Search...">
                    <button type="submit">Search</button>
                </form>
<!-- User Dropdown -->
<div class="dropdown">
    <button class="dropbtn">
        <i class="fas fa-user"></i>
        <?php if (isset($_SESSION['username'])): ?>
            <?php echo htmlspecialchars($_SESSION['username']); ?>
        <?php else: ?>
            Account
        <?php endif; ?>
    </button>
    <div class="dropdown-content">
        <?php if (isset($_SESSION['username'])): ?>
            <p><?php echo htmlspecialchars($_SESSION['username']); ?></p>
            <p> <?php echo isset($_SESSION['email']) ? htmlspecialchars($_SESSION['email']) : 'Not provided'; ?></p>
            <a href="../php/logout.php">Logout</a>
        <?php else: ?>
            <a href="../login.html">Login</a>
        <?php endif; ?>
    </div>
</div></div>
        </div>
    </header>
    <main>
    <h2 align="center"> Users Table</h2>
<div class="table-container">
    <table align="center">
        <thead>
            <tr>
                <th>ID</th>
                <th>Username</th>
                <th>Role</th>
                <th>Last Login</th>
                <th>Actions</th> 
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result_users && $result_users->num_rows > 0) {
                while ($row = $result_users->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row['id']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['username']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['role']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['logged_in']) . "</td>";
                    echo "<td>
                            <form action='update_user.php' method='GET'>
                                <input type='hidden' name='user_id' value='" . $row['id'] . "'>
                                <input type='submit' value='Update' style='background-color: #4CAF50; color: white; border: none; padding: 5px 10px; cursor: pointer;'>
                            </form>
                            <form action='delete_user.php' method='POST' onsubmit='return confirm(\"Are you sure you want to delete this user?\");'>
                                <input type='hidden' name='user_id' value='" . $row['id'] . "'>
                                <input type='submit' value='Delete' style='background-color: #f44336; color: white; border: none; padding: 5px 10px; cursor: pointer;'>
                            </form>
                          </td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='5'>No users found.</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>        
        <?php
        $conn2 = new mysqli($servername, $username, $password, "hairsalon");
        if ($conn2->connect_error) {
            die("Connection failed: " . $conn2->connect_error);
        }
  $sql2 = "SELECT id, name, email, phone, service, date, time, comments FROM appointments";        
        $result_appointments = $conn2->query($sql2);
        ?>
<h2 align="center">Appointments Table</h2>
<div class="table-container">
    <table align="center">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Service</th>
                <th>Date</th>
                <th>Time</th>
                <th>Comments</th>
                <th>Actions</th> 
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result_appointments && $result_appointments->num_rows > 0) {
                while ($row = $result_appointments->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row['id']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['name']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['email']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['phone']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['service']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['date']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['time']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['comments']) . "</td>";
                    echo "<td>                            
                            <form action='delete_appointment.php' method='POST' onsubmit='return confirm(\"Are you sure you want to delete this appointment?\");'>
                                <input type='hidden' name='appointment_id' value='" . $row['id'] . "'>
                                <input type='submit' value='Cancel' style='background-color: #f44336; color: white; border: none; padding: 5px 10px; cursor: pointer;'>
                            </form>
                          </td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='9'>No appointments found.</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>    
        <?php
        $conn3 = new mysqli($servername, $username, $password, "hairsalon");
        if ($conn3->connect_error) {
            die("Connection failed: " . $conn2->connect_error);
        }
        $sql3= "SELECT order_id, user_id, user_name, email, total_amount, payment_method, order_date, shipping_address FROM orders";
        $result_orders = $conn3->query($sql3);
        ?>
<h2 align="center">Orders Table</h2>
<div class="table-container">
    <table align="center">
        <thead>
            <tr>
                <th>ID</th>
                <th>User ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Total Amount</th>
                <th>Payment Method</th>
                <th>Order Date</th>
                <th>Shipping Address</th>
                <th>Actions</th> 
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result_orders && $result_orders->num_rows > 0) {
                while ($row = $result_orders->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row['order_id']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['user_id']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['user_name']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['email']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['total_amount']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['payment_method']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['order_date']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['shipping_address']) . "</td>";
                    echo "<td>
                            
                            <form action='delete_order.php' method='POST' onsubmit='return confirm(\"Are you sure you want to delete this order?\");'>
                                <input type='hidden' name='order_id' value='" . $row['order_id'] . "'>
                                <input type='submit' value='Cancel' style='background-color: #f44336; color: white; border: none; padding: 5px 10px; cursor: pointer;'>
                            </form>
                          </td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='9'>No orders found.</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>
<?php      
        $conn4 = new mysqli($servername, $username, $password, "hairsalon");
        if ($conn4->connect_error) {
            die("Connection failed: " . $conn4->connect_error);
        }
        $sql4= "SELECT id, name , description , price, image FROM products";
        $result_products = $conn4->query($sql4);
        ?>
<h2 align="center">Products Available Table</h2>
<div class="table-container">
    <table align="center">
        <thead>
            <tr>
                <th>ID</th>
                <th>prod_name</th>
                <th>Description</th>
                <th>Price</th>
                <th>Image</th>
                <th>Actions</th> 
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result_products && $result_products->num_rows > 0) {
                while ($row = $result_products->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row['id']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['name']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['description']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['price']) . "</td>";
                    $imageData = base64_encode($row['image']);
                    echo "<td><img src='data:image/jpeg;base64,{$imageData}' style='width: 100px; height: auto;'/></td>";
                    echo "<td>
                            <form action='update_product.php' method='GET'>
                                <input type='hidden' name='product_id' value='" . $row['id'] . "'>
                                <input type='submit' value='Update' style='background-color: #4CAF50; color: white; border: none; padding: 5px 10px; cursor: pointer;'>
                            </form>
                            <form action='delete_product.php' method='POST' onsubmit='return confirm(\"Are you sure you want to delete this product?\");'>
                                <input type='hidden' name='product_id' value='" . $row['id'] . "'>
                                <input type='submit' value='Delete' style='background-color: #f44336; color: white; border: none; padding: 5px 10px; cursor: pointer;'>
                            </form>
                          </td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='6'>No products found.</td></tr>";
            }
            $conn4->close();
            ?>
        </tbody>
        <h3>If you want to add products <a href="../addprod.html">Click here!!</a></h3>
    </table>
</div>
    </table>
</div>
<?php
        $conn5 = new mysqli($servername, $username, $password, "hairsalon");
        if ($conn5->connect_error) {
            die("Connection failed: " . $conn5->connect_error);
        }
        $sql5= "SELECT id, name, email, subject, message, created_at FROM contacts";
        $result_contact = $conn3->query($sql5);
        ?>
<h2 align="center">Contacts Table</h2>
<div class="table-container">
    <table align="center">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Subject</th>
                <th>Message</th>
                <th>Created_on</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result_contact && $result_contact->num_rows > 0) {
                while ($row = $result_contact->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row['id']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['name']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['email']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['subject']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['message']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['created_at']) . "</td>";
                    echo "<td>
                            <form action='delete_contact.php' method='POST' onsubmit='return confirm(\"Are you sure you want to delete this contact detail?\");'>
                                <input type='hidden' name='contact_id' value='" . $row['id'] . "'>
                                <input type='submit' value='Cancel' style='background-color: #f44336; color: white; border: none; padding: 5px 10px; cursor: pointer;'>
                            </form>
                          </td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='9'>No orders found.</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>
<?php        // Cart table
        $conn6 = new mysqli($servername, $username, $password, "hairsalon");
        if ($conn6->connect_error) {
            die("Connection failed: " . $conn6->connect_error);
        }
        $sql6= "SELECT id, user_id, product_id, quantity FROM cart";
        $result_contact = $conn6->query($sql6);
        ?>
<h2 align="center">Contacts Table</h2>
<div class="table-container">
    <table align="center">
        <thead>
            <tr>
                <th>ID</th>
                <th>User_id</th>
                <th>Product_id</th>
                <th>Quantity</th>
                <th>Actions</th> 
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result_contact && $result_contact->num_rows > 0) {
                while ($row = $result_contact->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row['id']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['user_id']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['product_id']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['quantity']) . "</td>";
                    echo "<td>                            
                            <form action='delete_cart.php' method='POST' onsubmit='return confirm(\"Are you sure you want to delete this contact detail?\");'>
                                <input type='hidden' name='cart_id' value='" . $row['id'] . "'>
                                <input type='submit' value='Delete' style='background-color: #f44336; color: white; border: none; padding: 5px 10px; cursor: pointer;'>
                            </form>
                          </td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='9'>No orders found.</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>        
<?php        // admin table
        $conn7 = new mysqli($servername, $username, $password, "admins");
        if ($conn6->connect_error) {
            die("Connection failed: " . $conn6->connect_error);
        }
        $sql7= "SELECT id, fullname, email, username,password, created_at FROM admins";
        $result_admins = $conn7->query($sql7);
        ?>
<h2 align="center">Admins</h2>
<div class="table-container">
    <table align="center">
        <thead>
            <tr>
                <th>ID</th>
                <th>Fullname</th>
                <th>Email</th>
                <th>Username</th>
                <th>Password</th>
                <th>Created_at</th> 
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result_admins && $result_admins->num_rows > 0) {
                while ($row = $result_admins->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row['id']) . "</td>"; 
                    echo "<td>" . htmlspecialchars($row['fullname']) . "</td>";                    
                    echo "<td>" . htmlspecialchars($row['email']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['username']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['password']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['created_at']) . "</td>";
                    echo "<td>                     
                    <form action='update_admin.php' method='GET'>
                        <input type='hidden' name='admin_id' value='" . $row['id'] . "'>
                        <input type='submit' value='Update' style='background-color: #4CAF50; color: white; border: none; padding: 5px 10px; cursor: pointer;'>
                    </form>
                    <form action='delete_admin.php' method='POST' onsubmit='return confirm(\"Are you sure you want to delete this product?\");'>
                        <input type='hidden' name='admin_id' value='" . $row['id'] . "'>
                        <input type='submit' value='Delete' style='background-color: #f44336; color: white; border: none; padding: 5px 10px; cursor: pointer;'>
                    </form>
                  </td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='9'>No orders found.</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div></main></body></html>
