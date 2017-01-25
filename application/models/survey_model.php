<?php

/**
 * Created by PhpStorm.
 * User: Vincent
 * Date: 01/25/2017
 * Time: 15:13
 */
class survey_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function queryAllQuestions(){
        $this->db->select('*');
        $this->db->from(TABLE_QUESTIONS);
        $this->db->order_by(COLUMN_SET_ID,COLUMN_QUESTION_Num);
        $query = $this->db->get();
        return $query->result();
    }

    public function queryAllQuestionSets(){
        $this->db->select('*');
        $this->db->from(TABLE_QUESTION_SET);
        $this->db->order_by(COLUMN_SET_ID);
        $query = $this->db->get();
        return $query->result();
    }

    public function queryAllEvents(){
        $this->db->select('*');
        $this->db->from(TABLE_EVENT_AND_LOCATION);
        $this->db->order_by(COLUMN_EVENT_ID);
        $query = $this->db->get();
        return $query->result();
    }

    public function queryAllEvents(){
        $this->db->select('*');
        $this->db->from(TABLE_ANSWERS);
        $this->db->order_by(COLUMN_);
        $query = $this->db->get();
        return $query->result();
    }
}