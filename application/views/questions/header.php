<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Praxis Survey</title>

    <!-- Bootstrap -->
    <link href="<?=base_url()?>/assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?=base_url()?>/assets/css/toastr.css" rel="stylesheet" />
    <link href="<?=base_url()?>/assets/css/mobirise/style.css" rel="stylesheet" />
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>

    <![endif]-->

    <!--STYLESHEET-->
    <link href="<?=base_url()?>/assets/css/questions.css?<?php echo time(); ?>" rel="stylesheet" />

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="<?=base_url()?>/assets/js/jquery-3.1.1.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="<?=base_url()?>/assets/js/bootstrap.min.js"></script>
    <script src="<?=base_url()?>/assets/js/toastr.min.js"></script>
    <script src="<?=base_url()?>/assets/js/jquery.numeric.min.js"></script>


    <!-- Font-Awesome -->
    <link href="http://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" media="all" rel="stylesheet" type="text/css" />


    <!-- Karjee Star Rating-->
    <link href="http://netdna.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.css" rel="stylesheet">
    <link href="<?=base_url()?>/assets/css/star-rating.min.css" media="all" rel="stylesheet" type="text/css" />
<!--    <link href="--><?//=base_url()?><!--/assets/css/krajee-fa.min.css" media="all" rel="stylesheet" type="text/css" />-->
    <link href="<?=base_url()?>/assets/css/krajee-svg/theme.min.css" media="all" rel="stylesheet" type="text/css" />

    <!-- optionally if you need to use a theme, then include the theme file as mentioned below -->
   <!-- <link href="path/to/themes/krajee-svg/theme.css" media="all" rel="stylesheet" type="text/css" /> -->

    <script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.0/jquery.js"></script>
    <script src="<?=base_url()?>/assets/js/star-rating.min.js" type="text/javascript"></script>
<!--    <script src="--><?//=base_url()?><!--/assets/js/krajee-fa.min.js" type="text/javascript"></script>-->
    <script src="<?=base_url()?>/assets/css/krajee-svg/theme.min.js" type="text/javascript"></script>

    <!-- optionally if you need to use a theme, then include the theme file as mentioned below -->
   <!-- <script src="path/to/themes/krajee-svg/theme.js"></script> -->

    <!-- optionally if you need translation for your language then include locale file as mentioned below -->
   <!-- <script src="path/to/js/locales/{lang}.js"></script> -->

    <!-- FULLPAGE -->
    <link href="<?=base_url()?>/assets/js/fullPage/jquery.fullPage.css" rel="stylesheet" type="text/css" />
    <script src="<?=base_url()?>/assets/js/fullPage/vendors/scrolloverflow.min.js" type="text/javascript"></script>
<!--    TODO: try if this^^^ works-->
    <script src="<?=base_url()?>/assets/js/fullPage/jquery.fullPage.min.js"></script>

    <script type="text/javascript">
        //toastr["error"]("You cannot select more than 4 slots at once!", "Error")

        toastr.options = {
            "closeButton": false,
            "debug": false,
            "newestOnTop": false,
            "progressBar": false,
            "positionClass": "toast-top-center",
            "preventDuplicates": true,
            "onclick": null,
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "2500",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        }
    </script>

    <script>
        document.addEventListener("contextmenu", function(e){
            if (e.target.nodeName === "IMG") {
                e.preventDefault();
            }
        }, false);
    </script>

    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />

</head>
<body>