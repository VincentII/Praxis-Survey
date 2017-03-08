<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Display Debug backtrace
|--------------------------------------------------------------------------
|
| If set to TRUE, a backtrace will be displayed along with php errors. If
| error_reporting is disabled, the backtrace will not display, regardless
| of this setting
|
*/
defined('SHOW_DEBUG_BACKTRACE') OR define('SHOW_DEBUG_BACKTRACE', TRUE);

/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/
defined('FILE_READ_MODE')  OR define('FILE_READ_MODE', 0644);
defined('FILE_WRITE_MODE') OR define('FILE_WRITE_MODE', 0666);
defined('DIR_READ_MODE')   OR define('DIR_READ_MODE', 0755);
defined('DIR_WRITE_MODE')  OR define('DIR_WRITE_MODE', 0755);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/
defined('FOPEN_READ')                           OR define('FOPEN_READ', 'rb');
defined('FOPEN_READ_WRITE')                     OR define('FOPEN_READ_WRITE', 'r+b');
defined('FOPEN_WRITE_CREATE_DESTRUCTIVE')       OR define('FOPEN_WRITE_CREATE_DESTRUCTIVE', 'wb'); // truncates existing file data, use with care
defined('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE')  OR define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE', 'w+b'); // truncates existing file data, use with care
defined('FOPEN_WRITE_CREATE')                   OR define('FOPEN_WRITE_CREATE', 'ab');
defined('FOPEN_READ_WRITE_CREATE')              OR define('FOPEN_READ_WRITE_CREATE', 'a+b');
defined('FOPEN_WRITE_CREATE_STRICT')            OR define('FOPEN_WRITE_CREATE_STRICT', 'xb');
defined('FOPEN_READ_WRITE_CREATE_STRICT')       OR define('FOPEN_READ_WRITE_CREATE_STRICT', 'x+b');

/*
|--------------------------------------------------------------------------
| Exit Status Codes
|--------------------------------------------------------------------------
|
| Used to indicate the conditions under which the script is exit()ing.
| While there is no universal standard for error codes, there are some
| broad conventions.  Three such conventions are mentioned below, for
| those who wish to make use of them.  The CodeIgniter defaults were
| chosen for the least overlap with these conventions, while still
| leaving room for others to be defined in future versions and user
| applications.
|
| The three main conventions used for determining exit status codes
| are as follows:
|
|    Standard C/C++ Library (stdlibc):
|       http://www.gnu.org/software/libc/manual/html_node/Exit-Status.html
|       (This link also contains other GNU-specific conventions)
|    BSD sysexits.h:
|       http://www.gsp.com/cgi-bin/man.cgi?section=3&topic=sysexits
|    Bash scripting:
|       http://tldp.org/LDP/abs/html/exitcodes.html
|
*/
defined('EXIT_SUCCESS')        OR define('EXIT_SUCCESS', 0); // no errors
defined('EXIT_ERROR')          OR define('EXIT_ERROR', 1); // generic error
defined('EXIT_CONFIG')         OR define('EXIT_CONFIG', 3); // configuration error
defined('EXIT_UNKNOWN_FILE')   OR define('EXIT_UNKNOWN_FILE', 4); // file not found
defined('EXIT_UNKNOWN_CLASS')  OR define('EXIT_UNKNOWN_CLASS', 5); // unknown class
defined('EXIT_UNKNOWN_METHOD') OR define('EXIT_UNKNOWN_METHOD', 6); // unknown class member
defined('EXIT_USER_INPUT')     OR define('EXIT_USER_INPUT', 7); // invalid user input
defined('EXIT_DATABASE')       OR define('EXIT_DATABASE', 8); // database error
defined('EXIT__AUTO_MIN')      OR define('EXIT__AUTO_MIN', 9); // lowest automatically-assigned error code
defined('EXIT__AUTO_MAX')      OR define('EXIT__AUTO_MAX', 125); // highest automatically-assigned error code


/*TABLES*/
define("TABLE_ADMIN", "admin");
define("TABLE_ANSWERS", "answers");
define("TABLE_COMMENT", "comment");
define("TABLE_EVENT", "event");
define("TABLE_QUESTION_SET", "question_set");
define("TABLE_QUESTIONS", "questions");
define("TABLE_USER", "user");
define("TABLE_URL", "url");
/*end TABLES/

/*Admin COLUMNS*/
define("COLUMN_ADMIN_ID", "admin_ID");
define("COLUMN_ADMIN_USERNAME", "Username");
define("COLUMN_ADMIN_PASSWORD", "password");
define("COLUMN_ADMIN_TYPE", "admin_Type");

/*Event COLUMNS*/
define("COLUMN_EVENT_ID", "event_id");
define("COLUMN_EVENT_NAME", "event_name");
define("COLUMN_EVENT_LOCATION", "event_location");
define("COLUMN_EVENT_DATE","event_date");
define("COLUMN_IS_CLOSED", "is_closed");
define("COLUMN_IS_ARCHIVED", "is_archived");
define("COLUMN_DELETE", "markedfordelete");

/*Comment Columns*/
define("COLUMN_COMMENT_ID", "comment_id");
define("COLUMN_COMMENT_ANS", "comment_ans");

/*Question Set COLUMNS*/
define("COLUMN_SET_ID", "set_id");
define("COLUMN_QUESTION_SET_DESCRIPTION", "question_set_description");

/*Questions COLUMNS*/
define("COLUMN_QUESTION_ID", "question_id");
define("COLUMN_QUESTION_Num", "question_num");
define("COLUMN_QUESTION_ACT", "question_act");

/*Answers COLUMNS*/
define("COLUMN_QUESTION_ANS", "question_ans");
define("COLUMN_ANSWER_ID", "answer_id");

/*User COLUMNS*/
define("COLUMN_USER_ID", "user_id");
define("COLUMN_NAME", "name");
define("COLUMN_EMAIL", "email");
define("COLUMN_MOBILE", "Mobile");

/*URL*/
define("COLUMN_URL_ID", "url_id");
define("COLUMN_URL", "url");

/*ADMIN*/
define("ADMIN_SIGN_IN", "admin_sign_in");
define("ADMIN_SIGN_OUT", "admin_sign_out");
define("ADMIN_REPORTS", "admin_reports");
define("ADMIN_EVENTS", "admin_events");
define("ADMIN_QUESTIONS", "admin_questions");
define("ADMIN_LINKS", "admin_links");
define("ADMIN_EMAILS", "admin_email");
define("ADMIN_ACCOUNT", "admin_account");


define("ADMIN_GET_REPORTS", "getReports");
define("ADMIN_GET_QUESTIONS", "getQuestions");
define("ADMIN_GET_COMMENTS", "getComments");
define("ADMIN_SUBMIT_EVENT", "submitEvent");
define("ADMIN_SUBMIT_URL", "submitURL");
define("ADMIN_SUBMIT_QUESTION_SET", "submitQuestionsSet");
define("ADMIN_UPDATE_EVENTS", "updateEvents");
define("ADMIN_UPDATE_URLS", "updateURLs");
define("ADMIN_UPDATE_QUESTIONS", "updateQuestions");
define("ADMIN_UPDATE_PASSWORD", "updatePassword");
define("ADMIN_CHECK_ANSWERED_SET", "checkAnsweredSet");