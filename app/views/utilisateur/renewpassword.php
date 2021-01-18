<!DOCTYPE html>
<html lang="<?= \app\core\Session::getAttribut('lang');?>">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" type="image/png" sizes="16x16" href="<?= WEBROOT;?>assets/plugins/images/logoPF.jpg">
    <title><?= $this->lang['titre3'] ?></title>
    <!-- Bootstrap Core CSS -->
    <link href="<?= ASSETS; ?>bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- animation CSS -->
    <link href="<?= ASSETS; ?>css/animate.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="<?= ASSETS; ?>css/style.css" rel="stylesheet">
    <!-- color CSS -->
    <link href="<?= ASSETS; ?>css/colors/default.css" id="theme"  rel="stylesheet">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>
<body>
<!-- Preloader -->
<div class="preloader">
    <div class="cssload-speeding-wheel"></div>
</div>
<section id="wrapper" class="login-register">
    <div class="login-box">
        <div class="white-box">
            <form class="form-horizontal form-material" action="<?php echo WEBROOT ?>utilisateur/saveNewPasswordFirst" id="formDegagementfonds" method="post">
                <a href="javascript:void(0)" class="text-center db">
                    <img src="<?php echo ASSETS ?>plugins/images/logoPF.jpg" style="width: 182px; height: 132px;"" alt="<?php echo $this->lang['accueil']; ?>" />
                </a>

                <div class="form-group m-t-40">
                    <div class="col-xs-12">
                        <input type="password" id="oldpwd" name="oldpwd" class="form-control" placeholder="<?php echo $this->lang['edit_pwd1']; ?>" style="width: 100%" required>
                        <span class="help-block with-errors" id="msg1"> </span>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-xs-12">
                        <input type="password" data-toggle="validator" data-minlength="6" readonly id="inputPassword" name="pass" class="form-control" placeholder="<?php echo $this->lang['edit_pwd2']; ?>"
                               style="width: 100%" required>
                        <span class="help-block with-errors"> </span>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-xs-12">
                        <input type="password" id="inputPasswordConfirm" data-match="#inputPassword" readonly data-match-error="Confirmation du mot de pass incorrecte" name="confirmpwd" class="form-control" placeholder="<?php echo $this->lang['edit_pwd3']; ?>"
                               style="width: 100%" required>
                        <span toggle="#password-field" class="fa fa-fw fa-eye field-icon toggle-password"></span>
                        <span id="msg2" class="help-block with-errors"> </span>
                    </div>
                </div>


                <div class="form-group text-center m-t-20">
                    <div class="col-xs-12" id="msg"></div>
                </div>
                <div class="form-group text-center m-t-20">
                    <div class="col-xs-12">
                        <button id="btnvalid" onclick="confirmPass();" class="btn btn-lg btn-primary btn-block btn-signin" style="background: #1f3b72; border: 1px solid #137648" type="button"><?php echo strtoupper($this->lang['btnValider']); ?></button>
                    </div>
                </div>
                <input type="hidden" name="id" value="<?= $rowid; ?>">

            </form>

            <div id="message">
                <h4><b><?php echo $this->lang['renew_passwordMsg'];?></b></h4>
                <p id="letter" class="invalid"><?php echo $this->lang['une'];?> <b><?php echo $this->lang['minuscule'];?></b><?php echo '('.$this->lang['lettre'].')';?> </p>
                <p id="capital" class="invalid"><?php echo $this->lang['une'];?> <b><?php echo $this->lang['majuscule'];?> </b> <?php echo '('.$this->lang['lettre'].')'?></p>
                <p id="number" class="invalid"><?php echo $this->lang['un'];?> <b><?php echo $this->lang['chiffre'];?></b></p>
                <p id="length" class="invalid"><?php echo $this->lang['minimum'];?> <b><?php echo $this->lang['caractere'];?></b></p>
            </div>

        </div>
    </div>
</section>
<!-- jQuery -->
<script src="<?= ASSETS; ?>plugins/bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap Core JavaScript -->
<script src="<?= ASSETS; ?>bootstrap/dist/js/bootstrap.min.js"></script>
<!-- Menu Plugin JavaScript -->
<script src="<?= ASSETS; ?>plugins/bower_components/sidebar-nav/dist/sidebar-nav.min.js"></script>

<!--slimscroll JavaScript -->
<script src="<?= ASSETS; ?>js/jquery.slimscroll.js"></script>
<!--Wave Effects -->
<script src="<?= ASSETS; ?>js/waves.js"></script>
<!-- Custom Theme JavaScript -->
<script src="<?= ASSETS; ?>js/custom.min.js"></script>
<!--Style Switcher -->
<script src="<?= ASSETS; ?>plugins/bower_components/styleswitcher/jQuery.style.switcher.js"></script>

<script>


    $("#inputPassword").click(function(){
        var oldpwd = $('#oldpwd').val();
        var thepass = "<?php echo $rowid ; ?>" ;

        $.ajax({
            type: "POST",
            url: "<?= WEBROOT . 'utilisateur/checkOldPassword'; ?>",
            data: "oldpwd=" + oldpwd +"&thepass=" + thepass,
            success: function (data) {
                //alert(data);
                if(data){
                    $('#inputPassword').removeAttr('readonly');
                    $('#inputPasswordConfirm').removeAttr('readonly');
                    $('#msg1').html("<p style='color:#7ACE4C;display: inline;border: 1px solid #7ACE4C'> <?php echo $this->lang['pass_alert_success']; ?></p>");
                    $("#btnConfirm").removeAttr("disabled","disabled");
                }
                else{
                    $('#msg1').html("<p style='color:#F00;display: inline;border: 1px solid #F00'> <?php echo $this->lang['pass_alert_error']; ?></p>");
                    $("#btnConfirm").attr("disabled","disabled");
                }
            }
        });
    });

    function confirmPass()
    {
        var mot_de_passe= document.getElementById('inputPassword').value;
        var mot_de_passe1= document.getElementById('inputPasswordConfirm').value;

        if(mot_de_passe == mot_de_passe1){
            $('#msg2').html("<p style='color:#7ACE4C;display: inline;border: 1px solid #7ACE4C'> <?php echo $this->lang['confirmpass_alert_success'];  ?></p>");
            $("#btnvalid").removeAttr("disabled","disabled");
            $('#formDegagementfonds').submit();
        }
        else{
            $('#msg2').html("<p style='color:#F00;display: inline;border: 1px solid #F00'> <?php echo $this->lang['confirmpass_alert_error']; ?></p>");
            $("#btnvalid").attr("disabled","disabled");
        }
    }


 var myInput = document.getElementById("inputPassword");
 var letter = document.getElementById("letter");
 var capital = document.getElementById("capital");
 var number = document.getElementById("number");
 var length = document.getElementById("length");

 // When the user clicks on the password field, show the message box
 myInput.onfocus = function() {
     document.getElementById("message").style.display = "block";
 }

 // When the user clicks outside of the password field, hide the message box
 myInput.onblur = function() {
     document.getElementById("message").style.display = "none";
 }

 // When the user starts to type something inside the password field
 myInput.onkeyup = function() {
     // Validate lowercase letters
     var lowerCaseLetters = /[a-z]/g;
     if(myInput.value.match(lowerCaseLetters)) {
         letter.classList.remove("invalid");
         letter.classList.add("valid");
         $("#btnvalid").prop("disabled",false);
     } else {
         letter.classList.remove("valid");
         letter.classList.add("invalid");
         $("#btnvalid").prop("disabled",true);
     }

     // Validate capital letters
     var upperCaseLetters = /[A-Z]/g;
     if(myInput.value.match(upperCaseLetters)) {
         capital.classList.remove("invalid");
         capital.classList.add("valid");
         $("#btnvalid").prop("disabled",false);
     } else {
         capital.classList.remove("valid");
         capital.classList.add("invalid");
         $("#btnvalid").prop("disabled",true);
     }

     // Validate numbers
     var numbers = /[0-9]/g;
     if(myInput.value.match(numbers)) {
         number.classList.remove("invalid");
         number.classList.add("valid");
         $("#btnvalid").prop("disabled",false);
     } else {
         number.classList.remove("valid");
         number.classList.add("invalid");
         $("#btnvalid").prop("disabled",true);
     }

     // Validate length
     if(myInput.value.length >= 8) {
         length.classList.remove("invalid");
         length.classList.add("valid");
         $("#btnvalid").prop("disabled",false);
     } else {
         length.classList.remove("valid");
         length.classList.add("invalid");
         $("#btnvalid").prop("disabled",true);
     }
 }

    $(".toggle-password").click(function() {

        $(this).toggleClass("fa-eye fa-eye-slash");
        var input = $($(this).attr("toggle"));
        if (input.attr("type") == "password") {
            input.attr("type", "text");
        } else {
            input.attr("type", "password");
        }
    });


</script>

</body>
</html>

<style>
    /* The message box is shown when the user clicks on the password field */
    #message {
        display:none;
        background: #f1f1f1;
        color: #000;
        position: relative;
        padding: 20px;
        margin-top: 10px;
    }
    #message p {
        padding: 5px 35px;
        font-size: 15px;
    }



    /* Add a green text color and a checkmark when the requirements are right */
    .valid {
        color: green;
    }

    .valid:before {
        position: relative;
        left: -35px;
        content: "✔";
    }

    /* Add a red text color and an "x" when the requirements are wrong */
    .invalid {
        color: red;
    }

    .invalid:before {
        position: relative;
        left: -35px;
        content: "✖";
    }

    .field-icon {
        float: right;
        margin-left: -25px;
        margin-top: -25px;
        position: relative;
        z-index: 2;
    }

</style>
