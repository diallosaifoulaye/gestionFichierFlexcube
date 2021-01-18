
<?php //echo'<pre>', var_dump($this->data["message"]);?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" type="image/png" sizes="16x16" href="<?= WEBROOT;?>assets/plugins/images/meczy.png">
    <title><?php echo $this->lang['meczy'];?></title>
    <!-- Bootstrap Core CSS -->
    <link href="<?= WEBROOT;?>assets/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- animation CSS -->
    <link href="<?= WEBROOT;?>assets/css/animate.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="<?= WEBROOT;?>assets/css/style.css" rel="stylesheet">
    <!-- color CSS -->
    <link href="<?= WEBROOT;?>assets/css/colors/blue.css" id="theme"  rel="stylesheet">

    <link href="<?= ASSETS ?>plugins/select2/select2.min.css" rel="stylesheet">

    <link href="<?= ASSETS; ?>plugins/bower_components/sweetalert/sweetalert.css" rel="stylesheet" >

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
    <div class="login-box login-sidebar">
        <div class="white-box">


<!--            --><?php //$a == 1; if ($a == '1') {  ?>
                <form class="form-horizontal form-material" id="loginform" action="<?php echo WEBROOT; ?>home/login" method="post">
                    <div class="row pull-right">
                        <select id="lang" onchange="choisirLangue()"  class="select2"  name="lang">
                            <option  value="fr">FR</option>
                            <option value="us">ENG</option>
                        </select>
                    </div>


                    <?php echo $message1 = $this->paramGET[0] ;
                    echo $message1;
                    ?>

                    <a href="javascript:void(0)" class="text-center db">
                        <img src="<?php echo ASSETS ?>plugins/images/meczy.png" alt="<?php echo $this->lang['accueil']; ?>" />
                    </a>

                    <?php if ($message) { ?>
                        <div class="form-group text-center m-t-20">
                            <div class="col-xs-12" id="msg1">
                                <label id="msg" style="color: red" ><?php echo $message;?></label>
                            </div>
                        </div>
                    <?php } ?>


                    <?php if ($message1) { ?>
                        <div class="form-group text-center m-t-20">
                            <div class="col-xs-12" id="msg1">
                                <label id="msg" class="alert-success"><?php echo $message1;?></label>
                            </div>
                        </div>
                    <?php } ?>



                    <div class="form-group m-t-40">
                        <div class="col-xs-12">
                            <input class="form-control" id="login" required name="login" type="text" placeholder="<?php echo $this->lang['labLogin'];?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-12">
                            <input class="form-control" id="password" required name="password" type="password" placeholder="<?php echo $this->lang['labpwd'];?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-12">
                            <div class="checkbox checkbox-primary pull-left p-t-0">

                            </div>
                            <a href="javascript:void(0)" id="to-recover" class="text-dark pull-right"><i class="m-r-5"></i><?php echo $this->lang['recover_password'];?> ?</a> </div>
                    </div>
                    <div class="form-group text-center m-t-20">
                        <div class="col-xs-12" id="msg"></div>
                    </div>
                    <div class="form-group text-center m-t-20">
                        <div class="col-xs-12">
                            <button  class="btn btn-lg btn-primary btn-block btn-signin" style="background: #137648; border: 1px solid #137648" type="submit" ><span id="bc"><?php echo strtoupper($this->lang['toconnect']); ?></span></button>
                        </div>
                    </div>

                </form>

                <form class="form-horizontal" id="recoverform" action="<?php echo WEBROOT; ?>home/sendEmailToAdmin" method="post">
                    <div class="form-group ">
                        <div class="col-xs-12">
                            <h3 id="mpof"><?php echo $this->lang['recover_password'];?></h3>
                            <p class="text-muted"><?php echo $this->lang['msg_email_reset'];?>! </p>
                        </div>
                    </div>
                    <div class="form-group ">
                        <div class="col-xs-12">
                            <input class="form-control" type="email"  onblur="verifeDoublon(this)" required name="email" id="email" placeholder="<?php echo $this->lang['email']; ?>">
                            <span id="msgemail"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-12">
                            <a style="color: black" href="<?php echo WEBROOT.'home/index'; ?>" class="text-white pull-left"><i class="m-r-5 "></i><span id="accueil"> Accueil</span></a>
                        </div>
                    </div>
                    <div class="form-group text-center m-t-20">
                        <div class="col-xs-12">
                            <button id="butonreset"  class="btn btn-lg btn-primary btn-block btn-signin" style="background: #137648; border: 1px solid #137648" type="submit"><span id="reset"><?php echo $this->lang['reset'];?></span></button>
                        </div>
                    </div>


                </form>

<!--            --><?php //}else{ ?>
<!--                <form class="form-horizontal" id="renewform" action="--><?php //echo WEBROOT; ?><!--home/renewpasswordUser" method="post">-->
<!--                    <div class="form-group ">-->
<!--                        <div class="col-xs-12">-->
<!--                            <h3 id="mpof">--><?php //echo $this->lang['renew_password'].' : '.$this->paramGET[0];?><!--</h3>-->
<!--                            <p class="text-muted">--><?php //echo $this->lang['msg_email_reset'];?><!--! </p>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                    <div class="form-group ">-->
<!--                        <div class="col-xs-12">-->
<!--                            <input class="form-control" type="password"  onblur="verifeDoublon(this)" required name="passwordOld" id="passwordOld" placeholder="--><?php //echo $this->lang['email']; ?><!--">-->
<!--                            <span id="msgemail"></span>-->
<!--                        </div>-->
<!--                        <div class="col-xs-12">-->
<!--                            <input class="form-control" type="password"  onblur="verifeDoublon(this)" required name="passwordOldNew" id="passwordOldNew" placeholder="--><?php //echo $this->lang['email']; ?><!--">-->
<!--                            <span id="msgemail"></span>-->
<!--                        </div>-->
<!--                        <div class="col-xs-12">-->
<!--                            <input class="form-control" type="password"  onblur="verifeDoublon(this)" required name="passwordOldConfirmed" id="passwordOldConfirmed" placeholder="--><?php //echo $this->lang['email']; ?><!--">-->
<!--                            <span id="msgemail"></span>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                    <div class="form-group">-->
<!--                        <div class="col-md-12">-->
<!--                            <a style="color: black" href="--><?php //echo WEBROOT.'home/index'; ?><!--" class="text-white pull-left"><i class="m-r-5 "></i><span id="accueil"> Accueil</span></a>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                    <div class="form-group text-center m-t-20">-->
<!--                        <div class="col-xs-12">-->
<!--                            <button id="butonreset"  class="btn btn-lg btn-primary btn-block btn-signin" style="background: #137648; border: 1px solid #137648" type="submit"><span id="reset">--><?php //echo $this->lang['reset'];?><!--</span></button>-->
<!--                        </div>-->
<!---->
<!--                    </div>-->
<!---->
<!---->
<!--                </form>-->
<!--            --><?php //} ?>
           


        </div>

        <footer class="footer text-center" style="background-color:white;color: white">`
            <a href="http://www.numherit.com/v2" target="_blank">
                <img src="<?php echo ASSETS ?>plugins/images/numherit.png" class="img-responsive" title="<?php echo $this->lang['numheritby'] ; ?>" style="height: 35px; display: block; margin-left: auto; margin-right: auto;">
            </a>
        </footer>
    </div>
</section>




<script>



    function verifeDoublon(element) {

        var nom = element.name ;
        var valeur = element.value ;
        $.ajax({
            type: 'POST',
            data:{ champ : nom, valeur:valeur },
            url: '<?php echo WEBROOT ?>home/verifie',
            success: function(data) {

                var donnees = JSON.parse(data);
                if (parseInt(donnees) == 0) {
                    $('#msg'+nom).html("<p style='color:#F00;display: inline; #F00'><?php echo $this->lang['email_inexsitant'];?></p>");
                    $("#butonreset").attr('disabled','disabled');
                }
                else {
                    $('#msg'+nom).html("");
                    $("#butonreset").removeAttr('disabled');
                }
            },
            error: function() {
                alert('La requête n\'a pas abouti'); }

        });
        //alert(name+' '+value);
    }


</script>

<!-- jQuery -->
<script src="<?= WEBROOT;?>assets/plugins/bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap Core JavaScript -->
<script src="<?= WEBROOT;?>assets/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- Menu Plugin JavaScript -->
<script src="<?= WEBROOT;?>assets/plugins/bower_components/sidebar-nav/dist/sidebar-nav.min.js"></script>

<!--slimscroll JavaScript -->
<script src="<?= WEBROOT;?>assets/js/jquery.slimscroll.js"></script>
<!--Wave Effects -->
<script src="<?= WEBROOT;?>assets/js/waves.js"></script>
<!-- Custom Theme JavaScript -->
<script src="<?= WEBROOT;?>assets/js/custom.min.js"></script>
<!--Style Switcher -->
<script src="<?= WEBROOT;?>assets/plugins/bower_components/styleswitcher/jQuery.style.switcher.js"></script>
<script src="<?= ASSETS ?>plugins/bower_components/sweetalert/sweetalert.min.js"></script>



<script>




    function connexion(){
        var login = $("#login").val();
        var password = $("#password").val();
        if(login=='' || password==''){
            $('#msg').html('Veuillez renseigner les champs login et mot de passe SVP');
            $('#msg').slideDown('slow');
            $('#msg').delay(3000).fadeOut('slow');
        }
        else{
            $( "#loginform" ).submit();
        }
    }

    function choisirLangue() {
        var lang = $("#lang").val();
        if (lang == 'us'){
            $("#login").attr("placeholder", "Login");
            $("#password").attr("placeholder", "Password");
            $("#to-recover").html('Forgot your password ?');
            $("#bc").html("SIGN UP");
            $("#mpof").html("Forgot your password");
            $("#accueil").html("Home");
            $("#reset").html("Reset");
        }else{
            $("#login").attr("placeholder", "<?php echo $this->lang['labLogin'];?>");
            $("#password").attr("placeholder", "<?php echo $this->lang['labpwd'];?>");
            $("#to-recover").html("<?php echo $this->lang['recover_password'];?>");
            $("#bc").html("<?php echo strtoupper($this->lang['toconnect']); ?>");
            $("#mpof").html("<?php echo $this->lang['recover_password'];?>");
            $("#accueil").html("Accueil");
            $("#reset").html("<?php echo $this->lang['reset'];?>");
        }
        //alert(lang);

    }

    (function () {
        $("#butonreset").prop('disabled', true);
    })();



</script>

<script src="<?= ASSETS ?>plugins/select2/select2.full.min.js"></script>
<script>
    $(".select2").select2();
</script>





</body>
</html>
