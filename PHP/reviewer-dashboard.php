<?php 
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include('./meta.php'); ?>
    <title>QCUJ | REVIEWER DASHBOARD</title>
    <link rel="stylesheet" href="../CSS/reviewer-dashboard.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="header-container" id="header-container">
<!-- header will be display here by fetching reusable files -->
</div>

<nav class="navigation-menus-container"  id="navigation-menus-container">
<!-- navigation menus will be display here by fetching reusable files -->
</nav>

<div class="main-container">
    <div class="content-over">
        <div class="cover-content">
        <h3><strong>Reviewer</strong><br>
    <?php
    if(isset($_SESSION['LOGGED_IN']) && $_SESSION['LOGGED_IN'] === true){
        $firstName = isset($_SESSION['first_name']) ? ucfirst($_SESSION['first_name']) : '';
        $middleName = isset($_SESSION['middle_name']) ? ' ' . ucfirst($_SESSION['middle_name']) : '';
        $lastName = isset($_SESSION['last_name']) ? ' ' . ucfirst($_SESSION['last_name']) : '';
       
        echo $firstName . $middleName . $lastName;
    }
    ?>
</h3>


        </div>
        <button class="btn tbn-primary btn-md" id="btn1" onclick="window.location.href='author-dashboard.php'">As Author</button>
        <button class="btn tbn-primary btn-md" id="btn2" onclick="window.location.href='reviewer-dashboard.php'">As Reviewer</button>
    </div>

</div> 
<div class="main">
    <div class="alert-message" id="alertMessage">
        Alert: No assigned articles for review as of now. Further, please ensure you have an ORCID ID linked to get assigned.
    </div>
    <div class="stats-section">
        <div class="stat-card top-card">
            <h2>Total Assigned</h2>
            <p>98 <span class="increase">+11%</span></p>
        </div>
    </div> 
    <hr class="full-width">
    <div class="row">
        <div class="articles-section full-width">
            <div class="tabs">
                <div class="tab active">All Assigned</div>
                    <div class="tab">Pending</div>
                        <div class="tab">Done</div>
                            <button class="btn" id="btn3">Add New</button>
                        </div>

                        <table>
                            <thead>
                                <tr>
                                    <th><input type="checkbox"></th>
                                    <th>Title</th>
                                    <th>Date Assigned</th>
                                    <th>Journal</th>
                                    <th><center>Status</center></th>
                                    <th><center>Action</center></th>
                                    
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="no-data-message" style="display: none;">
                                    <td colspan="6">No records found</td>
                                </tr>
                                <tr>
                                    <td><input type="checkbox"></td>
                                    <td>Blockchain Beyond Cryptocurrency: Transforming...</td>
                                    <td>May 31, 2015</td>
                                    <td>The Star</td>
                                    <td><center><span class="status-label pending">Pending</span></center></td>
                                    <td><center>...</center></td>
                                </tr>
                                <tr>
                                    <td><input type="checkbox"></td>
                                    <td>Industries with Distributed Ledger Technology</td>
                                    <td>October 24, 2018</td>
                                    <td>The Star</td>
                                    <td><center><span class="status-label published">Done</span></center></td>
                                    <td><center>...</center></td>
                                    
                                </tr>
                            </tbody>
                        </table>
                        <hr class="full-width">
                        <div class="pagination">
                            Showing 1 to 10 of 50 entries
                            <div class="pagination-controls">
                                <button>«</button>
                                <button>‹</button>
                                <button class="active">1</button>
                                <button>2</button>
                                <button>3</button>
                                <button>4</button>
                                <button>›</button>
                                <button>»</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>





<div class="footer" id="footer">
    <!-- footer will be display here by fetching reusable files -->
</div>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" ></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <script src="../JS/reusable-header.js"></script>
    <script src="../JS/reviewer-dashboard.js"></script>
</body>
</html>