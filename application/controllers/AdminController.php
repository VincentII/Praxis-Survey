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
                case ADMIN_SIGN_OUT:
                    $this->signOut();
                    break;
                case ADMIN_GET_REPORTS:
                    $this->getReports();
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
            array_push($answers,$this->survey->queryAnswerCountByQuestionID($question->question_ID));
        }

        $data = array(
            'status' => 'success',
            'message' => 'Starting Survey!',
            'answers' => $answers,
            'questions' => $questions
        );
        echo json_encode($data);
    }


}