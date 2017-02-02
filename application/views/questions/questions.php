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
            starCaptions: {1: 'Very Poor', 2: 'Poor', 3: 'Ok', 4: 'Good', 5: 'Very Good'},
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

        $('.card-list').append(newQuestion);
        $questionIndex++;
        $('.rating-loading').rating({
            step: 1,
            starCaptions: {1: 'Very Poor', 2: 'Poor', 3: 'Ok', 4: 'Good', 5: 'Very Good'},
            starCaptionClasses: {1: 'text-danger', 2: 'text-warning', 3: 'text-info', 4: 'text-primary', 5: 'text-success'}
        });
    }

</script>

<!--HTML-->
<div class="main">
    <div class="main-card">
        <button class="up-button">up button</button>
        <ul class="card-list">
            <li id="start">
                <div class="question">
                    <p class="question-text"> This is the first question</p>
                    <div class="question-stars">stars and description text go here</div>
                </div>
            </li>
        </ul>
        <button class="down-button" onclick="getNextQuestion()">down button</button>
    </div>
    <div class="main-progBar">this is a progress bar</div>
</div>
<footer>this is the footer and copyright info go here</footer>