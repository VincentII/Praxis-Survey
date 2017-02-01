<?php

/**
 * Created by PhpStorm.
 * User: Dante
 * Date: 2/1/2017
 * Time: 11:25
 */
class Questions extends CI_Controller
{
    public function __construct() {
        parent::__construct();
    }

    public function index()
    {

        $this->home();
    }

    public function home()
    {

        //$this->load->model('check');
        //$maxNumberOfSlots = $this->student->getMaxNumberOfSlots();
        //$data['stuff'] = $this->survey->queryAnswerCountByQuestionID(1);

        $this->load->view('questions/header');
        $this->load->view('questions/questions');//, $data); // $this->load->view('home', $data); set to this if data is set
        $this->load->view('questions/footer');
    }
}