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
    });

    function getNextQuestion(){
        var text = [
            $questions[$questionIndex]['Question_Act']
        ];

        //allocate the div id later
        //does not scroll
        //TODO: make it scroll, probably related to some css shit
        var newQuestion = '<li><div class="question"><p class="question-text">';
        newQuestion += text.join('');
        newQuestion += '</p></div></li>';

        $('.card-list').append(newQuestion);
        $questionIndex++;
    }

</script>

<!--HTML-->
<div class="main">
    <div class="main-card">
        <button class="up-button">up button</button>
        <ul class="card-list">
            <li>
                <div class="question" id="q1">
<!--                    <div class="question-text">question and orange bg go here</div>-->
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

<!-- TODO: FOR REFERENCE DELETE LATER
<section class="site-body">
    <div class="body-questions">
        <ul id="posts">
            <li>
                <div class="question-card">Wow a QUESTION!</div>
            </li>
        </ul>
        <button class="next-button" onclick="clickFunction()">next</button>
    </div>
</section>

<footer class="site-footer">
    <div class="footer-copyright">
        COPYRIGHT COPYRIGHT
        <br>
        PIRACY IS STEALING AND STEALING IS AGAINST THE LAW
        <br>
        AYYY!
        <br>
        <div class="link"><a>Home</a></div>
    </div>
</footer>
-->