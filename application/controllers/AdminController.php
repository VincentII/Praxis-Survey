<?php

/**
 * Created by PhpStorm.
 * User: Vincent
 * Date: 02/02/2017
 * Time: 14:37
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class AdminController extends CI_Controller
{
    public function __construct() {
        parent::__construct();
        $this->load->library('session');
    }

    public function index()
    {
        $this->loadAction("");
    }

    private function initAdmin() {
      redirect('admin/' . ADMIN_REPORTS);
    }

    public function loadAction($action) {
        if(!isset($_SESSION['adminUsername']) && $action != ADMIN_SIGN_IN) {
            $this->signInView("");
        }
        else {
            switch ($action) {
                case ADMIN_SIGN_IN:
                    $this->signIn();
                    break;
                case ADMIN_REPORTS:
                    $this->reportsView();
                    break;
                case ADMIN_EVENTS:
                    $this->eventsView();
                    break;
                case ADMIN_QUESTIONS:
                    $this->questionsView();
                    break;
                case ADMIN_LINKS:
                    $this->linksView();
                    break;
                case ADMIN_SIGN_OUT:
                    $this->signOut();
                    break;
                case ADMIN_GET_REPORTS:
                    $this->getReports();
                    break;
                case ADMIN_GET_QUESTIONS:
                    $this->getQuestions();
                    break;
                case ADMIN_SUBMIT_EVENT:
                    $this->submitEvent();
                    break;
                case ADMIN_SUBMIT_QUESTION_SET:
                    $this->submitQuestionSet();
                    break;
                case ADMIN_SUBMIT_URL:
                    $this->submitURL();
                    break;
                case ADMIN_UPDATE_EVENTS:
                    $this->updateEvents();
                    break;
                case ADMIN_UPDATE_URLS:
                    $this->updateURL();
                    break;
                case ADMIN_UPDATE_QUESTIONS:
                    $this->updateQuestions();
                    break;
                default:
                    $this->initAdmin();
            }
        }
    }

    public function signInView($errorMessage){
        //$data['login'] = $this->admin->queryAllModerators();

        $data['errorMessage'] = $errorMessage;

        $this->load->view('admin/a_header'); // include bootstrap 3 header -> included in home
        $this->load->view('admin/a_signIn', $data); // $this->load->view('admin', $data); set to this if data is set
        $this->load->view('admin/a_footer'); // include bootstrap 3 footer
    }

    public function signIn() {
        $n = $_POST["adminName"];
        $p = $_POST["adminPassword"];
        // = $this->input->post('#adminPassword');



        if ($this->admin->isValidUser($n,$p)) {
            $admin = $this->admin->queryAdminAccount($n);
            //$this->session->set_userdata($admin);
            $this->setSession($admin);
            $this->initAdmin();
        }
        else {
            $errorMessage = "Invalid username or password.";
            $this->signInView($errorMessage);
        }
    }

    private function setSession($admin) {
        $_SESSION['adminID'] = $admin['Admin_ID'];
        $_SESSION['adminType'] = $admin['Admin_Type'];
        $_SESSION['adminUsername'] = $admin['Username'];
    }

    private function reportsView(){

        $data['events'] = $this->survey->queryAllEvents();
        $data['questionSets'] = $this->survey->queryAllQuestionSets();

        $this->load->view('admin/a_header'); // include bootstrap 3 header -> included in home
        $this->load->view('admin/a_navbar');
        $this->load->view('admin/a_reports', $data); // $this->load->view('admin', $data); set to this if data is set
        $this->load->view('admin/a_footer'); // include bootstrap 3 footer
    }
    private function eventsView(){

        $data['events'] = $this->survey->queryNotArchivedEvents();

        $this->load->view('admin/a_header'); // include bootstrap 3 header -> included in home
        $this->load->view('admin/a_navbar');
        $this->load->view('admin/a_events', $data); // $this->load->view('admin', $data); set to this if data is set
        $this->load->view('admin/a_footer'); // include bootstrap 3 footer
    }

    private function linksView(){

        $data['events'] = $this->survey->queryAllEvents();
        $data['questionSets'] = $this->survey->queryAllQuestionSets();
        $data['links'] = $this->admin->queryURLWithEventAndSet();

        $this->load->view('admin/a_header'); // include bootstrap 3 header -> included in home
        $this->load->view('admin/a_navbar');
        $this->load->view('admin/a_links', $data); // $this->load->view('admin', $data); set to this if data is set
        $this->load->view('admin/a_footer'); // include bootstrap 3 footer
    }

    private function questionsView(){

        $data['questionSets'] = $this->survey->queryAllQuestionSets();

        $this->load->view('admin/a_header'); // include bootstrap 3 header -> included in home
        $this->load->view('admin/a_navbar');
        $this->load->view('admin/a_questions', $data); // $this->load->view('admin', $data); set to this if data is set
        $this->load->view('admin/a_footer'); // include bootstrap 3 footer
    }

    public function signOut() {
        $this->session->sess_destroy();
        $this->session->unset_userdata('email');
        $this->index();
    }


    public function getReports(){

        $eventID = $this->input->get('eventID');
        $setID = $this->input->get('setID');

        $answers = [];


            $questions = $this->survey->queryQuestionsBySetID($setID);




        foreach ($questions as $question){

            if($eventID == '0')
                $allRatings = $this->survey->queryAnswerCountByQuestionID($question->question_ID);
            else
                $allRatings = $this->survey->queryAnswerCountByQuestionIDAndEventID($question->question_ID,$eventID);




            $finalRatings=[];

            for($i = 1; $i < 6; $i++){

                $isIN =false;
                foreach ($allRatings as $rating){

                    if($rating->answer==$i.""){
                            $isIN = true;
                        array_push($finalRatings,$rating);
                    }

                }
                if(!$isIN&& isset($allRatings) && ($allRatings!=null)){
                    $tempRating = array('answer' => $i."",
                        'count' => "0",
                        'questionID' => $allRatings[0]->questionID,
                        'questionNum' => $allRatings[0]->questionNum);

                    array_push($finalRatings,$tempRating);

                }



            }

            array_push($answers,$finalRatings);

        }

        if(isset($allRatings) && ($allRatings!=null))
            $data = array(
                'status' => 'success',
                'message' => 'Starting Survey!',
                'answers' => $answers,
                'questions' => $questions
            );
        else
            $data = array(
            'status' => 'noReps',
            'message' => 'No Reports Available!'
        );
        echo json_encode($data);
    }

    public function getQuestions(){
        $setID= $this->input->get('setID');
        $data = array(
            'status' => 'success',
       //     'message' => 'Successfully added!',
            'questions' => $this->survey->queryQuestionsBySetID($setID)
        );

        echo json_encode($data);
    }

    public function submitEvent(){
        $getData = array(
            'name' => $this->input->get('name'),
            'date' => $this->input->get('date'),
            'location' => $this->input->get('location'),
            'isClosed' => $this->input->get('isClosed')
        );

        $getData['date'] = date('Y-m-d', strtotime(str_replace('-', '/', $getData['date'])));

        $closed = $this->input->get('isClosed')=='true'?1:0;

        $this->admin->insertEvent($getData['name'],$getData['date'],$getData['location'],$closed);


        $data = array(
            'status' => 'success',
            'message' => 'Successfully added '.$getData["name"].'!'
        );

        echo json_encode($data);


    }

    public function submitURL(){
        $getData = array(
            'url' => $this->input->get('url'),
            'eventID' => $this->input->get('eventID'),
            'setID' => $this->input->get('setID'),
        );

        if(!$this->admin->isExistingURL($getData['url'])) {
            $this->admin->insertURL($getData['url'], $getData['eventID'], $getData['setID']);
            $data = array(
                'status' => 'success',
                'message' => 'Successfully added ' . $getData["url"] . '!'
            );
        }
        else{

            $data = array(
                'status' => 'fail',
                'message' => $getData["url"] . ' link already exists, use another name!'
            );
        }
        echo json_encode($data);

    }

    public function submitQuestionSet(){
        $getData = array(
            'questions' => $this->input->get('questions'),
            'questionSet' => $this->input->get('questionSet')
        );

       if(!$this->admin->isExistingQuestionSet($getData['questionSet'])) {
            $this->admin->insertQuestionSet($getData['questionSet']);


            $setID = $this->survey->queryQuestionSetByDescription($getData['questionSet']);
          for($i = 0; $i<count($getData['questions']);$i++){
             $this->admin->insertQuestion($getData['questions'][$i][1],$getData['questions'][$i][0],$setID['Set_ID']);
              //$this->admin->insertQuestion("RAK","12","10");

          }

          $data = array(
                'status' => 'success',
                'message' => 'Successfully added '.$getData['questionSet'].'!'.$getData['questionSet'],
       //         'check' => $getData['questions'][0][1]
            );

        }
       else{

            $data = array(
                'status' => 'fail',
                'message' => $getData["questionSet"] . ' question set already exists, use another name!'
            );
       }

        echo json_encode($data);

    }

    public function updateEvents(){
        $events = $this->input->get('changedData');

        foreach ($events as $event){
            $data = array(
                COLUMN_EVENT_ID => $event[5],
                COLUMN_EVENT_NAME => $event[0],
                COLUMN_EVENT_DATE => date('Y-m-d', strtotime(str_replace('-', '/', $event[1]))),
                COLUMN_EVENT_LOCATION => $event[2],
                COLUMN_IS_CLOSED => $event[3]=='true'?0:1,
                COLUMN_IS_ARCHIVED => $event[4]=='true'?1:0,
            );

            $this->admin->updateEvent($data);
        }

        $datum = array(
            'status' => 'success',
            'message' => 'Successfully UPDATED'
            //         'check' => $getData['questions'][0][1]
        );

        echo json_encode($datum);
    }

    public function updateURL(){
        $URLs = $this->input->get('changedData');


        foreach ($URLs as $url){

            if($url[3]=='true'){
                $this->admin->deleteURL($url[4]);
            }else{
            $data = array(
                COLUMN_URL_ID => $url[4],
                COLUMN_URL => $url[0],
                COLUMN_EVENT_ID => intval($url[1]),
                COLUMN_SET_ID => intval($url[2])
            );
            $this->admin->updateURL($data);
            }
        }

        $datum = array(
            'status' => 'success',
            'message' => 'Successfully UPDATED'
            //         'check' => $getData['questions'][0][1]
        );

        echo json_encode($datum);
    }

    public function updateQuestions(){
        $questions = $this->input->get('changedData');
        $deletedQuestions = $this->input->get('deletedQuestions');
        $setID = $this->input->get('setID');

        $added = 0;
        $deleted = 0;
        $updated = 0;


        if(count($deletedQuestions)>0)
        foreach ($deletedQuestions as $deletedQuestion){
            $this->admin->deleteQuestion(intval($deletedQuestion));
            $deleted++;
        }

        if(count($questions)>0)
        foreach ($questions as $question){
            if($question[2]!='new') {
                $data = array(
                    COLUMN_QUESTION_ID => intval($question[2]),
                    COLUMN_QUESTION_Num => intval($question[0]),
                    COLUMN_QUESTION_ACT => $question[1],
                );

                $this->admin->updateQuestion($data);
                $updated++;
            }
            else{
                $this->admin->insertQuestion($question[1],$question[0],$setID);
                $added++;
            }

        }

        $datum = array(
            'status' => 'success',
            'message' => 'Successfully UPDATED',
            'added' => $added,
            'deleted' => $deleted,
            'updated' => $updated,

            //         'check' => $getData['questions'][0][1]
        );

        echo json_encode($datum);
    }


}