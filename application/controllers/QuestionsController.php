<?php

/**
 * Created by PhpStorm.
 * User: Dante
 * Date: 2/1/2017
 * Time: 11:25
 */
class QuestionsController extends CI_Controller
{
    public function __construct() {
        parent::__construct();
        $this->load->library('session');
    }

    public function index()
    {

        $this->loadSurvey();
    }

    public function loadSurvey()
    {

        //$this->load->model('check');
        //$maxNumberOfSlots = $this->student->getMaxNumberOfSlots();
        //$data['stuff'] = $this->survey->queryAnswerCountByQuestionID(1);

        $eventID = $_GET['eventID'];
        $setID = $_GET['setID'];


        $_SESSION['eventID'] = $eventID;
        $_SESSION['setID'] = $setID;

        $data['questions'] = $this->survey->queryQuestionsBySetID($_SESSION['setID']);
        $data['eventID'] = $_SESSION['eventID'];
        $data['setID'] = $_SESSION['setID'];

        $this->load->view('questions/header');
        $this->load->view('questions/questions', $data); // $this->load->view('home', $data); set to this if data is set
        $this->load->view('questions/footer');


    }






    public function submitAnswers(){

    }
}