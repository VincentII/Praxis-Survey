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

        $('.rating-loading').rating({
            step: 1,
            starCaptions: {1: 'Totally Disagree', 2: 'Partly Disagree', 3: 'Neutral', 4: 'Partly Agree', 5: 'Totally Agree'},
            starCaptionClasses: {1: 'text-danger', 2: 'text-warning', 3: 'text-info', 4: 'text-primary', 5: 'text-success'}
        });
    });

    function getNextQuestion(){
        var text = [
            $questions[$questionIndex]['Question_Act']
        ];

        var id = [
            $questions[$questionIndex]['Question_Num']
        ];

        //allocate the div id later
        //does not scroll
        //TODO: make it scroll, probably related to some css shit
        var newQuestion = '<li id="q';
        newQuestion += id.join('');
        newQuestion += '"><div class="question"><p class="question-text">';
        newQuestion += text.join('');
        newQuestion += '</p>';
        newQuestion += '<div class="question-stars">'+
                        '<input id="star'+$questionIndex+'" name="input-name" type="number" class="rating-loading"></div>'
        newQuestion += '</div></li>';

        $('#questionList').append(newQuestion);
        $questionIndex++;
        $('.rating-loading').rating({
            step: 1,
            starCaptions: {1: 'Totally Disagree', 2: 'Partly Disagree', 3: 'Neutral', 4: 'Partly Agree', 5: 'Totally Agree'},
            starCaptionClasses: {1: 'text-danger', 2: 'text-warning', 3: 'text-info', 4: 'text-primary', 5: 'text-success'}
        });
    }//end of getNextQuestion

    function submitAnswers(){
        
    }

</script>

<!--HTML-->
<!--TODO: fix this before it gets too messy URGENT use BEM-->
<!--TODO: disable down button after last question has been reached-->
<!--TODO: change color of todos-->

<div class="main">
    <div class="main-card">
        <button class="up-button">up button</button>
        <ul class="card-list" id="questionList">
            <li>
                <p>I am the start card</p>
            </li>
        </ul>
        <ul class="card-list">
            <li>
                <button onclick="submitAnswers()">SUBMIT</button>
            </li>
        </ul>
        <button class="down-button" onclick="getNextQuestion()">down button</button>
    </div>
</div>
<footer>
    <div class="footer-progBar">this is a progress bar</div>
    <div class="footer-copyright">this is the footer and copyright info go here</div>
</footer>