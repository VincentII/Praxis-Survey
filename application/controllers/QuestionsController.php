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

        $data['questions'] = $this->survey->queryQuestionsBySetID($_SESSION['setID']);
        $data['eventID'] = $_SESSION['eventID'];
        $data['setID'] = $_SESSION['setID'];

        $this->load->view('questions/header');
        $this->load->view('questions/questions', $data); // $this->load->view('home', $data); set to this if data is set
        $this->load->view('questions/footer');


    }






    public function submitAnswers(){
        $getData = array(
            'answers' => $this->input->get('answers'),
            'questionIDs' => $this->input->get('questionIDs')
        );

        for($i =0; $i<count($getData['questionIDs']);$i++){
            $this->survey->insertAnswers($_SESSION['setID'],$_SESSION['eventID'],$getData['questionIDs'][$i],$getData['answers'][$i]);
        }

        $data = array(
            'status' => 'success',
            'message' => 'Survey Answered!'
        );




        echo json_encode($data);
    }
}