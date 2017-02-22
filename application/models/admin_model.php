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

    function isValidUser($name, $pass) {
        $sql = "SELECT *
                      FROM ".TABLE_ADMIN."
                      WHERE ".COLUMN_ADMIN_USERNAME." = ? AND ".COLUMN_ADMIN_PASSWORD." = ?";

        $result = $this->db->query($sql, array($name, $pass))->result();
        // If credentials is found.


        return count($result)>=1;
    }

    function queryAdminAccount($name) {
        $this->db->select("*");
        $this->db->from(TABLE_ADMIN);
        $this->db->where(COLUMN_ADMIN_USERNAME, $name);
        $query = $this->db->get();

        return $query->row_array();
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

    function queryURLWithEventAndSet(){
        $sql = "SELECT ".COLUMN_URL_ID.", ".COLUMN_URL.", url.".COLUMN_EVENT_ID.", url.".COLUMN_SET_ID." , s.".COLUMN_QUESTION_SET_DESCRIPTION.", e.".COLUMN_EVENT_NAME." 
                FROM ".TABLE_URL." as url, ".TABLE_EVENT." as e, ".TABLE_QUESTION_SET." as s
                WHERE e.".COLUMN_EVENT_ID." = url.".COLUMN_EVENT_ID." AND s.".COLUMN_SET_ID." = url.".COLUMN_SET_ID."";
        return $this->db->query($sql)->result();
    }

    function insertEvent($name,$date,$location,$isClosed){
        $insertEventData=array(
            COLUMN_EVENT_NAME => $name,
            COLUMN_EVENT_DATE => $date,
            COLUMN_EVENT_LOCATION => $location,
            COLUMN_IS_CLOSED => intval($isClosed)
        );
        $this->db->insert(TABLE_EVENT, $insertEventData);

    }

    function insertURL($URL,$eventID,$setID){
        $insertUrlData=array(
            COLUMN_URL => $URL,
            COLUMN_EVENT_ID => intval($eventID),
            COLUMN_SET_ID => intval($setID)
        );
        $this->db->insert(TABLE_URL, $insertUrlData);

    }
    function insertQuestionSet($setName){
        $insertData=array(
            COLUMN_QUESTION_SET_DESCRIPTION => $setName,
        );
        $this->db->insert(TABLE_QUESTION_SET, $insertData);

    }
    function insertQuestion($question,$questionNum,$setID){
        $insertData=array(
            COLUMN_QUESTION_ACT => $question,
            COLUMN_QUESTION_Num => intval($questionNum),
            COLUMN_SET_ID => intval($setID)

        );
        $this->db->insert(TABLE_QUESTIONS, $insertData);

    }

    function isExistingURL($url){
        $this->db->select('*');
        $this->db->from(TABLE_URL);
        $this->db->where(COLUMN_URL,$url);
        $query = $this->db->get();
        return count($query->result())>=1;

    }
    function isExistingQuestionSet($set){
        $this->db->select('*');
        $this->db->from(TABLE_QUESTION_SET);
        $this->db->where(COLUMN_QUESTION_SET_DESCRIPTION,$set);
        $query = $this->db->get();
        return count($query->result())>=1;

    }


}