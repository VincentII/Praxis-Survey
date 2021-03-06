
<nav class="navbar navbar-default">
    <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <!-- ADD CONDITION FOR ADMIN VIEW HERE -->
               
                <span class="icon-bar"></span>
               
                <!-- ADD CONDITION FOR ADMIN VIEW HERE -->
                <span class="icon-bar"></span>
            </button>
<!--            <a class="navbar-brand" href="#">-->

                <a class="navbar-brand">
                    <img class="img-responsive" src="<?=base_url()?>/assets/img/Praxis%20Logo.svg" width="55" height="auto" >
                </a>

<!--            </a>-->
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">

                <li id="overview_button"><a href="<?=site_url("admin/" . ADMIN_REPORTS)?>">Reports<span class="sr-only"></span></a></li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                        Manage<span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="<?=site_url("admin/" . ADMIN_EVENTS)?>">Manage Events</a></li>
                        <li><a href="<?=site_url("admin/" . ADMIN_QUESTIONS)?>">Manage Questions</a></li>
                        <li><a href="<?=site_url("admin/" . ADMIN_LINKS)?>">Manage Links</a></li>
                        <?php if($_SESSION['adminType'] == 1): ?>
                        <li><a href="<?=site_url("admin/" . ADMIN_ARCHIVE)?>">Manage Archive</a></li>
                        <?php endif;?>

                    </ul>
                </li>
                <?php if($_SESSION['adminType'] == 1): ?>
                    <li id="overview_button"><a href="<?=site_url("admin/" . ADMIN_ADMINS)?>">Admins<span class="sr-only"></span></a></li>
                <?php endif;?>

            </ul>



            <ul class="nav navbar-nav navbar-right">


                <li id="overview_button"><a href="<?=site_url("admin/" . ADMIN_EMAILS)?>">Check Emails<span class="sr-only"></span></a></li>
                        <!--<li><a href="#">Modify Account</a></li>
                        <li role="separator" class="divider"></li>-->

                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                        Account<span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="<?=site_url('admin/' . ADMIN_ACCOUNT)?>"><?=$_SESSION['adminUsername']?></a></li>
                        <li><a href="<?=site_url('admin/' . ADMIN_SIGN_OUT)?>">Sign Out</a></li>
                    </ul>
                </li>
            </ul>
        </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
</nav>
