<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends CI_Controller {

	function __construct() { 
        parent::__construct(); 
         
        // Load form validation ibrary & user model 
        $this->load->library('form_validation'); 
        $this->load->model('user'); 
         
        // User login status 
        $this->isUserLoggedIn = $this->session->userdata('isUserLoggedIn'); 
    }

    public function index(){ 
        if($this->isUserLoggedIn){ 
            redirect('dashboard'); 
        }else{ 
            redirect('login'); 
        } 
    } 

	public function dashboard(){ 
        $data = array(); 
        if($this->isUserLoggedIn){ 
            $con = array( 
                'id' => $this->session->userdata('userId') 
            ); 
            $data['user'] = $this->user->getRows('users',$con); 
            $data['commission'] = $this; 
            $this->load->view('common/header', $data); 
            $this->load->view('dashboard', $data); 
            $this->load->view('common/footer'); 
        }else{ 
            redirect('users/login'); 
        } 
    } 
 
    public function login(){ 
        $data = array(); 
         
        // Get messages from the session 
        if($this->session->userdata('success_msg')){ 
            $data['success_msg'] = $this->session->userdata('success_msg'); 
            $this->session->unset_userdata('success_msg'); 
        } 
        if($this->session->userdata('error_msg')){ 
            $data['error_msg'] = $this->session->userdata('error_msg'); 
            $this->session->unset_userdata('error_msg'); 
        } 
         
        // If login request submitted 
        if($this->input->post('loginSubmit')){ 
            $this->form_validation->set_rules('email', 'Email', 'required|valid_email'); 
            $this->form_validation->set_rules('password', 'password', 'required'); 
             
            if($this->form_validation->run() == true){ 
                $con = array( 
                    'returnType' => 'single', 
                    'conditions' => array( 
                        'email'=> $this->input->post('email'), 
                        'password' => md5($this->input->post('password'))
                    ) 
                ); 
                $checkLogin = $this->user->getRows('users',$con); 
                if($checkLogin){ 
                    $this->session->set_userdata('isUserLoggedIn', TRUE); 
                    $this->session->set_userdata('userId', $checkLogin['id']); 
                    $this->session->set_userdata('refferCode', $checkLogin['reffer_code']); 
                    redirect('dashboard'); 
                }else{ 
                    $data['error_msg'] = 'Wrong email or password, please try again.'; 
                } 
            }else{ 
                $data['error_msg'] = 'Please fill all the mandatory fields.'; 
            } 
        } 
         
        if($this->isUserLoggedIn){ 
        	redirect('dashboard'); 
        }else{ 
	        // Load view 
	        $this->load->view('login', $data); 
        }
    } 

    public function random_strings($length_of_string) 
	{ 
	    $str_result = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890abcdefghijklmnopqrstuvwxyz'; 
	    return substr(str_shuffle($str_result), 0, $length_of_string); 
	} 
 
    public function register(){ 
        $data = $userData = array(); 
         
        // If registration request is submitted 
        if($this->input->post('signupSubmit')){ 
            $this->form_validation->set_rules('user_name', 'User Name', 'required'); 
            $this->form_validation->set_rules('email', 'Email', 'required|valid_email|callback_email_check'); 
            $this->form_validation->set_rules('password', 'password', 'required'); 
            $this->form_validation->set_rules('conf_password', 'confirm password', 'required|matches[password]'); 
 
            $userData = array( 
                'user_name' => strip_tags($this->input->post('user_name')), 
                'email' => strip_tags($this->input->post('email')), 
                'password' => md5($this->input->post('password')),
                'reffer_code' => $this->random_strings(10)
            ); 
 
            if($this->form_validation->run() == true){ 
            	if(!empty($this->input->post('refcode'))){

            		$refuserData = array( 
		                'user_name' => strip_tags($this->input->post('user_name')), 
		                'email' => strip_tags($this->input->post('email')), 
		                'password' => md5($this->input->post('password')),
		                'reffer_code' => $this->random_strings(10),
		                'used_refer_code' => $this->input->post('refcode')
		            ); 

		            $insert = $this->user->insert('users',$refuserData);

            	}else{
            		$insert = $this->user->insert('users',$userData);
            	} 
                if($insert){ 
                    $this->session->set_userdata('success_msg', 'Your account registration has been successful. Please login to your account.'); 
                    redirect('login'); 
                }else{ 
                    $data['error_msg'] = 'Some problems occured, please try again.'; 
                } 
            }else{ 
                $data['error_msg'] = 'Please fill all the mandatory fields.'; 
            } 
        } 
         
        if($this->isUserLoggedIn){ 
        	redirect('dashboard'); 
        }else{ 
            // Posted data 
	        $data['user'] = $userData; 
	        // Load view 
	        $this->load->view('register', $data); 
        }
    } 
     
    public function logout(){ 
        $this->session->unset_userdata('isUserLoggedIn'); 
        $this->session->unset_userdata('userId'); 
        $this->session->sess_destroy(); 
        redirect('login'); 
    } 
     
     
    // Existing email check during validation 
    public function email_check($str){ 
        $con = array( 
            'returnType' => 'count', 
            'conditions' => array( 
                'email' => $str 
            ) 
        ); 
        $checkEmail = $this->user->getRows('users',$con); 
        if($checkEmail > 0){ 
            $this->form_validation->set_message('email_check', 'The given email already exists.'); 
            return FALSE; 
        }else{ 
            return TRUE; 
        } 
    }

    public function getLevelData($user_id=0,$i=1){
                         
		$checkEmail = (object)$this->user->getSingleRows('users',array('id'=>$user_id)); 
		$code = $checkEmail->reffer_code;                         
		$name='';
		$checkUser= $this->user->getAllData('users',array('used_refer_code'=>$code)); 
		foreach ($checkUser as $value) {

			if($i==1){
				$comm = '5';
			}elseif ($i==2) {
				$comm = '4';
			}elseif ($i==3) {
				$comm = '3';
			}elseif ($i==4) {
				$comm = '2';
			}elseif ($i==5) {
				$comm = '1';
			}
			echo '<li>
            <div class="d-flex justify-content-between">
              <div><span class="text-light-green">'.$value['email'].'</span> Level  '.$i.'</div>
              <p>'.$comm.'%</p>
            </div>
          </li>';
		}

		foreach ($checkUser as $value) {
			$user_id=$value['id'];
			$this->getLevelData($user_id,$i+1);
		}
    }


}
