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
    var $questionIndex = 0;

    $(document).on('ready', function(){
        $questions = <?php echo json_encode($questions)?>;
        console.log($questions);
        


        $('.card-container').scroll(function(){
            var winTop = $(window).scrollTop();
            var $lis = $('li');

            var top = $.grep($lis, function(item){
                return $(item).position().top <= winTop;
            });
//            ^^^FIXME: only have one active element at a time^^^
            $lis.removeClass('active');
            $(top).addClass('active');

//            for all elements with an active class, get the id of the last one
            $(function(){
               var activeArray = [];

               $('.active').each(function(){
                  activeArray.push($(this).attr('id'));
               });
                console.log(activeArray[activeArray.length-1]);
            });
//            FIXME: Is there a better solution for this?^^^
        }); //end of scroll function
    });


    function getNextQuestion(){

        if($questionIndex>=$questions.length){
            toastr.info("Submit your answers");

            var $submitButton =
                '<li class="list-element" id="submit">' +
                '<button onclick="submitAnswers()" id="submit_button">SUBMIT</button>' +
                '</li>';

            $('#questionList').append($submitButton);
            //TODO: Append Submit Card Here
            $('#next_button').prop('disabled',true);
            $questionIndex++;
//            ^^^FIXME: better implementation of preventing the additional submit button bug?
        }
        else if($questionIndex ==0 ||($questionIndex !=0&&!$('next_button').isDisabled)){
            var text = [
                $questions[$questionIndex]['Question_Act']
            ];

            var id = [
                $questions[$questionIndex]['Question_Num']
            ];

            var newQuestion = '<li class="list-element" id="q';
            newQuestion += id.join('');
            newQuestion += '"><div class="question"><p class="question-text">';
            newQuestion += text.join('');
            newQuestion += '</p>';
            newQuestion += '<div class="question-stars">' +
                '<input id="star' + $questionIndex +'" name="input-name" type="number" class="rating-loading" onchange="updateStar(this.id)"></div>'
            newQuestion += '</div></li>';

            $('#questionList').append(newQuestion);
            $questionIndex++;
            $('.rating-loading').rating({
                step: 1,
                showClear: false,
                size: 'xl',
                theme:'krajee-fa',
                starCaptions: {
                    1: 'Totally Disagree',
                    2: 'Partly Disagree',
                    3: 'Neutral',
                    4: 'Partly Agree',
                    5: 'Totally Agree'
                },
                starCaptionClasses: {
                    1: 'text-danger',
                    2: 'text-warning',
                    3: 'text-info',
                    4: 'text-primary',
                    5: 'text-success'
                }
            });
            $('#next_button').prop('disabled',true);
        }
    }//end of getNextQuestion

    function updateStar(star){

        if($('#'+star).val() < 1)
            $('#'+star).rating('update',1);
            if($('#star'+($questionIndex-1)).val() >= 1 && !($questionIndex>$questions.length))
                $('#next_button').prop('disabled',false);
//        else
//            $('#next_button').prop('disabled',true);



    }

    function submitAnswers(){
        var $answers = [];
        var $questionIDs = [];
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

            })
            .fail(function() {
                console.log("fail");
            })
            .always(function() {
                console.log("complete");
            });
    }

</script>

<!------------------------------------------HTML----------------------------------------------------->
<!--TODO: fix this before it gets too messy URGENT use BEM-->
<!--TODO: disable down button after last question has been reached-->
<!--TODO: change color of todos-->

<div class="main">
    <div class="main-card">
        <button class="up-button">up button</button>
        <div class="card-container">
            <ul class="card-list" id="questionList">
                <li class="list-element" id="start">
                    <p>I am the start card</p>
                </li>
            </ul>
        </div>
        <button class="down-button" id='next_button' onclick="getNextQuestion()">down button</button>
    </div>
</div>
<footer>
    <div class="footer-progBar">this is a progress bar</div>
    <div class="footer-copyright">this is the footer and copyright info go here</div>
</footer>

