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

    $(document).on('ready', function(){

        $questions = <?php echo json_encode($questions)?>;
        console.log($questions);
        getQuestions();

//        INITIALIZE FULLPAGE
//        SCROLLING TOGGLES
        $('.card-container').fullpage({
           onLeave: function(index, nextIndex, direction){
               if(($('.active').hasClass("card--question") && $('.active').find("input").val() < 1 && direction == 'down') ||
                   ($('.active').hasClass("card--submit") && $hasSubmitted == false && direction == 'down') ||
                   (($('.active').hasClass("card--thanks") || $('.active').hasClass("card--error")) && (direction == 'up' || direction == 'down')) ||
                   ($('.active').hasClass("card--start") && $hasStarted == false) ||
                   (index == 2 && direction == 'up')){
                   console.log("you can't move");
                   return false;
               }
           }
        });

//        BUTTON VISIBILITY TOGGLES
//        $('.custbtn--prev').toggleClass("custbtn--disabled", $('.active').hasClass("card--start")); //FIXME: Doesn't work. custbtn--disabled remains a class of custbtn--prev
//        $('.custbtn--next').toggleClass("custbtn--disabled", $('.active').hasClass("card--submit")); //FIXME: Doesn't work. custbtn--disabled is not added as a class of custbtn--next
//        $('body').on('swipe',function(){
//            console.log("Swipe!");
//        });
//        if($('.active').hasClass("card--start")){
//            $('.custbtn--prev').css('visibility','hidden');
//        }else{
//            $('.custbtn--prev').css('visibility','visible');
//        }
        $('.custbtn--prev, .custbtn--next').toggle(); //FIXME: bad, try add class method

//        BUTTON FUNCTIONS
        $('.custbtn--prev').on('click',function(){
            console.log("prev click!");
            $.fn.fullpage.moveSectionUp();
        });

        $('.custbtn--next').on('click',function(){
            console.log("next click!");
            //if the card is a question card, and the question card's stars have been filled in, active card's star has a .val() > 0
            if(!($('.active').hasClass("card--question")) || $('.active').find("input").val() > 0){
                $.fn.fullpage.moveSectionDown();
            }
        });

        $('.card--start').on('click',function(){
            console.log("START!");
            $hasStarted = true;
            $('.custbtn--next').toggle(); //FIXME: this works but is also really bad
            $.fn.fullpage.moveSectionDown();
        });

        $('.card--submit').on('click',function(){
            if($('.card--question').find("input").val() > 0){
                console.log("Submitting Answers!");
                submitAnswers();
            }
            else alert("You missed a spot");
        });

        $('.fa-repeat').on('click',function(){
           location.reload();
        });

        $('.fa-refresh').on('click',function(){
//            while(trying again){
//                make fa-refresh spin
            $('.fa-refresh').addClass("fa-spin"); //TODO: check
//            }
        });
    });


    function getQuestions(){
//        load all questions at the beginning
//        might have to change this back to the old version if I can't implement the stopped scrolling
        for(var questionIndex=0; questionIndex<$questions.length; questionIndex++){

            var text = [$questions[questionIndex]['Question_Act']];
            var id = [$questions[questionIndex]['Question_Num']]; //TODO: where will this be added/should I add it back

            var newQuestion = '<div class="card section card--question">' +
                                '<div class="card__content">' +
                                '<div class="content__text-area text-area--question">' +
                                '<img class="ribbon" src="<?=base_url()?>/assets/img/ribbon.svg">' +
                                '<h2 class="question__text" id="' + id.join('') + '">' + text.join('') + '</h2>' +
                                '</div>' +
                                '<div class="content__stars">' +
                                '<input id="star' + questionIndex +'" name="input-name" type="number" data-size="lg" class="rating-loading" onchange="updateStar(this.id)"></div>' +
                                '<div class="content__star-caption"></div>' +
                                '</div></div>';

            console.log("question index: "+questionIndex); console.log("question id: "+id); console.log("question text: "+text);
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
//        console.log("h2 id of active" + $('.active').find('h2').attr('id'));
        if(($('.active').hasClass("card--question")) && $('.active').find('h2').attr('id') > $answerCount){
            $answerCount++;
//            console.log($answerCount);
            updateProgressBar();
        }

        //prevent rating of zero stars
        if($('#' + star).val() < 1){
            $('#' + star).rating('update', 1);
        }

//        CUSTOM STAR CAPTIONS
        switch($('#' + star).val()){
            case '1':
                $('.active').find('.content__star-caption').text("Totally Disagree");
                break;
            case '2':
                $('.active').find('.content__star-caption').text("Partly Disagree");
                break;
            case '3':
                $('.active').find('.content__star-caption').text("Neutral");
                break;
            case '4':
                $('.active').find('.content__star-caption').text("Partly Agree");
                break;
            case '5':
                $('.active').find('.content__star-caption').text("Totally Agree");
                break;
        }
//        $.fn.fullpage.moveSectionDown(); //FIXME: buggy right now due to layout
    }

    function updateProgressBar(){
        //TODO: get this to work
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
                console.log("done");
                if (result['status']=="success") {
                    toastr.success(result['message']);
                }
                else {
                    toastr.error(result['message']);
                }
//                TODO: add code to jump to card--thanks
                $.fn.fullpage.moveSectionDown();
            })
            .fail(function() {
                console.log("fail");
//                TODO: add code to jump to card--error
                $('.card--thanks').hide();
                $.fn.fullpage.reBuild();
                $.fn.fullpage.moveSectionDown();
            })
            .always(function() {
                console.log("complete");
            });

        submitComment();
    }

    function submitComment(){
        if(/[a-z|0-9][a-z|0-9][a-z|0-9]/mi.test($('#comment').val())){
            $.ajax({
                url: '<?php echo base_url('questions/submitComment') ?>',
                type: 'GET',
                dataType: 'json',
                data: {
                    comment : $('#comment').val()
                }
            })
                .done(function(result) {
                    console.log("done");
                    if (result['status']=="success") {
                        toastr.success(result['message']);
                    }
                    else {
                        toastr.error(result['message']);
                    }

                })
                .fail(function() {
                    console.log("fail");
                })
                .always(function() {
                    console.log("complete");
                });
        }
        if(/[a-z|0-9][a-z|0-9][a-z|0-9]/mi.test($('#email').val())){//TODO Add email
            $.ajax({
                url: '<?php echo base_url('questions/submitEmail') ?>',
                type: 'GET',
                dataType: 'json',
                data: {
                    name : $('#name').val(), //TODO also add a form-name
                    email : $('email').val()
                }
            })
                .done(function(result) {
                    console.log("done");
                    if (result['status']=="success") {
                        toastr.success(result['message']);
                    }
                    else {
                        toastr.error(result['message']);
                    }

                })
                .fail(function() {
                    console.log("fail");
                })
                .always(function() {
                    console.log("complete");
                });
        }
    }


</script>

<!------------------------------------------HTML----------------------------------------------------->
<!--TODO: change color of todos-->
<!--TODO: make scroll animation quicker-->
<!--TODO: make comment area scroll without going to another card. Use focus or something maybe?-->
<!--FIXME: fix formatting which got fucked after implementing fullPage-->
<div class="custbtn-container">
    <i class="custbtn custbtn--prev fa fa-chevron-up"></i>
</div>
<div class="container" style="padding-left: 0px; padding-right: 0px;">
    <!--main area where background will go if ever-->
<!--    FIXME: how do format-->
    <div class="card-container">
        <div class="card section card--start active">
            <div class="card__content">
                <div class="content__text-area">TAP ANYWHERE<br>TO START THE<br>SURVEY</div>
                <i class="fa fa-hand-pointer-o fa-4x"></i>
            </div>
        </div>
        <div class="card section card--comment">
<!--            <div class="card__content">-->
<!--                <div class="form-group">-->
<!--                    <label for="name">Comments</label>-->
<!--                    <textarea class="form-control" id="comment"></textarea>-->
<!--                </div>-->
<!--            </div>-->
            <div class="form-group">
                <label for="name">Comments</label>
                <textarea class="form-control" id="comment"></textarea>
            </div>
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" class="form-control" id="name"><br>
                <label for="name">Email</label>
                <input type="text" class="form-control" id="email"><br>
                <label for="name">Cellphone Number</label>
                <input type="text" class="form-control" id="cellphone"><br>
            </div>
        </div>
        <div class="card section card--submit">
            <div class="card__content">
                <i class="fa fa-paper-plane-o fa-5x"></i>
                <div class="content__text-area">SUBMIT</div>
            </div>
        </div>
        <div class="card section card--thanks">
            <div class="card__content">
                <img class="thank" src="<?=base_url()?>/assets/img/thank.png">
                <!--                    TODO: convert png to svg-->
                <i class="fa fa-repeat fa-5x"></i>
                <div class="content__text-area">submit another response</div>
            </div>
        </div>
        <div class="card section card--error">
            <div class="card__content">
                <img class="oops" src="<?=base_url()?>/assets/img/oops.png">
                <div class="content__text-area">Something went wrong. Please try again.</div>
                <i class="fa fa-refresh fa-5x fa-fw"></i>
                <div>try again</div>
            </div>
        </div>
    </div>
</div>
<div class="custbtn-container">
    <i class="custbtn custbtn--next fa fa-chevron-down"></i>
</div>
<footer>
    <div class="footer__progress-bar">
        <div class="progress-bar__bar"></div>
    </div>
    <div class="footer__copyright">
        copyright
    </div>
</footer>
