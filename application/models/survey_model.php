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

    function queryAllURLs(){
        $this->db->select('*');
        $this->db->from(TABLE_URL);
        $this->db->order_by(COLUMN_URL_ID);
        $query = $this->db->get();
        return $query->result();
    }

    function queryOpenEvents(){
        $this->db->select('*');
        $this->db->from(TABLE_EVENT);
        $this->db->where(COLUMN_IS_CLOSED,0);
        $this->db->where(COLUMN_IS_ARCHIVED,0);
        $this->db->order_by(COLUMN_EVENT_ID);
        $query = $this->db->get();
        return $query->result();
    }

    function queryNotArchivedEvents(){
        $this->db->select('*');
        $this->db->from(TABLE_EVENT);
        $this->db->where(COLUMN_IS_ARCHIVED,0);
        $this->db->order_by(COLUMN_EVENT_ID);
        $query = $this->db->get();
        return $query->result();
    }

    function queryNotArchivedQuestionSets(){
        $this->db->select('*');
        $this->db->from(TABLE_QUESTION_SET);
        $this->db->where(COLUMN_IS_ARCHIVED,0);
        $this->db->order_by(COLUMN_SET_ID);
        $query = $this->db->get();
        return $query->result();
    }

    function queryArchivedEvents(){
        $this->db->select('*');
        $this->db->from(TABLE_EVENT);
        $this->db->where(COLUMN_IS_ARCHIVED,1);
        $this->db->order_by(COLUMN_EVENT_ID);
        $query = $this->db->get();
        return $query->result();
    }

    function queryArchivedQuestionSets(){
        $this->db->select('*');
        $this->db->from(TABLE_QUESTION_SET);
        $this->db->where(COLUMN_IS_ARCHIVED,1);
        $this->db->order_by(COLUMN_SET_ID);
        $query = $this->db->get();
        return $query->result();
    }

    function queryQuestionSetByDescription($desc){
        $this->db->select("*");
        $this->db->from(TABLE_QUESTION_SET);
        $this->db->where(COLUMN_QUESTION_SET_DESCRIPTION, $desc);
        $query = $this->db->get();

        return $query->row_array();
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

    function queryAnswerCountByQuestionID($questionID){
        $sql = "SELECT ".COLUMN_QUESTION_Num." as questionNum, 
                       ".COLUMN_QUESTION_ID." as questionID,
                       ".COLUMN_QUESTION_ANS." as answer,
                       count(*) as count
                FROM (Select * from ".TABLE_QUESTIONS." where question_id = ?) r NATURAL JOIN ".TABLE_ANSWERS."
                GROUP BY ".COLUMN_QUESTION_ANS.";";
        return $this->db->query($sql, array($questionID))->result();
    }

    function queryAnswerCountByQuestionIDAndEventID($questionID,$eventID){
        $sql = "SELECT ".COLUMN_QUESTION_Num." as questionNum,
                       ".COLUMN_QUESTION_ID." as questionID,
                       ".COLUMN_QUESTION_ANS." as answer,
                       count(*) as count
                FROM (Select * from ".TABLE_QUESTIONS." where question_id = ?) r NATURAL JOIN ".TABLE_ANSWERS."
                WHERE ".COLUMN_EVENT_ID." = ?
                GROUP BY ".COLUMN_QUESTION_ANS.";";
        return $this->db->query($sql, array($questionID,$eventID))->result();
    }
/*
    function queryAnswerCountBySetIDAndEventID($setID,$eventID){
        $this->db->select("count(*)");
        $this->db->from(TABLE_ANSWERS);
        $this->db->where(COLUMN_SET_ID, $setID);
        $this->db->where(COLUMN_EVENT_ID, $eventID);
        $this->db->order_by(COLUMN_QUESTION_Num);
        $query = $this->db->get();

        return $query->result();
    }
*/
    function queryCommentsBySetIDAndEventID($setID,$eventID){
        $this->db->select("*");
        $this->db->from(TABLE_COMMENT);
        $this->db->where(COLUMN_SET_ID, $setID);
        $this->db->where(COLUMN_EVENT_ID, $eventID);
        $this->db->order_by(COLUMN_COMMENT_ID);
        $query = $this->db->get();

        return $query->result();
    }

    function queryCommentsBySetID($setID){
        $this->db->select("*");
        $this->db->from(TABLE_COMMENT);
        $this->db->where(COLUMN_SET_ID, $setID);
        $this->db->order_by(COLUMN_COMMENT_ID);
        $query = $this->db->get();

        return $query->result();
    }

    function queryURLbyURL($url){
        $this->db->select("*");
        $this->db->from(TABLE_URL);
        $this->db->where(COLUMN_URL, $url);
        $query = $this->db->get();

        return $query->row_array();
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

    function insertComment($setID,$eventID,$comment){
        $insertCommentData=array(
            COLUMN_SET_ID => intval($setID),
            COLUMN_EVENT_ID => intval($eventID),
            COLUMN_COMMENT_ANS => $comment
        );
        $this->db->insert(TABLE_COMMENT, $insertCommentData);
    }

    function insertEmail($name,$email,$mobile){
        $insertEmailData=array(
            COLUMN_NAME => $name,
            COLUMN_EMAIL => $email,
            COLUMN_MOBILE => $mobile
        );
        $this->db->insert(TABLE_USER, $insertEmailData);
    }

    function isExistingEmail($email) {
        $this->db->select('*');
        $this->db->from(TABLE_USER);
        $this->db->where(COLUMN_EMAIL, $email);
        $query = $this->db->get();
        $result = $query->result();
        
        return count($result)>=1;
    }

    function isExistingEvent($eventID) {
        $this->db->select('*');
        $this->db->from(TABLE_EVENT);
        $this->db->where(COLUMN_EVENT_ID, $eventID);
        $query = $this->db->get();
        $result = $query->result();

        return count($result)>=1;
    }

    function isExistingSet($setID) {
        $this->db->select('*');
        $this->db->from(TABLE_QUESTION_SET);
        $this->db->where(COLUMN_SET_ID, $setID);
        $query = $this->db->get();
        $result = $query->result();
        return count($result)>=1;
    }

    function isOpenEvent($id){
        $this->db->select('*');
        $this->db->from(TABLE_EVENT);
        $this->db->where(COLUMN_EVENT_ID,$id);
        $this->db->where(COLUMN_IS_CLOSED,0);
        $this->db->where(COLUMN_IS_ARCHIVED,0);
        $this->db->order_by(COLUMN_EVENT_ID);
        $query = $this->db->get();
        $result = $query->result();

        return count($result)>=1;
    }

    function isOpenSet($id){
        $this->db->select('*');
        $this->db->from(TABLE_QUESTION_SET);
        $this->db->where(COLUMN_SET_ID,$id);
        $this->db->where(COLUMN_IS_CLOSED,0);
        $this->db->where(COLUMN_IS_ARCHIVED,0);
        $this->db->order_by(COLUMN_SET_ID);
        $query = $this->db->get();
        $result = $query->result();

        return count($result)>=1;
    }

}