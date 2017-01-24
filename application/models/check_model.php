<?php

/**
 * Created by PhpStorm.
 * User: Vincent
 * Date: 01/24/2017
 * Time: 13:24
 */
class check_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    function queryCheck() {
        $sql = "SELECT *
                FROM questionset";

        return $this->db->query($sql)->result();
    }
}