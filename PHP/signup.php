<!DOCTYPE html>
<html lang="en">
<head>
    <?php include('./meta.php'); ?>
    <title>QCUJ | SIGN-UP</title>
    <link rel="stylesheet" href="../CSS/signup.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
</head>
<body>

<div class="header-container" id="header-container">
</div>

<nav class="navigation-menus-container"  id="navigation-menus-container">
</nav>
<div class="form-container">
<img src="../images/qcu-bg.jpg" class="image-cover">
    <!-- <div> -->
    <!-- <h2>Welcome to QCUJ</h2> -->
    <!-- <img src="../images/qcu-bg.jpg"/>
    </div> -->
    <form method="POST" id="form">
       <p class="h5 my-3" style="font-weight:bold">Create your QCUJ Account</p>
       <div class="input-field">
           <label for="email">Email:</label><span id="span1">*</span><span id="spanEmailValidation" style="display: none; color: red; font-size: 11px">Invalid email</span>
           <input type="email" class="input form-control" name="email"  id="email">
        </div>
        <!-- <div class="input-field">
            <label for="orcid">ORCID:</label> <span id="orcidVlalidation">*</span><span class="text-muted" style="font-size:12px; font-weight:bold;" id="span6">  </span><span id="spanOrcidValidation" style="display: none; color: red; font-size: 11px">Orcid invalid</span>
            <span class="d-block text-muted" style="font-size:12px">If you do not have an ORCID, <a class="text-reset" href="https://orcid.org/register">register here</a></span>
           <input type="text" class="input form-control" name="orcid"  id="orcid" placeholder="Example: xxxx-xxxx-xxxx-xxxx">
        </div> -->

       <div class="input-field ">
           <label for="fname">First Name:</label><span id="span2">*</span></span><span id="spanFnameValidation" style="display: none; color: red; font-size: 11px">First name should be at least 2 characters</span>
           <input type="text" class="input form-control" name="fname"  id="fname" >
        </div>
        <!-- <div class="input-field">
            <label for="mdname">Middle Name: (Optional)</label><span id="spanMdValidation" style="display: none; color: red; font-size: 11px">Middle name should be at least 2 characters</span>
           <input type="text" class="input form-control" name="mdname"  id="mdname" >
        </div> -->
        <div class="input-field">
            <label for="lname">Last Name:</label><span id="span4">*</span><span id="spanLnValidation" style="display: none; color: red; font-size: 11px">Last name should be at least 2 characters</span>
           <input type="text" class="input form-control" name="lname"  id="lname" >
        </div>
        <div class="input-field" style="position:relative">
          <label for="password">Password:</label><span id="span5">*</span><span id="spanPasswordValidation" style="display: none; color: red; font-size: 11px">Password should at least contain 1 Uppercase 1 Special Character and 1 Number</span>
          <input type="password" class="input form-control" name="password"  id="password" >
          <span id="show-pass" class="show-pass d-none" onclick="toggle()">
              <i class="far fa-eye" onclick="myFunction(this)"></i>
          </span>
          <div id="popover-password" class="d-none">
              <p><span id="result"></span></p>
              <div class="progress mb-2">
                  <div id="password-strength" 
                      class="progress-bar" 
                      role="progressbar" 
                      aria-valuenow="40" 
                      aria-valuemin="0" 
                      aria-valuemax="100" 
                      style="width:0%">
                  </div>
              </div>
              <ul class="list-unstyled text-muted" style="font-size:12px">
                  <li class="">
                      <span class="low-upper-case">
                          <i class="fas fa-circle" aria-hidden="true"></i>
                          &nbsp;Lowercase &amp; Uppercase
                      </span>
                  </li>
                  <li class="">
                      <span class="one-number">
                          <i class="fas fa-circle" aria-hidden="true"></i>
                          &nbsp;Number (0-9)
                      </span> 
                  </li>
                  <li class="">
                      <span class="one-special-char">
                          <i class="fas fa-circle" aria-hidden="true"></i>
                          &nbsp;Special Character (!@#$%^&*)
                      </span>
                  </li>
                  <li class="">
                      <span class="eight-character">
                          <i class="fas fa-circle" aria-hidden="true"></i>
                          &nbsp;Atleast 8 Character
                      </span>
                  </li>
              </ul>
      
          </div>


        </div>
       <div id="h-captcha-container"
            class="h-captcha"
            data-sitekey="540dedd9-f0b7-412d-a713-1c4e383ee944"
        >
        </div>
      <div class="fluid-container" id="footer-form">
 
      <button type="button" class="btn btn-outline-light btn-sm mb-4" id="privacyBtn"  data-bs-toggle="modal" data-bs-target="#exampleModal" style="border:0; color:var(--link);" >Agree to Terms & Privacy</button>
      <input type="submit" value="Register" class="btn btn-primary btn-sm" id="signUpBtn">
      <button type="button" class="btn btn-link-primary btn-sm" style="width:100%" onclick="window.location.href= '../PHP/login.php';">Already have an account? Login</button>

      </div>

      <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
          <div class="modal-content">
            <div class="modal-header">
              <h1 class="modal-title fs-5" id="exampleModalLabel"></h1>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body mt-2">
              <div class="mt-1" id="firstP">
              PRIVACY POLICY
              This privacy describe our policies and procedure on the collection, use and disclosure of your Information when you use the QCUJ.
              </div>
              <div class="mt-4" id="secondP">
              We use your personal data to provide and  improve the service. By using the service, you agree to the collection and use of information in accordance with this privacy.
              
           
              </div>
              <div class="mt-4">
              WHAT INFORMATION DO WE COLLECT?
              </div>
              <div class="mt-4" id="thirdP">
              In this Privacy Policy, your "personal information" means information that could allow you to be identified. This typically includes information such as your name, address, username, profile picture, email address, ORCID and phone number.
              </div>

            </div>
            <div class="modal-footer">
          
              <!-- <input type="checkbox" class="form-check" name="privacyPolicy" name="privacyPolicy" id="privacyPolicy" value="1" disabled> -->
              <button type="button"  class="btn btn-primary btn-sm" id="btn-agree">I Agree</button>
              <!-- <p id="privacyStatement" style="font-size: 15px">I've read and agree with the terms and privacy of the website.</p> -->
            </div>
          </div>
        </div>
      </div>
              

    </form>
</div>

<script src="https://js.hcaptcha.com/1/api.js"></script>
<script src="../JS/hcaptcha.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" ></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script src="../JS/signup.js"></script>
<script src="../JS/password.js"></script>
<script src="../JS/reusable-header.js"></script>
</body>
</html>