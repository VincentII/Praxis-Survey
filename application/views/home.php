<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Created by PhpStorm.
 * User: Vincent
 * Date: 01/24/2017
 * Time: 10:49
 */

?><!DOCTYPE html>

<html>
    <head>
        <script>
            function check(){
                console.log("HI");
                console.log($stuff);
            }
            console.log("d:"+ $row);
        </script>

    </head>
    <body>
        Hello World!
        <button onclick="check()">LOL</button>
        <?php echo 'in nav ';var_dump($stuff); exit; ?>

    </body>
</html>