<?php

/**
 * Created by PhpStorm.
 * User: Vincent
 * Date: 01/24/2017
 * Time: 10:48
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class HomeController extends CI_Controller
{

    /**
     * Index Page for this controller.
     *
     * Maps to the following URL
     *        http://example.com/index.php/welcome
     *    - or -
     *        http://example.com/index.php/welcome/index
     *    - or -
     * Since this controller is set as the default controller in
     * config/routes.php, it's displayed at http://example.com/
     *
     * So any other public methods not prefixed with an underscore will
     * map to /index.php/welcome/<method_name>
     * @see https://codeigniter.com/user_guide/general/urls.html
     */

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
        $data['events'] = $this->getEvents();
        $data['questionSets'] = $this->getQuestionSets();

        $data['errorMessage'] = null;

        $this->load->view('header');
        $this->load->view('home', $data); // $this->load->view('home', $data); set to this if data is set
        $this->load->view('footer');
    }

    public function getEvents(){
        $data = $this->survey->queryOpenEvents();

        return $data;
    }

    public function getQuestionSets(){
        $data = $this->survey->queryAllQuestionSets();

        return $data;
    }

    public function checkInputs(){
        $getData = array(
            'eventID' => $this->input->get('eventID'),
            'setID' => $this->input->get('setID')
        );

        if(!$this->survey->isExistingEvent($getData['eventID'])){
            $data = array(
                'status' => 'error',
                'message' => 'Choose an Event'
            );
        }
        else if(!$this->survey->isExistingSet($getData['setID'])){
            $data = array(
                'status' => 'error',
                'message' => 'Choose a Question Set'
            );
        }
        else{
           $data = array(
                'status' => 'success',
                'message' => 'Starting Survey!'
            );

            $this->setSessions($getData['eventID'], $getData['setID']);

        }

        echo json_encode($data);
    }

    public function setSessions($eventID, $setID){
        $_SESSION['eventID'] = $eventID;
        $_SESSION['setID'] = $setID;
    }
/*
    public function getQuestions(){
        $getData = array(
            'setID' => $this->input->get('setID')
        );

        $data = $this->survey->queryQuestionsBySetID($getData['setID']);

        echo json_encode($data);
    }

    function submitAnswers(){
        $getData = array(
            'setID' => $this->input->get('setID'),
            'eventID' => $this->input->get('eventID'),
            'answers' => $this->input->get
            'comments' =>
        );
    }
*/
}