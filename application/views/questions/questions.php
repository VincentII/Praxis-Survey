<?php
/**
 * Created by PhpStorm.
 * User: Dante
 * Date: 2/1/2017
 * Time: 11:01
 */
?>

<script>
//    var $questions;
//    var $questionIndex = 0;
//    var $answerCount = 0;
//    var activeArray = [];
//    var $currCard;
//    var cardContainerHeight = $('.card-container').outerHeight()+1;
//
//    $(document).on('ready', function(){
//        $questions = <?php //echo json_encode($questions)?>//;
//        console.log($questions);
//
//
//        $('.card-container').scroll(function(){
//            var winTop = $('.card-container').scrollTop()+5;
//            var $lis = $('li');
//
//            var top = $.grep($lis, function(item){
//                return $(item).position().top <= winTop;
//            });
////            ^^^FIXME: only have one active element at a time^^^
//            $lis.removeClass('active');
//            $(top).addClass('active');
//
////            for all elements with an active class, get the id of the last one
//            $(function(){
//
//
//               $('.active').each(function(){
//                  activeArray.push($(this).attr('id'));
//               });
//
//
//                if(activeArray[activeArray.length-1]=="start"){
//                    $('.up-button').css('visibility','hidden');
//                }else{
//                    $('.up-button').css('visibility','visible');
//                }
//                if(activeArray[activeArray.length-1]=="submit"){
//                    $('.down-button').css('visibility','hidden');
//                }else{
//                    $('.down-button').css('visibility','visible');
//                }
////                TODO: move
//
//                $currCard = activeArray[activeArray.length-1];
//                console.log($currCard);
//
//              if($currCard != $('li').last().attr('id')){
//                  $('#next_button').prop('disabled',false);
////                  console.log("down should be enabled");
//              }
//              if(($currCard == $('li').last().attr('id')) && ($('#star'+($questionIndex-1)).val() < 1)){
//                  $('#next_button').prop('disabled',true); //card with id does not have rated stars
////                  console.log("down should be disabled");
//              }
//            });
////            FIXME: Is there a better solution for this?^^^
//        }); //end of scroll function
//    });
//
////    to replace getNextQuestion in the html
//    function clickDownButton() {
////      if the current card is the last list element, load the next question,
////          otherwise go to the next card
//
//        if($currCard == $('li').last().attr('id')){
//            getNextQuestion();
//        } else {
//            console.log("NEXT NEXT NEXT");
//            console.log("I will go to " + $("#" + $currCard).next('li').attr('id'));
////            TODO: something something href next element
//            scrollTo($("#" + $currCard).next('li').attr('id'));
//        }
//    }
//
//
//    function scrollTo(id){
//        console.log("scrolling to " + id);
//        var elemTop = $("#" + id).position().top;
//        console.log(elemTop);
////        FIXME: elemTop gets the exact same offset regardless of id whyyyyyyy check css etc
//        $('.card-container').scrollTop(elemTop);
//    }
//
//
//    function getNextQuestion(){
//
//        if($questionIndex>=$questions.length){
//            toastr.info("Submit your answers");
//
//            var $comment =
//                '<li class="list-element" id="comment">' +
//                '<textarea class="comment-area" id="form-comment" rows="5" columns="50" placeholder="write your love letter to praxis here"></textarea>' +
//                '</li>';
//
//            $('#questionList').append($comment);
//
//            var $submitButton =
//                '<li class="list-element" id="submit">' +
//                '<button onclick="submitAnswers()" id="submit_button">SUBMIT</button>' +
//                '</li>';
//
//            $('#questionList').append($submitButton);
////            $('#next_button').prop('disabled',true); //FIXME: disabled down button bug
//            $questionIndex++;
////            ^^^FIXME: better implementation of preventing the additional submit button bug?
//        }
//        else if($questionIndex ==0 ||($questionIndex !=0&&!$('next_button').isDisabled)){
//            var text = [
//                $questions[$questionIndex]['Question_Act']
//            ];
//
//            var id = [
//                $questions[$questionIndex]['Question_Num']
//            ];
//
//            var newQuestion = '<li class="list-element" id="q';
//            newQuestion += id.join('');
//            newQuestion += '"><div class="question"><p class="question-text">';
//            newQuestion += text.join('');
//            newQuestion += '</p>';
//            newQuestion += '<div class="question-stars">' +
//                '<input id="star' + $questionIndex +'" name="input-name" type="number" class="rating-loading" onchange="updateStar(this.id)"></div>'
//            newQuestion += '</div></li>';
//
//            $('#questionList').append(newQuestion);
//            $questionIndex++;
//            $('.rating-loading').rating({
//                step: 1,
//                showClear: false,
//                size: 'xl',
//                theme:'krajee-fa',
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
//            });
////            $('#next_button').prop('disabled',true); //FIXME: disabled down button bug
//        }
//    }//end of getNextQuestion
//
//    function updateStar(star){
//        if($questionIndex > $answerCount && $('#'+star).attr('id')==$('#star'+($questionIndex-1)).attr('id')){
//            $answerCount++;
//            updateProgressBar();
//        }
//
//        if($('#'+star).val() < 1) {
//            $('#' + star).rating('update', 1);
//        }
//        if($('#star'+($questionIndex-1)).val() >= 1 && !($questionIndex>$questions.length)) {
//            $('#next_button').prop('disabled', false); //FIXME: disabled down button bug
//        }
//    }
//
//    function updateProgressBar() {
//        var size = ($answerCount * 1.0)/$questions.length *100;
//
//        $(".progBar-child").css('width',size+"vw");
//    }
//
//    function submitAnswers(){
//        var $answers = [];
//        var $questionIDs = [];
//        for(var i =0; i<$questions.length;i++){
//            $answers[i] = $('#star'+(i)).val();
//            $questionIDs[i] = $questions[i]['question_ID'];
//        }
//
//        $.ajax({
//            url: '<?php //echo base_url('questions/submitAnswers') ?>//',
//            type: 'GET',
//            dataType: 'json',
//            data: {
//                answers : $answers,
//                questionIDs : $questionIDs
//            }
//        })
//            .done(function(result) {
//                console.log("done");
//                if (result['status']=="success") {
//                    toastr.success(result['message']);
//                }
//                else {
//                    toastr.error(result['message']);
//                }
//
//            })
//            .fail(function() {
//                console.log("fail");
//            })
//            .always(function() {
//                console.log("complete");
//            });
//
//        submitComment();
//    }
//
//    function submitComment(){
//        if(/[a-z|0-9][a-z|0-9][a-z|0-9]/mi.test($('#form-comment').val())){
//            $.ajax({
//                url: '<?php //echo base_url('questions/submitComment') ?>//',
//                type: 'GET',
//                dataType: 'json',
//                data: {
//                    comment : $('#form-comment').val()
//                }
//            })
//                .done(function(result) {
//                    console.log("done");
//                    if (result['status']=="success") {
//                        toastr.success(result['message']);
//                    }
//                    else {
//                        toastr.error(result['message']);
//                    }
//
//                })
//                .fail(function() {
//                    console.log("fail");
//                })
//                .always(function() {
//                    console.log("complete");
//                });
//        }
//        else{
//            toastr.info("Comment not submitted");//TODO TAKE THIS OUT
//        }
//    }

/////////////////////////////////////    new stuff    ////////////////////////////////////////////////

//    $(function(){
//       $('.scrollify')({
//           section: "li",
//       }) ;
//    });

    $(document).on('ready', function() {

        $questions = <?php echo json_encode($questions)?>;
        console.log($questions);

        $(function(){
           $.scrollify({
              section: ".section",
           });
        });
//        FIXME: $.scrollify not a function wtf??

        $('.btn--next').click(function(){
            console.log("click!");
            $.scrollify.next();
        });
    });


</script>

<!------------------------------------------HTML----------------------------------------------------->
<!--TODO: change color of todos-->

<!--<div class="main">-->
<!--    <div class="main-card">-->
<!--        <button class="up-button">up button</button>-->
<!--        <div class="card-container">-->
<!--            <ul class="card-list" id="questionList">-->
<!--                <li class="list-element" id="start">-->
<!--                    <p>I am the start card</p>-->
<!--                </li>-->
<!--            </ul>-->
<!--        </div>-->
<!--        <button class="down-button" id='next_button' onclick="clickDownButton()">down button</button>-->
<!--    </div>-->
<!--</div>-->
<!--<footer>-->
<!--    <div class="footer-progBar">-->
<!--        <div class="progBar-child">-->
<!--        </div>-->
<!--    </div>-->
<!--    <div class="footer-copyright">this is the footer and copyright info go here</div>-->
<!--</footer>-->


<div class="btn-container">
    <i class="btn btn--prev fa fa-chevron-up"></i>
</div>
<div class="container" style="padding-left: 0px; padding-right: 0px;">
    <!--main area where background will go if ever-->
    <div class="card-container">
        <ul class="card-list">
<!--            FIXME: Doesn't expand to fit cards after the first one-->
            <li class="card section active">
                <div class="card__content">
                    <div class="content__text-area">TAP ANYWHERE <br>TO START THE <br>SURVEY</div>
                    <i class="fa fa-hand-pointer-o fa-4x"></i>
                </div>
            </li>
            <li class="card section">
                <div class="card__content">
                    <div class="content__text-area question">
                        <img class="ribbon" src="<?=base_url()?>/assets/img/ribbon.svg">
                        <h2 class="question__text">I think I did well in the game.</h2>
                    </div>
                </div>
            </li>
            <li class="card section">
                <div class="card__content">
                    <i class="fa fa-paper-plane-o fa-5x"></i>
                    <div class="content__text-area">SUBMIT</div>
                </div>
            </li>
            <li class="card">
                <div class="card__content">
                    <img class="thank" src="<?=base_url()?>/assets/img/thank.png">
<!--                    TODO: convert png to svg-->
                    <i class="fa fa-repeat fa-5x"></i>
                    <div class="content__text-area">submit another response</div>
                </div>
            </li>
            <li class="card">
                <div class="card__content">
                    <img class="oops" src="<?=base_url()?>/assets/img/oops.png">
                    <div class="content__text-area">Something went wrong. Please try again.</div>
                    <i class="fa fa-refresh fa-5x fa-fw"></i>
                    <div>try again</div>
                </div>
            </li>
        </ul>
    </div>
</div>
<div class="btn-container">
    <i class="btn btn--next fa fa-chevron-down"></i>
</div>
<footer>
    <div class="footer__progress-bar">footer
    </div>
    <div class="footer__copyright">
        copyright
    </div>
</footer>
