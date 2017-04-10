<?php
/**
 * Created by PhpStorm.
 * User: Dante
 * Date: 2/1/2017
 * Time: 11:01
 */
?>

<script>
    var $questions;
    var $answerCount = 0;
    var $hasStarted = false;
    var $hasSubmitted = false;
    var $error = false;
    var $device;

    $(document).on('ready', function(){

        $questions = <?php echo json_encode($questions)?>;
//        console.log($questions);
        getQuestions();

        $device = getDevice();

        if($device == "iphone" || $device == "ipad"){ // TODO: test if stylesheet for iphone 6 and bigger works for ipad
            var cssLink = document.createElement("link");
            cssLink.title = "iphone";
            cssLink.href = "<?=base_url()?>/assets/css/questions_iphone.css?<?php echo time(); ?>";
            cssLink.rel = "stylesheet";
            document.head.appendChild(cssLink);

            $('link#basic').replaceWith('<link id="iphone" href="<?=base_url()?>/assets/css/questions_iphone.css?<?php echo time(); ?>" rel="stylesheet" />');
        }


//        INITIALIZE FULLPAGE
//        SCROLLING TOGGLES
        $('.card-container').fullpage({
            scrollOverflow: true,
            onLeave: function(index, nextIndex, direction){
                if(($('.active').hasClass("card--question") && $('.active').find("input").val() < 1 && direction == 'down') ||
                   ($('.active').hasClass("card--submit") && $hasSubmitted == false && direction == 'down') ||
                   ($('.active').hasClass("card--thanks") && (direction == 'up' || direction == 'down') && $error == false) ||
                   ($('.active').hasClass("card--error") && direction == 'up' && $error == true) ||
                   ($('.active').hasClass("card--error") && direction == 'down') ||
                   ($('.active').hasClass("card--start") && $hasStarted == false) ||
                   (index == 2 && direction == 'up')){
                   return false;
                }
            },
//        BUTTON VISIBILITY TOGGLES
            afterLoad: function(anchorLink,index){

               if(index <= 1||$('.active').hasClass("card--submit")||$('.active').hasClass("card--thanks")||$('.active').hasClass("card--error"))
                   $('.custbtn--next').hide();
               else
                    $('.custbtn--next').show();

               if(index <= 2||$('.active').hasClass("card--thanks")||$('.active').hasClass("card--error"))
                   $('.custbtn--prev').hide();
               else
                   $('.custbtn--prev').show();

               updateNextButton();
           }
        });

//        HIDE AND SHOW FOOTER
        $('.form-control').focus(function(){
           if($device != "desktop"){
               $('footer').hide();
               $('.custbtn--next').hide();
               if($device != "iphone"){
                    $.fn.fullpage.setResponsive(true);
               }
           }

           $.fn.fullpage.setAllowScrolling(false); //doesn't work on mobile any more because of setresponsive?
           $.fn.fullpage.setKeyboardScrolling(false);
        });

        $('.form-control').blur(function(){
           $('footer').show();
            $('.custbtn--next').show();
            if($device != "iphone"){
                $.fn.fullpage.setResponsive(false);
            }

            $.fn.fullpage.setAllowScrolling(true);
            $.fn.fullpage.setKeyboardScrolling(true);
        });

//        BUTTON FUNCTIONS
        $('.custbtn--prev').on('click',function(){
            $.fn.fullpage.moveSectionUp();
        });

        $('.custbtn--next').on('click',function(){
            //if the card is a question card, and the question card's stars have been filled in, active card's star has a .val() > 0
            if(!($('.active').hasClass("card--question")) || $('.active').find("input").val() > 0){
                $.fn.fullpage.moveSectionDown();
            }
        });

        $('.card--start').on('click',function(){
            $hasStarted = true;
            $.fn.fullpage.moveSectionDown();
        });

        $('.card--submit').on('click',function(){
            if($('.card--question').find("input").val() > 0){
                submitAnswers();
                $('.card--submit').find('.content__text-area').text("submitting..."); //TODO: add a ... animation
            }
            else alert("You missed a spot");
        });

        $('.fa-repeat').on('click',function(){
            $('.fa-repeat').addClass("fa-spin");
            $('.card--thanks').find('.content__text-area').text("refreshing..."); //TODO: add a ... animation
            location.reload();
        });

        $('.fa-refresh').on('click',function(){
            $('.fa-refresh').addClass("fa-spin");
            $('.card--error').find('.content__text-area').text("trying again..."); //TODO: add a ... animation
            submitAnswers();
        });

    });


    function getQuestions(){
//        load all questions at the beginning
        for(var questionIndex=0; questionIndex<$questions.length; questionIndex++){

            var text = [$questions[questionIndex]['Question_Act']];
            var id = [$questions[questionIndex]['Question_Num']];

            var newQuestion = '<div class="card section card--question">' +
                                '<div class="card__content">' +
                                '<div class="text-area--question">' +
                                '<img class="ribbon" src="<?=base_url()?>/assets/img/ribbon.svg">' +
                                '<div class="question__container"><div class="question__text" id="' + id.join('') + '">' + text.join('') + '</div></div>' +
                                '</div>' +
                                '<div class="content__stars">' +
                                '<input id="star' + questionIndex +'" name="input-name" type="number" data-size="md" class="rating-loading" onchange="updateStar(this.id)"></div>' +
                                '<div class="content__star-caption"></div>' +
                                '</div></div>';

//            console.log("question index: "+questionIndex); console.log("question id: "+id); console.log("question text: "+text);
            $(newQuestion).insertBefore('.card--comment'); //don't mind this weird warning it is a lie

            $('.rating-loading').rating({
                step: 1,
                showClear: false,
                showCaption: false,
                size: 'xl',
                theme:'krajee-svg',
//                starCaptions: {
//                    1: 'Totally Disagree',
//                    2: 'Partly Disagree',
//                    3: 'Neutral',
//                    4: 'Partly Agree',
//                    5: 'Totally Agree'
//                },
//                starCaptionClasses: {
//                    1: 'text-danger',
//                    2: 'text-warning',
//                    3: 'text-info',
//                    4: 'text-primary',
//                    5: 'text-success'
//                }
            });
        }//end of for loop
    }//end of getQuestions

    function updateStar(star){
        if(($('.active').hasClass("card--question")) && $('.active').find('.question__text').attr('id') > $answerCount){
            $answerCount++;
            updateProgressBar();
        }



        //prevent rating of zero stars
        if($('#' + star).val() < 1){
            $('#' + star).rating('update', 1);
        }

        var labels = ["Totally Disagree","Partly Disagree","Neutral","Partly Agree","Totally Agree"];

//        CUSTOM STAR CAPTIONS
          $('.active').find('.content__star-caption').text(labels[parseInt($('#' + star).val())-1]);

        updateNextButton();
    }

    function updateNextButton(){
        if($('.active').hasClass("card--question") && $('.active').find("input").val()<1){
            $('.custbtn--next').addClass('custbtn--off');
        }
        else {
            $('.custbtn--next').removeClass('custbtn--off');
        }
    }

    function updateProgressBar(){
        var size = ($answerCount * 1.0)/$questions.length *100;

        $('.progress-bar__bar').css('width', size+"vw");
    }

    function submitAnswers(){
        var $answers = [];
        var $questionIDs = [];
        $hasSubmitted = true;
        for(var i =0; i<$questions.length;i++){
            $answers[i] = $('#star'+(i)).val();
            $questionIDs[i] = $questions[i]['question_ID'];
        }

        $.ajax({
            url: '<?php echo base_url('questions/submitAnswers') ?>',
            type: 'GET',
            dataType: 'json',
            data: {
                answers : $answers,
                questionIDs : $questionIDs
            }
        })
            .done(function(result) {
//                console.log("done");
                if (result['status']=="success") {
//                    toastr.success(result['message']);
                    submitComment();
                }
                else {
//                    toastr.error(result['message']);
                }
                if($error){
                    $error = false;
                    $.fn.fullpage.moveSectionUp();
                } else{
                    $.fn.fullpage.moveSectionDown();
                }
            })
            .fail(function() {
//                console.log("fail");
                if($error == false){
                    $error = true;
                    $.fn.fullpage.moveSectionDown();
                    $.fn.fullpage.moveSectionDown();
                } else{
                    $('.fa-refresh').removeClass("fa-spin");
                    $('.card--error').find('.content__text-area').text("Something went wrong. Please try again.");
                }
            })
            .always(function() {
//                console.log("complete");
            });

    }

    function submitComment(){
        if(/\w../mi.test($('#comment').val())){
            $.ajax({
                url: '<?php echo base_url('questions/submitComment') ?>',
                type: 'GET',
                dataType: 'json',
                data: {
                    comment : $('#comment').val()
                }
            })
                .done(function(result) {
//                    console.log("done");
                    if (result['status']=="success") {
//                        toastr.success(result['message']);
                    }
                    else {
//                        toastr.error(result['message']);
                    }

                })
                .fail(function() {
//                    console.log("fail");
                })
                .always(function() {
//                    console.log("complete");
                });
        }
        if(/[a-z|0-9][a-z|0-9][a-z|0-9]/mi.test($('#email').val())||/[a-z|0-9][a-z|0-9][a-z|0-9]/mi.test($('#cellphone').val())){
            $.ajax({
                url: '<?php echo base_url('questions/submitEmail') ?>',
                type: 'GET',
                dataType: 'json',
                data: {
                    name : $('#name').val(),
                    email : $('#email').val(),
                    cell : $('#cellphone').val(),
                }
            })
                .done(function(result) {
//                    console.log("done");
                    if (result['status']=="success") {
//                        toastr.success(result['message']);
                    }
                    else {
//                        toastr.error(result['message']);
                    }

                })
                .fail(function() {
//                    console.log("fail");
                })
                .always(function() {
//                    console.log("complete");
                });
        }
    }


    function getDevice(){
        return '<?php
            $device = 'desktop';

            if( stristr($_SERVER['HTTP_USER_AGENT'],'ipad') ) {
                $device = "ipad";
            } else if( stristr($_SERVER['HTTP_USER_AGENT'],'iphone') || strstr($_SERVER['HTTP_USER_AGENT'],'iphone') ) {
                $device = "iphone";
            } else if( stristr($_SERVER['HTTP_USER_AGENT'],'blackberry') ) {
                $device = "blackberry";
            } else if( stristr($_SERVER['HTTP_USER_AGENT'],'android') ) {
                $device = "android";
            }

            if( $device ) {
                echo $device;
            }echo false; ?>' +"";
    }

</script>

<!------------------------------------------HTML----------------------------------------------------->
<div class="custbtn-container--prev">
    <div class="custbtn custbtn--prev"><span class="glyphicon glyphicon-chevron-up"></span></div>
</div>
<div class="container" style="padding-left: 0px; padding-right: 0px;">
    <!--main area where background will go if ever-->
    <div class="card-container">
        <div class="card section card--start active">
            <div class="card__content">
                <div class="content__text-area">TAP ANYWHERE<br>TO START THE<br>SURVEY</div>
                <i class="fa fa-hand-pointer-o fa-4x"></i>
            </div>
        </div>
        <div class="card section card--comment">
            <div class="comment--container">
                <div class="form-group">
                    <label for="name" class="form-group__main-label form-label--comment">Talk to us about your Praxis experience: *</label>
                    <textarea class="form-control" id="comment"></textarea>
<!--                    ^^^TODO: add a placeholder that says, leave a comment here-->
                </div>
                <div class="form-group">
                    <label for="name" class="form-group__main-label">Leave your email OR cellphone number to receive updates on Praxis, and future game play!</label><br>
                    <label for="name">Name *</label>
                    <input type="text" class="form-control" id="name"><br>
                    <label for="name">Email *</label>
                    <input type="text" class="form-control" id="email"><br>
                    <label for="name">Cellphone Number *</label>
                    <input type="text" class="form-control" id="cellphone"><br>
                    <span>* optional</span>
                </div>
            </div>
        </div>
        <div class="card section card--submit">
            <div class="card__content">
                <i class="fa fa-paper-plane-o fa-5x"></i>
                <br>
                <div class="content__text-area">SUBMIT</div>
            </div>
        </div>
        <div class="card section card--thanks fp-noscroll">
            <div class="card__content">
                <img class="thank" src="<?=base_url()?>/assets/img/thank.png" style="padding-bottom: 0px">
                <i class="fa fa-repeat fa-5x" alt="Click here to submit another response!"></i>
                <br>
                <div class="content__text-area">submit another response</div>
            </div>
        </div>
        <div class="card section card--error fp-noscroll">
            <div class="card__content">
                <img class="oops" src="<?=base_url()?>/assets/img/oops.png" style="padding-bottom: 0px">
                <i class="fa fa-refresh fa-5x fa-fw" alt="Click here to try again!"></i>
                <br>
                <div class="content__text-area">Something went wrong. Please try again.</div>
            </div>
        </div>
    </div>
</div>
<div class="custbtn-container--next">
    <div class="custbtn custbtn--next"><span class="glyphicon glyphicon-chevron-down"></span></div>
</div>
<footer>
    <div class="footer__progress-bar">
        <div class="progress-bar__bar"></div>
    </div>
    <div class="footer__copyright">
        <div class="copyright__container">Copyright © Sense For Money Philippines, Inc., 2016-2017. <br>All rights reserved.</div>
    </div>
</footer>
