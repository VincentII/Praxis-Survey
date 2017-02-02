<?php

/**
 * Created by PhpStorm.
 * User: Vincent
 * Date: 02/02/2017
 * Time: 14:37
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class AdminController extends CI_Model
{
    public function __construct() {
        parent::__construct();
        $this->load->library('session');
    }
}