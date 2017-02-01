<?php

/**
 * Created by PhpStorm.
 * User: Vincent
 * Date: 01/25/2017
 * Time: 15:13
 */
class survey_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    function queryAllQuestions(){
        $this->db->select('*');
        $this->db->from(TABLE_QUESTIONS);
        $this->db->order_by(COLUMN_SET_ID,COLUMN_QUESTION_Num);
        $query = $this->db->get();
        return $query->result();
    }

    function queryAllQuestionSets(){
        $this->db->select('*');
        $this->db->from(TABLE_QUESTION_SET);
        $this->db->order_by(COLUMN_SET_ID);
        $query = $this->db->get();
        return $query->result();
    }

    function queryAllEvents(){
        $this->db->select('*');
        $this->db->from(TABLE_EVENT);
        $this->db->order_by(COLUMN_EVENT_ID);
        $query = $this->db->get();
        return $query->result();
    }

    function queryAllAnswers(){
        $this->db->select('*');
        $this->db->from(TABLE_ANSWERS);
        $this->db->order_by(COLUMN_QUESTION_ID);
        $query = $this->db->get();
        return $query->result();
    }

    function queryAllComments(){
        $this->db->select('*');
        $this->db->from(TABLE_COMMENT);
        $this->db->order_by(COLUMN_COMMENT_ID);
        $query = $this->db->get();
        return $query->result();
    }

    function queryAllUsers(){
        $this->db->select('*');
        $this->db->from(TABLE_USER);
        $this->db->order_by(COLUMN_EMAIL);
        $query = $this->db->get();
        return $query->result();
    }


    function queryQuestionsBySetID($id){
        $this->db->select("*");
        $this->db->from(TABLE_QUESTIONS);
        $this->db->where(COLUMN_SET_ID, $id);
        $this->db->order_by(COLUMN_QUESTION_Num);
        $query = $this->db->get();

        return $query->result();
    }

    function queryAnswersBySetID($id){
        $this->db->select("*");
        $this->db->from(TABLE_ANSWERS);
        $this->db->where(COLUMN_SET_ID, $id);
        $this->db->order_by(COLUMN_QUESTION_Num);
        $query = $this->db->get();

        return $query->result();
    }

    function queryAnswersBySetIDAndEventID($setID,$eventID){
        $this->db->select("*");
        $this->db->from(TABLE_ANSWERS);
        $this->db->where(COLUMN_SET_ID, $setID);
        $this->db->where(COLUMN_EVENT_ID, $eventID);
        $this->db->order_by(COLUMN_QUESTION_Num);
        $query = $this->db->get();

        return $query->result();
    }

    //TODO Answer count by question

    function queryAnswerCountBySetIDAndEventID($setID,$eventID){
        $this->db->select("*");
        $this->db->from(TABLE_ANSWERS);
        $this->db->where(COLUMN_SET_ID, $setID);
        $this->db->where(COLUMN_EVENT_ID, $eventID);
        $this->db->order_by(COLUMN_QUESTION_Num);
        $query = $this->db->get();

        return $query->result();
    }

    function queryCommentsBySetIDAndEventID($setID,$eventID){
        $this->db->select("*");
        $this->db->from(TABLE_COMMENT);
        $this->db->where(COLUMN_SET_ID, $setID);
        $this->db->where(COLUMN_EVENT_ID, $eventID);
        $this->db->order_by(COLUMN_COMMENT_ID);
        $query = $this->db->get();

        return $query->result();
    }

    function insertAnswers($setID,$eventID,$questionID,$answer){
        $insertAnswerData=array(
            COLUMN_SET_ID => intval($setID),
            COLUMN_EVENT_ID => intval($eventID),
            COLUMN_QUESTION_ID => intval($questionID),
            COLUMN_QUESTION_ANS => intval($answer)
        );
        $this->db->insert(TABLE_ANSWERS, $insertAnswerData);

    }

    function insertComment($setID,$eventID,$questionID,$comment){
        $insertCommentData=array(
            COLUMN_SET_ID => intval($setID),
            COLUMN_EVENT_ID => intval($eventID),
            COLUMN_COMMENT_ANS => $comment
        );
        $this->db->insert(TABLE_COMMENT, $insertCommentData);
    }


}