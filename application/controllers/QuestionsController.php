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

    public function linkSurvey($url){
        $data = $this->survey->queryURLbyURL($url);

        if($data!=null) {
            $_SESSION['eventID'] = intval($data['Event_ID']);
            $_SESSION['setID'] = intval($data['Event_ID']);

            $this->loadSurvey();
        }
        else redirect("index.html");
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

    public function submitComment(){
        $getData = array(
            'comment' => $this->input->get('comment')
        );


        $this->survey->insertComment($_SESSION['setID'],$_SESSION['eventID'],$getData['comment']);


        $data = array(
            'status' => 'success',
            'message' => 'Comment Submitted!'
        );




        echo json_encode($data);
    }

    public function submitEmail(){
        $getData = array(
            'name' => $this->input->get('name'),
            'email' => $this->input->get('email'),
            'mobile' => $this->input->get('mobile')
        );


        if($getData['name']==null||$getData['name']==""){
            $getData['name']="No name";
        }
        if($getData['email']==null||$getData['email']==""){
            $getData['email']="No email";
        }
        if($getData['mobile']==null||$getData['mobile']==""){
            $getData['mobile']="No mobile";
        }



        $this->survey->insertEmail($getData['name'],$getData['email'],$getData['email']);


        $data = array(
            'status' => 'success',
            'message' => 'Contact Submitted!'
        );




        echo json_encode($data);
    }
}