<?php
session_start();
if(isset($_SESSION["logged"]) and $_SESSION["logged"]){ 
  header("Location: ../../pages/QuantityCalculator/index.php");
  die();
}
// include_once("..\admin\session\logged.php");
include_once("..\admin\database\conn.php");
include_once("..\admin\Requests\Validation.php");
include_once __DIR__."\..\admin\models\User.php";
include_once __DIR__."\..\admin\images\Image.php";
include_once __DIR__."\..\admin\models\login.php";

if($_SERVER["REQUEST_METHOD"] === "POST" ){
    if(isset($_POST["regForm"])){
        $dbConnection= new Conn();
        $firstname=$_POST['firstname'];
        $lastname=$_POST['lastname'];
        $email = $_POST["email"];
        $password=$_POST["password"];
        $whatsapp_number = $_POST["whatsapp_number"];
        $job = $_POST["job"];
        $job_other = $_POST["job_other"];
        $country = $_POST["country"];
        $city = $_POST["city"];
        $job_role = $_POST["job_role"];
        $job_role_other = $_POST["job_role_other"];
        $company = $_POST["company"];
        $image = $_FILES['company_logo']?? null ;

        // FIRSTNAME VALIDATION 
        $firstnameValidation= new Validation("firstname", $firstname);
        $firstnameResult=$firstnameValidation->required(); 
        $firstnamePattern='/^[a-zA-Z]{3,15}$/';
        if($firstnameResult){
            $firstnameValidation->regex($firstnamePattern);
        }
        if($firstnameValidation->hasErrors()){
            $fnameErrors=$firstnameValidation->getErrors();
        }

        // LASTNAME VALIDATION
        $lastnameValidation= new Validation("lastname", $lastname);
        $lastnameResult=$lastnameValidation->required(); 
        $lastnamePattern='/^[a-zA-Z]{3,15}$/';
        if($lastnameResult){
            $lastnameValidation->regex($lastnamePattern);
        }
        if($lastnameValidation->hasErrors()){
            $lnameErrors=$lastnameValidation->getErrors();
        }

        // EMAIL VALIDATION
        $emailValidation= new Validation("email", $email);
        $emailResult=$emailValidation->required(); 
        $emailPattern='/^[A-Za-z0-9](([_\.\-]?[a-zA-Z0-9]+))@([A-Za-z0-9]+)(([\.\-]?[a-zA-Z0-9]+))\.([A-Za-z]{2,})$/';
        if($emailResult)
        {
            $emailPatternResult=$emailValidation->regex($emailPattern);
            if( $emailPatternResult)
            {
                $emailValidation->unique("users");
            } 
        }
        if($emailValidation->hasErrors()){
            $emailErrors=$emailValidation->getErrors();
        } 

        // PASSWORD VALIDATION
        $passwordValidation = new Validation("password",$password );
        $passwordResult = $passwordValidation->required();
        $passwordPattern ='/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,12}$/';  // Minimum eight and maximum 12 characters, at least one uppercase letter, one lowercase letter, one number and one special character 
        if($passwordResult ){
            $passwordValidation->regex($passwordPattern);
        }
        if($passwordValidation->hasErrors()){
            $passwordErrors=$passwordValidation->getErrors();
        }

        // WHATSAPP VALIDATION
        $whatsappNumberValidation= new Validation("whatsapp_number", $whatsapp_number);
        $whatsappNumberResult = $whatsappNumberValidation->required();
        $whatsappNumberPattern = '/^01[0-2,5]\d{8}$/'; 
        if($whatsappNumberResult)
        {
            $whatsappNumberPatternResult = $whatsappNumberValidation->regex($whatsappNumberPattern);
            if($whatsappNumberPatternResult)
            {
                $whatsappNumberValidation->unique("users");
            } 
        }
        if($whatsappNumberValidation->hasErrors()){
            $whatsappNumberErrors=$whatsappNumberValidation->getErrors();
        } 

        // JOB VALIDATION
        $jobValidation= new Validation("job", $job);
        $jobResult=$jobValidation->required();
        if($jobValidation->hasErrors())
        {
            $jobErrors=$jobValidation->getErrors();
        }

        // JOB-OTHER VALIDATION
        if(isset($job_other )){
        $jobOtherValidation= new Validation("job_other", $job_other);
        $jobOtherResult=$jobOtherValidation->required();
            if($jobOtherValidation->hasErrors())
            {
                $jobOtherErrors=$jobOtherValidation->getErrors();
            }
        }

        // IMAGE VALIDATION 
        $imageValidationErrors = [];
        if ($image) {
            // var_dump($image);
            $newImage = new Image($image['name'], $image['tmp_name'],$image['size']); // Create Image object (optional)
            if (!$newImage->validate()) {
                $imageValidationErrors = $newImage->getErrors();
            }
        }

        // TO INSERT DATA FORM AT DATABASE
        if(empty($fnameErrors) && empty($lnameErrors) && empty($emailErrors) && empty($passwordErrors) && empty($whatsappNumberErrors) && empty($jobErrors) && empty($jobOtherErrors) && empty($imageValidationErrors))
        {
            $user=new User();
            $user->setFirstname($firstname);
            $user->setLastname($lastname);
            $user->setEmail($email);
            $user->setWhatsapp_number($whatsapp_number);
            $user->setPassword($password);
            $user->setJob($job);
            $user->setJob_other($job_other);
            $user->setCountry($country);
            $user->setCity($city);
            $user->setJob_role($job_role);
            $user->setJob_role_other($job_role_other);
            $user->setCompany($company);
            $user->setCompany_logo($image);
            $result=$user->create();
            if($result)
            {
                echo "inserted";
            }
            else
            {
                echo " not inserted ";
            }
        }
    }elseif(isset($_POST["logForm"])) {
        $email = $_POST["email"];
        $pass = $_POST["password"];
        $userLogin = new Login($email, $pass);
        $userLogin->setLogin();
        $errors = $userLogin->getErrors();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="../../../assets/images/favicon-32x32.png">
    <link rel="stylesheet" href="../../css/main.css">
    <title>Login/ Sign up</title>
</head>
<body>
    <div class="container-fluid">
        <header class="d-flex justify-content-between align-items-center">
        <div class="logo img-fluid px-2">
            <img src="../../../assets/images/green_tree-150-01-removebg-preview.png" alt="">
        </div>
        <div class="header-btn p-3">
            <button class="btn btn-secondary me-md-2 px-4 bg-primary" type="button">
                <a class="text-white text-decoration-none" href="../../../index.php">Home</a>
            </button>
        </div>
        </header>
        
        <div class="container">
            <!-- LOGIN/ SIGNUP BUTTONS -->
            <div class="login-sinup-btns mb-5">
                <ul class="nav nav-underline d-flex justify-content-center pt-5">
                    <div class="btn-wrapper">
                        <li class="nav-item login-btn display-6 mx-4 border-bottom">
                            <a class="nav-link" aria-current="page" href="">Login</a>
                        </li>
                    </div>
                    <div class="btn-wrapper">
                        <li class="nav-item signup-btn display-6 mx-4 border-bottom">
                            <a class="nav-link" href="">Sign up</a>
                        </li>
                    </div>
                    </ul>
            </div>
            <!-- LOGIN -->
            <form class="login-form mb-3 form" action="" method="POST">
                <div class="mb-4 input-parent">
                    <?php
                        if (isset($errors) ) {      
                            foreach($errors as $error){
                                echo "<p class='alert alert-danger mt-1'>$error</p>";
                            }
                        }
                    ?>
                    <input type="email" name="email" class="form-control" id="login-form-username" aria-describedby="emailHelp" placeholder="Email*" >
                    <div class="error"></div>
                    <div class="success"></div>
                </div>
                <div class="mb-4 input-parent">
                    <input type="password" name="password" class="form-control" id="login-form-password" placeholder="Password*" >
                    <div class="error"></div>
                    <div class="success"></div>
                </div>
                <input type="submit" name="logForm"  class="btn btn-primary mb-4 text-white" value="Login"/>
                <p class="signup-link">Don't have an account? <a class="text-decoration-none" href="">Sign up</a></p>
            </form>

            <!-- SIGN UP -->
            <form class="signup-form  mb-3 form"  action=<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>  method="POST" enctype="multipart/form-data" >
                <h4 class="signup-title mb-4 text-primary">Register to get free access</h4>  
                <div class="row username-row">    
                    <div class="col-lg-6 col-md-6 col-sm-12 firstname-row input-parent mb-4">
                        <input type="text" name="firstname" value="<?php if(isset($_POST['firstname'])){echo $_POST['firstname'] ;} ?>" class="form-control" id="signup-firstname" aria-label="firstname" placeholder="First Name" > <!-- pattern="([a-zA-Z].*?){3}" required -->
                        <div class="error"></div>
                        <div class="success"></div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12 lastname-row input-parent mb-4">
                    <input type="text" name="lastname" value="<?php if(isset($_POST['lastname'])) {echo $_POST['lastname'] ;} ?>" class="form-control" id="signup-lastname" aria-label="lastname" placeholder="Last Name">
                    <div class="error"></div>
                    <div class="success"></div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12" >
                <?php 
                    if(isset($fnameErrors))
                    {
                        foreach($fnameErrors as $error)
                        {
                            echo "<p class='alert alert-danger mt-1'>$error</p> ";
                        }
                    }
                ?>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12">
                <?php 
                    if(isset($lnameErrors))
                    {
                        foreach($lnameErrors as $error)
                        {
                            echo "<p class='alert alert-danger mt-1'>$error</p> ";
                        }
                    }
                ?>
                </div>
                <div class="mb-4 input-parent">
                <input type="email" name="email" value="<?php if(isset($_POST['email'])){echo $_POST['email'] ;} ?>" class="form-control" id="signup-email" aria-describedby="emailHelp" placeholder="Email*" >
                <div class="error"></div>
                <div class="success"></div>
                <?php 
                    if(isset($emailErrors))
                    {
                        foreach($emailErrors as $error)
                        {
                            echo "<p class='alert alert-danger mt-1'>$error</p> ";
                        }
                    }
                ?>  
                </div>
                <div class="mb-4 input-parent">
                <input type="tel" name="whatsapp_number" value="<?php if(isset($_POST['whatsapp_number'])){echo $_POST['whatsapp_number'] ;} ?>" class="form-control" id="signup-number" placeholder="WhatsApp number* ex.(01022644578)" >
                <div class="error"></div>
                <div class="success"></div>
                <?php 
                    if(isset($whatsappNumberErrors))
                    {
                        foreach($whatsappNumberErrors as $error)
                        {
                            echo "<p class='alert alert-danger mt-1'>$error</p> ";
                        }
                    }
                ?>      
                </div>
                <div class="mb-4 input-parent">
                <input type="password" name="password" value="<?php if(isset($_POST['password'])){echo $_POST['password'] ;} ?>" class="form-control" id="signup-password"  placeholder="Password*" minlength="8" >
                <div class="error"></div>
                <div class="success"></div>
                <?php 
                    if(isset($passwordErrors))
                    {
                        foreach($passwordErrors as $error)
                        {
                            echo "<p class='alert alert-danger mt-1'>$error</p> ";
                        }
                    }
                ?>  
                </div>
                <div class="input-group">
                <select class="form-select job-function input-parent mb-4" name="job" onchange="otherOptionFunction()" aria-label="job function dropdown" >
                    <option selected  readonly  >What's your job function?</option>
                    <option  <?=(isset($_POST['job'] )&& $_POST['job']=='Doctor')? 'selected': '' ?>  value="Doctor">Doctor</option>
                    <option  <?=(isset($_POST['job'] )&& $_POST['job']=='Pharmacist')? 'selected': '' ?> value="Pharmacist">Pharmacist</option>
                    <option  <?=(isset($_POST['job'] )&& $_POST['job']=='Nurse')? 'selected': '' ?>  value="Pharmacist">Nurse</option>
                    <option  <?=(isset($_POST['job'] )&& $_POST['job']=='Other')? 'selected': '' ?> class="other-option-function" value="Other">Other</option>
                </select>
                <?php 
                    if(isset($jobErrors))
                    {
                        foreach($jobErrors as $error)
                        {
                            echo "<p class='alert alert-danger mt-1'>$error</p> ";
                        }
                    }
                ?>  
                </div>
                <div class="other-input-function input-parent mb-4">
                    <input type="text" value="<?php if(isset($_POST['job_other'])){echo $_POST['job_other'] ;} ?>"  name="job_other"  class="form-control col-12" id="job-function" placeholder="Other (Please Specify)">
                    <?php 
                    if(isset($jobOtherErrors))
                    {
                        foreach($jobOtherErrors as $error)
                        {
                            echo "<p class='alert alert-danger mt-1'>$error</p> ";
                        }
                    }
                    ?>
                </div>
                <div class="row country-row mb-4">
                    <div class="col-lg-6 col-md-6 col-sm-12 input-parent">
                        <select class="form-select form-control country" id="country" name="country" aria-label="country dropdown">
                            <option selected>Country*</option>
                        </select>
                        <div class="error"></div>
                        <div class="success"></div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12">
                        <input type="text" class="form-control" id="city" name="city" value="<?php if(isset($_POST['city'])){echo $_POST['city'] ;} ?>"  placeholder="City" aria-label="city">
                    </div>
                </div>
                <select class="form-select job-role input-parent mb-4" name="job_role" onchange="otherOptionFunction()" aria-label="job role dropdown">
                    <option selected>What's your job role?</option>
                    <option <?=(isset($_POST['job_role'] )&& $_POST['job_role']=='Supply Chain')? 'selected': '' ?> value="Supply Chain">Supply Chain</option>
                    <option <?=(isset($_POST['job_role'] )&& $_POST['job_role']=='Clinical Protocol')? 'selected': '' ?> value="Clinical Protocol">Clinical Protocol</option>
                    <option <?=(isset($_POST['job_role'] )&& $_POST['job_role']=='Policy Maker')? 'selected': '' ?> value="Policy Maker">Policy Maker</option>
                    <option <?=(isset($_POST['job_role'] )&& $_POST['job_role']=='Health Economist')? 'selected': '' ?> value="Health Economist">Health Economist</option>
                    <option <?=(isset($_POST['job_role'] )&& $_POST['job_role']=='Clinician')? 'selected': '' ?> value="Clinician">Clinician</option>
                    <option <?=(isset($_POST['job_role'] )&& $_POST['job_role']=='Inventory management')? 'selected': '' ?> value="Inventory management">Inventory management</option>
                    <option <?=(isset($_POST['job_role'] )&& $_POST['job_role']=='Clinical Pharmacist')? 'selected': '' ?> value="Clinical Pharmacist">Clinical Pharmacist</option>
                    <option <?=(isset($_POST['job_role'] )&& $_POST['job_role']=='Procurement')? 'selected': '' ?> value="Procurement">Procurement</option>
                    <option <?=(isset($_POST['job_role'] )&& $_POST['job_role']=='Insurer')? 'selected': '' ?> value="Insurer">Insurer</option>
                    <option <?=(isset($_POST['job_role'] )&& $_POST['job_role']=='Budgeting/Cost control')? 'selected': '' ?> value="Budgeting/Cost control">Budgeting/Cost control</option>
                    <option <?=(isset($_POST['job_role'] )&& $_POST['job_role']=='Other')? 'selected': '' ?> class="other-option-role" value="Other">Other</option>
                </select>
                <div class="other-input-role mb-4">
                    <input type="text" name="job_role_other" value="<?php if(isset($_POST['job_role_other'])){echo $_POST['job_role_other'] ;} ?>"  class="form-control" id="job-role" placeholder="Other (Please Specify)">
                </div>
                <div class="mb-4 input-parent">
                    <input type="text" class="form-control" id="signup-company" name="company" value="<?php if(isset($_POST['company'])){echo $_POST['company'] ;} ?>" placeholder="Your company*" >
                    <div class="error"></div>
                    <div class="success"></div>
                </div>
                <div class="mb-4 input-parent">
                    <input class="form-control"  type="file" name="company_logo" id="formFile" placeholder="Upload your company's logo">
                <?php
                if (!empty($imageValidationErrors) ) {      
                    foreach($imageValidationErrors as $error)
                    {
                        echo "<p class='alert alert-danger mt-1'>$error</p> ";
                    }
                }
                ?>
                </div>
                <div class="d-grid gap-2 mb-4"> 
                    <input class="btn btn-primary text-white" name="regForm" id="signup-submit" type="submit" value="Get free access"/>
                </div>
                <div class="accept mb-4 p-2">
                    <p>By creating an account, you agree to our <a href="">Terms of service</a> and <a href="">Privacy policy</a></p>
                </div>
            </form>
        </div>
    </div>
    
    <script src="../../../node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="./main.js"></script>
</body>
</html>