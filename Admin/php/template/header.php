<?php
include 'function/submission_functions.php';

$journal = get_journal_list();
// $notication = get_notification_count();
?>
<!DOCTYPE html>

<html lang="en" class="light-style layout-menu-fixed layout-compact" dir="ltr" data-theme="theme-default" data-assets-path="../assets/" data-template="vertical-menu-template-free">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
  <title>ADMIN | Pahina</title>

  <!-- <meta name="description" content="" /> -->

  <!-- Favicon -->
  <link rel="icon" type="image/png" href="../assets/img/pahina.png">
  
  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="../assets/vendor/fonts/boxicons.css" />

  <!-- Core CSS -->
  <link rel="stylesheet" href="../assets/css/new.css" />
  <link rel="stylesheet" href="../assets/vendor/css/core.css" class="template-customizer-core-css" />
  <link rel="stylesheet" href="../assets/vendor/css/theme-default.css" class="template-customizer-theme-css" />
  <link rel="stylesheet" href="../assets/css/demo.css" />

  <!-- Vendors CSS -->
  <link rel="stylesheet" href="../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />
  <link rel="stylesheet" href="../assets/vendor/libs/apex-charts/apex-charts.css" />

  <!-- DataTables CSS -->
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">

  <!-- jQuery -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  
  <!-- Quill CSS -->
  <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">

  <!-- Quill JavaScript -->
  <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>

  <!-- Helpers -->
  <script src="../assets/vendor/js/helpers.js"></script>
  <script src="../assets/js/config.js"></script>
  <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>

</head>
<style>
#text{
  color: white;
}
</style>
<body>
  <!-- Layout wrapper -->
  <div class="layout-wrapper layout-content-navbar">
    <div class="layout-container">
      <!-- Menu -->

      <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme" style="background-color: #004e98 !important">
        <div class="app-brand demo">
          <a href="dashboard.php" class="app-brand-link">
            <span class="app-brand-logo demo">
              <img src="../assets/img/qculogo.png" alt="QCULogo" class="w-100" />
            </span>
            <span class="app-brand-text demo menu-text fw-bold ms-2">Pahina Journal</span>
          </a>

          <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
            <i class="bx bx-chevron-left bx-sm align-middle"></i>
          </a>
        </div>

        <div class="menu-inner-shadow"></div>
        <ul class="menu-inner py-1">
          <li class="menu-header small text-uppercase" id="text"><span class="menu-header-text" id="text">Main</span></li>
          <!-- Dashboards -->
          <?php
          if (isset($_SESSION['LOGGED_IN']) && $_SESSION['LOGGED_IN'] === true) {
            $journal_id = isset($_SESSION['journal_id']) ? ($_SESSION['journal_id']) : '';

            if (empty($journal_id) && $journal_id !== NULL) {
          ?>

            <li class="menu-item">
              <a href="dashboard.php" class="menu-link">
                <i class="menu-icon tf-icons bx bxs-dashboard"></i>
                <div data-i18n="Boxicons" id="text">Dashboard</div>
              </a>
            </li>

          <?php
            }
          }
          ?>

          <?php
          if (isset($_SESSION['LOGGED_IN']) && $_SESSION['LOGGED_IN'] === true) {
            $journal_id = isset($_SESSION['journal_id']) ? ($_SESSION['journal_id']) : '';

            if (!empty($journal_id)) {
          ?>
          <li class="menu-item">
            <a href="editordashboard.php" class="menu-link">
              <i class="menu-icon tf-icons bx bxs-dashboard"></i>
              <div data-i18n="Boxicons" id="text">Dashboard</div>
            </a>
          </li>

          <?php
            }
          }
          ?>

          <li class="menu-item">
            <a href="journalview.php" class="menu-link <?php if (basename($_SERVER['PHP_SELF']) == 'allsubmissionlist.php') echo 'active'; ?>">
              <i class="menu-icon tf-icons bx bx-windows"></i>
              <div data-i18n="Boxicons" id="text">Submission</div>
            </a>
          </li>

          <li class="menu-header small text-uppercase" id="text"><span class="menu-header-text" id="text">Secondary</span></li>
          
          <?php
          if (isset($_SESSION['LOGGED_IN']) && $_SESSION['LOGGED_IN'] === true) {
            $journal_id = isset($_SESSION['journal_id']) ? ($_SESSION['journal_id']) : '';

            if (empty($journal_id) && $journal_id !== NULL) {
          ?>
              <li class="menu-item">
                <a href="announcementlist.php" class="menu-link">
                  <i class="menu-icon tf-icons bx bx-microphone"></i>
                  <div data-i18n="Boxicons" id="text">Announcement</div>
                </a>
              </li>

              <?php
            }
          }
          ?>
              <li class="menu-item">
                <a href="issuelist.php" class="menu-link">
                  <i class="menu-icon tf-icons bx bx-list-plus"></i>
                  <div data-i18n="Boxicons" id="text">Issue</div>
                </a>
              </li>

              <?php
              if (isset($_SESSION['LOGGED_IN']) && $_SESSION['LOGGED_IN'] === true) {
                $journal_id = isset($_SESSION['journal_id']) ? ($_SESSION['journal_id']) : '';

                if (empty($journal_id) && $journal_id !== NULL) {
              ?>

              <li class="menu-item">
                <a href="faqslist.php" class="menu-link">
                  <i class="menu-icon tf-icons bx bx-message-check"></i>
                  <div data-i18n="Boxicons" id="text">FAQS</div>
                </a>
              </li>

              <li class="menu-item">
                <a href="message.php" class="menu-link">
                  <i class="menu-icon tf-icons bx bxs-message-alt-check"></i>
                  <div data-i18n="Boxicons" id="text">Message</div>
                </a>
              </li>


          <?php
            }
          }
          ?>

          <!-- Forms & Tables -->
          <li class="menu-header small text-uppercase" id="text"><span class="menu-header-text" id="text">Settings</span></li>
          <!-- Tables -->
          <li class="menu-item">
            <a href="journallist.php" class="menu-link">
              <i class="menu-icon tf-icons bx bxs-detail"></i>
              <div data-i18n="Tables" id="text">Journal</div>
            </a>
          </li>

          <?php
          if (isset($_SESSION['LOGGED_IN']) && $_SESSION['LOGGED_IN'] === true) {
            $journal_id = isset($_SESSION['journal_id']) ? ($_SESSION['journal_id']) : '';

            if (empty($journal_id) && $journal_id !== NULL) {
          ?>

              <li class="menu-item">
                <a href="userandroleslist.php" class="menu-link">
                  <i class="menu-icon tf-icons bx bx-user-circle"></i>
                  <div data-i18n="Tables" id="text">User & Roles</div>
                </a>
              </li>

              <li class="menu-item">
                <a href="questionnaire.php" class="menu-link">
                  <i class="menu-icon tf-icons bx bx-list-minus"></i>
                  <div data-i18n="Tables" id="text">Questionnaire</div>
                </a>
              </li>

              <?php
            }
          }
          ?>
              <!-- Reports -->
              <li class="menu-header small text-uppercase" id="text"><span class="menu-header-text" id="text">OTHERS</span></li>
              <!-- Tables -->
              <li class="menu-item">
                <a href="reportlist.php" class="menu-link">
                  <i class="menu-icon tf-icons bx bxs-report"></i>
                  <div data-i18n="Tables" id="text">Reports</div>
                </a>
              </li>

            <?php
            if (isset($_SESSION['LOGGED_IN']) && $_SESSION['LOGGED_IN'] === true) {
              $journal_id = isset($_SESSION['journal_id']) ? ($_SESSION['journal_id']) : '';
                if (empty($journal_id) && $journal_id !== NULL) {
              ?>
                  <li class="menu-item">
                    <a href="archivelist.php" class="menu-link">
                      <i class="menu-icon tf-icons bx bxs-archive"></i>
                      <div data-i18n="Tables" id="text">Archived</div>
                    </a>
                  </li>
            <?php
                }
              }
            ?>

          <!-- Misc -->
          <!-- <li class="menu-header small text-uppercase"><span class="menu-header-text">Misc</span></li>
            <li class="menu-item">
              <a
                href="https://github.com/themeselection/sneat-html-admin-template-free/issues"
                target="_blank"
                class="menu-link">
                <i class="menu-icon tf-icons bx bx-support"></i>
                <div data-i18n="Support">Support</div>
              </a>
            </li>
            <li class="menu-item">
              <a
                href="https://demos.themeselection.com/sneat-bootstrap-html-admin-template/documentation/"
                target="_blank"
                class="menu-link">
                <i class="menu-icon tf-icons bx bx-file"></i>
                <div data-i18n="Documentation">Documentation</div>
              </a>
            </li> -->
        </ul>
      </aside>
      <script>
        // Get the current URL
        var currentUrl = window.location.href;

        // Get all menu links
        var menuLinks = document.querySelectorAll('.menu-link');

        // Loop through each menu link
        menuLinks.forEach(function(link) {
          // Check if the link's href matches the current URL or is a parent of the current URL
          if (currentUrl.startsWith(link.href) || currentUrl === link.href) {
            // Add the "active" class to the parent <li> element
            link.parentNode.classList.add('active');
          }
        });
      </script>
      <!-- / Menu -->
      <!-- Layout container -->
      <div class="layout-page">
        <!-- Navbar -->

        <nav class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme" id="layout-navbar">
          <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
            <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
              <i class="bx bx-menu bx-sm" style="color: black;"></i>
            </a>
          </div>

          <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
            <!-- Search -->
            <!-- <div class="navbar-nav align-items-center">
                <div class="nav-item d-flex align-items-center">
                  <i class="bx bx-search fs-4 lh-0"></i>
                  <input
                    type="text"
                    class="form-control border-0 shadow-none ps-1 ps-sm-2"
                    placeholder="Search..."
                    aria-label="Search..." />
                </div>
              </div> -->
            <!-- /Search -->

            <ul class="navbar-nav flex-row align-items-center ms-auto">
              <li class="nav-item navbar-dropdown dropdown-user dropdown">
                  <a class="bell-icon" href="#" data-toggle="tooltip" data-placement="bottom" href="javascript:void(0);" data-bs-toggle="dropdown" title="Notification" aria-label="Notification" style="position: relative; margin-right: 10px;">
                      <i class="menu-icon tf-icons bx bx-bell" style="position: relative; color: black;"></i>
                      <span id="notification-count" class="badge bg-danger rounded-circle" style="position: absolute; top: -8px; right: -2px;"></span>
                  </a>
                  <ul id="notification-list" class="dropdown-menu dropdown-menu-end">
                  </ul>
              </li>

              <!-- User -->
              <li class="nav-item navbar-dropdown dropdown-user dropdown">
                <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
                <?php
                  if (isset($_SESSION['LOGGED_IN']) && $_SESSION['LOGGED_IN'] === true) { 
                      $profile_pic = isset($_SESSION['profile_pic']) ? $_SESSION['profile_pic'] : '';
                      if (!empty($profile_pic)) {
                          echo '<div class="avatar avatar-online">
                                    <img src="../' . $profile_pic . '" alt="" class="w-40 h-40 object-fit-cover rounded-circle" />
                                </div>';
                      } else {
                          echo '<div class="avatar avatar-online">
                                    <img src="../assets/img/profile.jpg" alt="" class="w-40 h-40 object-fit-cover rounded-circle" />
                                </div>';
                      }
                  }
                  ?>
                </a>
                <ul class="dropdown-menu dropdown-menu-end">
                  <li>
                    <a class="dropdown-item" href="#">
                      <div class="d-flex">
                        <div class="flex-shrink-0 me-3">
                        <?php
                          if (isset($_SESSION['LOGGED_IN']) && $_SESSION['LOGGED_IN'] === true) { 
                              $profile_pic = isset($_SESSION['profile_pic']) ? $_SESSION['profile_pic'] : '';
                              if (!empty($profile_pic)) {
                                  echo '<div class="avatar avatar-online">
                                            <img src="../' . $profile_pic . '" alt="" class="w-40 h-40 object-fit-cover rounded-circle" />
                                        </div>';
                              } else {
                                  echo '<div class="avatar avatar-online">
                                            <img src="../assets/img/profile.jpg" alt="" class="w-40 h-40 object-fit-cover rounded-circle" />
                                        </div>';
                              }
                          }
                          ?>
                        </div>
                        <div class="flex-grow-1">
                          <?php
                          if (isset($_SESSION['LOGGED_IN']) && $_SESSION['LOGGED_IN'] === true) {
                            $firstName = isset($_SESSION['first_name']) ? ucfirst($_SESSION['first_name']) : '';
                            $middleName = isset($_SESSION['middle_name']) ? ' ' . ucfirst($_SESSION['middle_name']) : '';
                            $lastName = isset($_SESSION['last_name']) ? ' ' . ucfirst($_SESSION['last_name']) : '';

                            echo '<span class="fw-medium d-block">' . $firstName . $middleName . $lastName . '</span>';
                          }
                          ?>
                          <small class="text-muted">Admin</small>
                        </div>
                      </div>
                    </a>
                  </li>
                  <li>
                    <div class="dropdown-divider"></div>
                  </li>
                  <li>
                    <a class="dropdown-item" href="../../PHP/author-dashboard.php">
                      <i class="bx bx-user me-2"></i>
                      <span class="align-middle">User Dashboard</span>
                    </a>
                  </li>
                  <li>
                    <div class="dropdown-divider"></div>
                  </li>
                  <li>
                    <a class="dropdown-item" href="../../PHP/logout.php">
                      <i class="bx bx-power-off me-2"></i>
                      <span class="align-middle">Log Out</span>
                    </a>
                  </li>
                </ul>
              </li>
            </ul>
          </div>
        </nav>
<script>
var pusher = new Pusher('cabcad916f55a998eaf5', {
  cluster: 'ap1'
});
var channel = pusher.subscribe('my-channel');

channel.bind('my-event', function(data) {
    var notificationSound = new Audio('../../Files/notificationsound/notification.mp3');
    notificationSound.play();

    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                var newData = JSON.parse(xhr.responseText);
                updateNotifications(newData);
            } else {
                console.error('Failed to fetch notification data:', xhr.statusText);
            }
        }
    };
    xhr.open('GET', 'function/get_notification_count.php', true);
    xhr.send();
});

function updateNotifications(data) {
    document.getElementById('notification-count').textContent = data.count;

    var notificationList = document.getElementById('notification-list');
    notificationList.innerHTML = '';

    var headerItem = document.createElement('li');
    headerItem.innerHTML = `
        <a class="dropdown-item">Notification</a>
    `;
    notificationList.appendChild(headerItem);

    if (data.data && data.data.length) {
        data.data.slice(0, 5).forEach(notification => {
            var listItem = document.createElement('li');

            var chunks = [];
            for (var i = 0; i < notification.description.length; i += 50) {
                chunks.push(notification.description.substr(i, 50));
            }
            var formattedDescription = chunks.join('<br>');
            var notificationTime = new Date(notification.created);

            var currentTime = new Date();
            var options = {
              timeZone: 'Asia/Manila',
              hour12: false
            };
            var currentTimeManila = currentTime.toLocaleString('en-US', options);

            var timeDifference = Math.abs(currentTime - notificationTime);
            var timeAgo;

            if (timeDifference < 60000) {
                timeAgo = Math.floor(timeDifference / 1000) + ' seconds ago';
            } else if (timeDifference < 3600000) {
                timeAgo = Math.floor(timeDifference / 60000) + ' minutes ago';
            } else if (timeDifference < 86400000) {
                timeAgo = Math.floor(timeDifference / 3600000) + (Math.floor(timeDifference / 3600000) === 1 ? ' hour ago' : ' hours ago');
            } else {
                timeAgo = Math.floor(timeDifference / 86400000) + (timeDifference < 172800000 ? ' day ago' : ' days ago');
            }

            var article_id = notification.article_id;
            var id = notification.id;
            var currentMonth = '<?php echo date('n'); ?>';
            var currentYear = '<?php echo date('Y'); ?>';

            var donationHref = "donationreportmtd.php?m=" + currentMonth + "&y=" + currentYear;
            var articleHref = "workflow.php?aid=" + article_id;

            listItem.innerHTML = `
                <li style="background-color: ${notification.read == 1 ? '#d9dee3 !important' : 'white !important'};">
                    <a href="${notification.title === 'Send Donation' ? donationHref : articleHref}" class="dropdown-item notification-link">
                        <div class="d-flex">
                            <div class="flex-grow-1">
                                <span class="align-middle"><b>${notification.title}</b></span>
                                <br>
                                <span class="notification-description" style="word-wrap: break-word; max-width: 100%;">${formattedDescription}</span>
                                <br>
                                <span class="align-middle">${timeAgo}</span>
                            </div>
                        </div>
                    </a>
                </li>
                <div class="dropdown-divider" style="background-color: #d9dee3 !important;"></div>
            `;

            notificationList.appendChild(listItem);

            // Event listener for notification link click
            var notificationLink = listItem.querySelector('.notification-link');
            notificationLink.addEventListener('click', function(event) {
                event.preventDefault();
                var href = notificationLink.href;
                window.location.href = href;
            });

            // Event listener for notification row click
            listItem.addEventListener('click', function() {
                $.ajax({
                    type: 'POST',
                    url: 'function/update_notification.php',
                    data: { id: id },
                    dataType: 'json',
                    success: function(response) {
                        if (response.status) {
                            console.log(response.message);
                            // Optionally update UI to reflect status change
                        } else {
                            console.error(response.message);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('AJAX error: ' + status + ' - ' + error);
                    }
                });
            });
        });

        if (data.data.length > 5) {
            var seeAllItem = document.createElement('li');
            seeAllItem.innerHTML = `
                <a class="dropdown-item text-center" href="notification.php">See All</a>
            `;
            notificationList.appendChild(seeAllItem);
        }
    } else {
        console.error('No notification data available or data is invalid.');
    }
}

window.addEventListener('load', function() {
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                var data = JSON.parse(xhr.responseText);
                updateNotifications(data);
            } else {
                console.error('Failed to fetch notification data:', xhr.statusText);
            }
        }
    };
    xhr.open('GET', 'function/get_notification_count.php', true);
    xhr.send();
});

</script>