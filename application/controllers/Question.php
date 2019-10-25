<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Question extends CI_Controller {
/*

Name:CBT
Date:Start Writing  2018

*/



public function __construct()
{
     parent::__construct();

    $this->load->model(array('question_model','users_model','dashboard_model','pages_model'));
         $this->load->helper(array('url','form','question_helper','page_helper'));
     $this->load->library(array('form_validation','session'));
//user login check here

      if (!isset($this->session->id) || !isset($this->session->logged_in))
       {      show_page('users/login') ;    }


$this->siteName ="CBT";
$this->descriptions ="Examnation Software";
$this->author ="author Name";
$this->keywords ="keywords";


}



public function index($slug = null)
{
  


            $data["title"] = $this->siteName." | Computer Based Test";
            $data["keywords"] =$this->keywords;
            $data["author"] =$this->author;
           $data["descriptions"] =$this->descriptions;
           $data["noindex"] ='<META NAME="ROBOTS" CONTENT="NOINDEX, NOFOLLOW">';
       $data['items'] =   json_decode($this->users_model->get_user_by_id()['subjects']);
       $data['user_details'] = $this->users_model->get_user_by_id();



      $this->load->view('common/headmeta_view',$data);
          $this->load->view('user/common/users_nav_view',$data);
          $this->load->view('common/header_view',$data);
          $this->load->view('user/common/pre_content_view',$data);
           $this->load->view('user/first_view',$data);
           $this->load->view('user/common/post_content_view',$data);
      $this->load->view('common/footer_view',$data);






}

public function start($slug = null)
{
  

            $data["title"] = $this->siteName." | Start";
            $data["keywords"] =$this->keywords;
            $data["author"] =$this->author;
           $data["descriptions"] =$this->descriptions;
           $data["noindex"] ='<META NAME="ROBOTS" CONTENT="NOINDEX, NOFOLLOW">';
       $data['items'] =   json_decode($this->users_model->get_user_by_id()['subjects']);
       $data['user_details'] = $this->users_model->get_user_by_id();

      $this->load->view('common/headmeta_view',$data);
          $this->load->view('user/common/users_nav_view',$data);
          $this->load->view('common/header_view',$data);
          $this->load->view('user/common/pre_content_view',$data);
           $this->load->view('user/first_option_view',$data);
           $this->load->view('user/common/post_content_view',$data);
      $this->load->view('common/footer_view',$data);






}

public function timed_test($slug = null)
{
  

     		$this->form_validation->set_rules("type","Test Type","required");

    if ($this->form_validation->run() == TRUE)
    {
      $acct_type = $this->users_model->get_user_by_id()['acct_type'];
  

       
            $data["title"] = $this->siteName." | Timed Examination";
            $data["keywords"] =$this->keywords;
            $data["author"] =$this->author;
           $data["descriptions"] =$this->descriptions;
           $data["noindex"] ='<META NAME="ROBOTS" CONTENT="NOINDEX, NOFOLLOW">';
         $data['items'] =   json_decode($this->users_model->get_user_by_id()['subjects']);
         $data['user_details'] = $this->users_model->get_user_by_id();


        $this->load->view('common/headmeta_view',$data);
            $this->load->view('user/common/users_nav_view',$data);
            $this->load->view('common/header_view',$data);
            $this->load->view('user/common/pre_content_view',$data);
             $this->load->view('user/pre_test_view',$data);
             $this->load->view('user/common/post_content_view',$data);
        $this->load->view('common/footer_view',$data);
    }//close form validation true block
else{

show_page('question/index');
}


}







public function s0_question_page()
{
if(!isset($_SESSION['start_time']))
{
  $_SESSION['start_time'] = time();
}
  if(!isset($_SESSION['running']))
  {
    show_page('question/index');
  }

  if(isset($_SESSION['timeout']) || isset($_SESSION['submit']))
  {
    show_page('question/submit');
  }

  $v_slug = "question/s0_question_page";
    $this->board_model->insert_view($v_slug);



  $data['subject_items'] =   json_decode($this->users_model->get_user_by_id()['subjects']);


          $data["title"] = $this->siteName." | Examination";
               $data["keywords"] ="";
               $data["author"] =$this->author;
              $data["descriptions"] =$this->descriptions;
           $data["noindex"] ='<META NAME="ROBOTS" CONTENT="NOINDEX, NOFOLLOW">';
           $data['user_details'] = $this->users_model->get_user_by_id();

if(!isset($_SESSION["question_index"]['s0_question_page']) || $_SESSION["question_index"]['s0_question_page'] ==1)
{
  $index_to_use = 0;
  /*$index_to_use is index of question id randomly selected from
corresponding subject session array
*/
}else{

  $index_to_use = $_SESSION["question_index"]['s0_question_page'] - 1;
}


$question_id = $_SESSION['english_ids'][$index_to_use];
$data['count_sub'] =count($_SESSION['english_ids']);



//if click is more than available questions
//in other words if index not exists
if($question_id == NULL)
{
for($i=0;$i < $data['count_sub'];$i++)
{

  $bindex =$i;
}
$question_id = $_SESSION['english_ids'][$bindex];
 $_SESSION["question_index"]['s0_question_page'] = $data['count_sub'] -1;
}




if($data['user_details']['acct_type'] == 'free')
{

  $condition_array  = array('subject' => $data['subject_items'][0],'id' =>
   $question_id,'account_type' => $data['user_details']['acct_type']);


}else{

  $condition_array  = array('subject' => $data['subject_items'][0],'id' =>
   $question_id);


}
$data['question'] = $this->question_model->get_question($condition_array);


$data["q_id"] = $question_id;
  $data["q_index"] = array_search($question_id,$_SESSION['english_ids']);
  //index of question_id in an array;


          $this->load->view('common/headmeta_view',$data);
              $this->load->view('user/common/users_nav_view',$data);
              $this->load->view('common/header_view',$data);
              $this->load->view('user/common/pre_content_view',$data);
               $this->load->view('user/question_view',$data);
               $this->load->view('user/common/post_content_view',$data);
          $this->load->view('common/footer_view',$data);



}

 public function question_act()
{

    if(!isset($_SESSION['user_answers'][$_POST['segment_cont']]))
    {
      $_SESSION['user_answers'][$_POST['segment_cont']] =[];
    }


        if(!isset($_SESSION['correct_answers'][$_POST['segment_cont']]))
        {
          $_SESSION['correct_answers'][$_POST['segment_cont']] =[];
        }


                if(!isset($_SESSION['question_m_id'][$_POST['segment_cont']]))
                {
                  $_SESSION['question_m_id'][$_POST['segment_cont']] =[];
                }


                                if(!isset($_SESSION['question_number'][$_POST['segment_cont']]))
                                {
                                  $_SESSION['question_number'][$_POST['segment_cont']] =[];
                                }

//if timeout
$diff_t =(time() - $_SESSION['start_time']);
if($diff_t >= (($_SESSION['running'] * 60) - 5))
{

  $_SESSION['timeout'] = TRUE;
  $_SESSION['stopped_time'] = time();
}





            if(!isset( $_SESSION["question_index"][$_POST['segment_cont']]))
              {
                 $_SESSION["question_index"][$_POST['segment_cont']] =1;
                                                                      }

//get needed variables
$q_id = $_POST['q_id'];
$q_index = $_POST['q_index'];
$_subject_items =   json_decode($this->users_model->get_user_by_id()['subjects']);
$data['user_details'] = $this->users_model->get_user_by_id();


switch ($_POST['segment_cont']) {
  case 's0_question_page':
$_sub = $_subject_items[0];
    break;
    case 's1_question_page':
    $_sub = $_subject_items[1];
      break;
      case 's2_question_page':
      $_sub = $_subject_items[2];
        break;
  case 's3_question_page':
  $_sub = $_subject_items[3];
    break;

}


if(!empty($_POST['option']))
{
              $condition_array  = array('subject' => $_sub,'id' => $q_id);
               $data['question'] = $this->question_model->get_question($condition_array);
           $correct_answer = $data['question']['answer'];
           $user_answer = $_POST['option'];
$_SESSION['user_answers'][$_POST['segment_cont']][$q_index] = $user_answer;
$_SESSION['correct_answers'][$_POST['segment_cont']][$q_index] = $correct_answer;
$_SESSION['question_m_id'][$_POST['segment_cont']][$q_index] = $q_id;
if(!in_array($q_index +1,$_SESSION['question_number'][$_POST['segment_cont']]))
{
array_push($_SESSION['question_number'][$_POST['segment_cont']],$q_index +1);

}
}




if(isset($_POST['next']))
    {
$_SESSION['count_sub_np'] = $_POST['total_no_q'];
$_SESSION["question_index"][$_POST['segment_cont']] =$_SESSION["question_index"][$_POST['segment_cont']] + 1;


    show_page("question/".$_POST['segment_cont']);



    }

  if(isset($_POST['previous']))
  {
  //mark or save here
/*
get question index from question page
do neccessary arithmetic
save to  session 'question_index[subject question page slug]'
for uniqueness so a click in english page wont affect that of chemistry etc

redirect to question page where  next question will be display
*/
    $_SESSION["question_index"][$_POST['segment_cont']] = $_SESSION["question_index"][$_POST['segment_cont']] -1;


show_page("question/".$_POST['segment_cont']);



}


if(isset($_POST['qno']))
{

    $_SESSION["question_index"][$_POST['segment_cont']] = $_POST['qno'];

show_page("question/".$_POST['segment_cont']);



}

if(isset($_POST['change_sub']))
{

show_page($_POST['change_sub']);



}
//if isset submit
if(isset($_POST['submit']))
{
//mark and show,save

  $_SESSION['submit'] = TRUE;
  $_SESSION['stopped_time'] = time();

show_page('question/submit');



}



}

public function submit()
{
$_SESSION['score'] = 0;

  if(count($_SESSION['user_answers']["s0_question_page"]) !=0)
    {
for($i =0;$i<count($_SESSION['user_answers']["s0_question_page"]);$i++)
{
if($_SESSION['user_answers']["s0_question_page"][$i] ==
$_SESSION['correct_answers']["s0_question_page"][$i])
{
  $_SESSION['s0_score'] = $_SESSION['s0_score'] + 1;
}

}
}else {
  $_SESSION['s0_score'] = 0;

}
  
//save result to db later here

        $data["title"] ="CBT | Results";
        $data["keywords"] ="CBT,jamb,utme,examination,Nigeria,past questions,answer,notes";
        $data["author"] ="Ojeyinka olaniyi philip";
       $data["descriptions"] ="The online Education Platform for Student and Unified Tertiary Matriculation
       Examnation Candidates";
       $data["noindex"] ='<META NAME="ROBOTS" CONTENT="NOINDEX, NOFOLLOW">';
       $data['items'] =   json_decode($this->users_model->get_user_by_id()['subjects']);
       $data['user_details'] = $this->users_model->get_user_by_id();


      $this->load->view('common/headmeta_view',$data);
          $this->load->view('user/common/users_nav_view',$data);
          $this->load->view('common/header_view',$data);
          $this->load->view('user/common/pre_content_view',$data);
          $this->load->view('user/result_view',$data);
          $this->load->view('user/common/post_content_view',$data);
      $this->load->view('common/footer_view',$data);







}


}
