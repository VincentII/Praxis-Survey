<?php

/**
 * Created by PhpStorm.
 * User: Vincent
 * Date: 02/02/2017
 * Time: 14:35
 */
class admin_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        $this->load->database();
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

    function queryAnswerCountByQuestionID($questionID){
        $sql = "SELECT ".COLUMN_QUESTION_Num." as questionNum, 
                       ".COLUMN_QUESTION_ID." as questionID,
                       ".COLUMN_QUESTION_ANS." as answer,
                       count(*) as count
                FROM (Select * from ".TABLE_QUESTIONS." where question_id = ?) r NATURAL JOIN ".TABLE_ANSWERS."
                GROUP BY ".COLUMN_QUESTION_ANS.";";
        return $this->db->query($sql, array($questionID))->row_array();
    }


}