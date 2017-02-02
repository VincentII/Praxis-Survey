<?php
/**
 * Created by PhpStorm.
 * User: Dante
 * Date: 2/1/2017
 * Time: 11:01
 */
?>

<script>
    var $questions = <?php echo json_encode($questions)?>;
    console.log($questions);
    console.log($questions[0]['Question_Act']);

</script>

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