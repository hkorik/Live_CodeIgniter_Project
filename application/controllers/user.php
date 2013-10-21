<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends CI_Controller {

	protected $id;
	protected $page = NULL;
	protected $user_logged_in;
	protected $logged_user_info = NULL;
	protected $user_info = NULL;
	protected $register_errors = NULL;
	protected $register_success = NULL;
	protected $signin_errors = NULL;
	protected $notifications = NULL;
	protected $first_entry = NULL;
	protected $user_exists = NULL;
	protected $edit_errors = NULL;
	protected $edit_profile_info = NULL;
	protected $update_success = NULL;
	protected $user_table = NULL;
	protected $edit_user_info = NULL;
	protected $get_user_info = NULL;
	protected $user_profile_info = NULL;
	protected $message_info = NULL;
	protected $comment_info = NULL;
	protected $profile_info = NULL;

	protected function outside_header()
	{
		$this->load->view("outside_header.php", $this->page);
	}

	protected function inside_header()
	{
		$this->load->view("inside_header.php", $this->page);
	}

	protected function get_user_info()
	{
		$this->user_info = $this->session->userdata('user_info');
		//get user info to display once logged in, first setting returned data from database in to session
		$this->load->model('User_model');
		$this->logged_user_info = $this->User_model->get_user_info($this->user_info);
		//set session for logged user info to be able to use logged_user_info in other function when called from anywhere
		$this->session->set_userdata('logged_user_info', $this->logged_user_info);
		$this->set_user_level();
	}

	protected function set_user_level()
	{
		$this->logged_user_info = $this->session->userdata('logged_user_info');
		//check if admin or regular user, and redirect to proper place
		if($this->logged_user_info->user_level != '1')
		{
			$this->logged_user_info->user_status = 'admin';
			$this->session->set_userdata('logged_user_info', $this->logged_user_info);
		}
		else
		{
			$this->logged_user_info->user_status = 'normal';
			$this->session->set_userdata('logged_user_info', $this->logged_user_info);
		}
	}

	public function __construct()
	{
		parent::__construct();
		date_default_timezone_set('America/New_York');
	}
	
	public function index()
	{
		$this->page['title'] = "Home Page";
		$this->outside_header();
		$this->load->view('home.php');
	}

	public function register()
	{
		$this->notifications['register_errors'] = $this->session->flashdata('register_errors');
		$this->page['title'] = "Register";
		$this->outside_header();
		$this->load->view('register.php', $this->notifications);
	}

	public function signin()
	{
		$this->notifications['signin_errors'] = $this->session->flashdata('signin_errors');
		$this->page['title'] = "Sign in Page";
		$this->outside_header();
		$this->load->view('signin.php', $this->notifications);
	}

	public function process_registration()
	{
		$this->load->library('form_validation');
		$this->form_validation->set_rules('first_name', 'First Name', 'alpha|required|xss_clean');
		$this->form_validation->set_rules('last_name', 'Last Name', 'alpha|required|xss_clean');
		$this->form_validation->set_rules('email', 'Email', 'valid_email|required|xss_clean');
		$this->form_validation->set_rules('password', 'Password', 'min_length[8]|required|xss_clean');
		$this->form_validation->set_rules('confirm_password', 'Confirm Password', 'matches[password]|required|xss_clean');

		if($this->form_validation->run() === FALSE)
		{
			$this->register_errors['first_name'] = form_error('first_name');
			$this->register_errors['last_name'] = form_error('last_name');
			$this->register_errors['email'] = form_error('email');
			$this->register_errors['password'] = form_error('password');
			$this->register_errors['confirm_password'] = form_error('confirm_password');
			$this->session->set_flashdata('register_errors', $this->register_errors);
			echo json_encode($this->register_errors);
		}
		else
		{
			//take email and check if user exists
			$this->user_info['email'] = $this->input->post('email');
			//send data to query in model page that will see if this entry exists in database
			$this->load->model('User_model');
			$this->user_exists = $this->User_model->check_user_exist($this->user_info);

			// if someone has that email address
			if($this->user_exists != NULL)
			{
				$this->register_errors['register_error'] = "Error: Email {$this->user_info['email']} is already in use!";
				$this->session->set_flashdata('register_errors', $this->register_errors);
				echo json_encode($this->register_errors);
			}
			else
			{
				$this->load->library('encrypt');
				$encrypted_password = $this->encrypt->encode($this->input->post('password'));
				//set user data into variables to send to database
				$this->user_info['first_name'] = $this->input->post('first_name');
				$this->user_info['last_name'] = $this->input->post('last_name');
				$this->user_info['email'] = $this->input->post('email');
				$this->user_info['password'] = $encrypted_password;
				$this->user_info['created_at'] = date('Y-m-d H:i:s');
				//send data to query in model page that will see if this first entry in database
				$this->load->model('User_model');
				$this->first_entry = $this->User_model->check_first_entry();
				//logic to set admin or user level
				if($this->first_entry != NULL)
				{
					$this->user_info['user_level'] = '1';
				}
				else
				{
					$this->user_info['user_level'] = '9';
				}

				//send data to query in model page that will set data in database
				$this->load->model('User_model');
				$this->User_model->register_user($this->user_info);
				//set user logged in to TRUE so when go's to welcome page will not be redirected to login page
				$this->user_logged_in = 'TRUE';
				$this->session->set_userdata('user_logged_in', $this->user_logged_in);
				//set session for user info to be able to use user_info in other function when called from anywhere
				$this->session->set_userdata('user_info', $this->user_info);
				$this->get_user_info();
				//get result info from function with user_status
				$this->logged_user_info = $this->session->userdata('logged_user_info');
				//log in based on user_status
				if($this->logged_user_info->user_status != 'admin')
				{
					//set the dashboard link to user_dashboard
					$this->page['dashboard_link'] = "/CodeIgniter_Project/dashboard";
					$this->session->set_userdata('dashboard_link', $this->page['dashboard_link']);
					//go to user_dashboard function which will login user and display user dashboard info
					$dashboard_link['link'] = 'dashboard';
					echo json_encode($dashboard_link);
				}
				else
				{
					//set the dashboard link to user_dashboard
					$this->page['dashboard_link'] = "/CodeIgniter_Project/dashboard/admin";
					$this->session->set_userdata('dashboard_link', $this->page['dashboard_link']);
					//go to admin_dashboard function which will login user and display admin dashboard info
					$dashboard_link['link'] = 'dashboard/admin';
					echo json_encode($dashboard_link);
				}
			}
		}
	}

	public function process_signin()
	{
		$this->load->library('form_validation');
		$this->form_validation->set_rules('email', 'Email', 'valid_email|required|xss_clean');
		$this->form_validation->set_rules('password', 'Password', 'min_length[8]|required|xss_clean');

		if($this->form_validation->run() === FALSE)
		{
			$this->signin_errors['email'] = form_error('email');
			$this->signin_errors['password'] = form_error('password');
			$this->session->set_flashdata('signin_errors', $this->signin_errors);
			echo json_encode($this->signin_errors);
		}
		else
		{
			//set user data into variables to get user data with query
			$this->user_info['email'] = $this->input->post('email');
			$this->user_info['password'] = $this->input->post('password');
			//get user info to display once logged in, first setting returned data from database in to session
			$this->load->model('User_model');
			$this->logged_user_info = $this->User_model->get_user_info($this->user_info);
			
			if($this->logged_user_info != NULL)
			{	
				$this->load->library('encrypt');
				$decrypted_password = $this->encrypt->decode($this->logged_user_info->password);

				if($this->user_info['password'] === $decrypted_password)
				{
					$this->user_logged_in = 'TRUE';
					$this->session->set_userdata('user_logged_in', $this->user_logged_in);
					//set session for logged user info to be able to use logged_user_info in other function when called from anywhere
					$this->session->set_userdata('logged_user_info', $this->logged_user_info);
					//go to function which checks user status
					$this->set_user_level();
					//get result info from function with user_status
					$this->logged_user_info = $this->session->userdata('logged_user_info');
					//log in based on user_status
					if($this->logged_user_info->user_status != 'admin')
					{
						//set the dashboard link to user_dashboard
						$this->page['dashboard_link'] = "/CodeIgniter_Project/dashboard";
						$this->session->set_userdata('dashboard_link', $this->page['dashboard_link']);
						//go to user_dashboard function which will login user and display user dashboard info
						$dashboard_link['link'] = 'dashboard';
						echo json_encode($dashboard_link);
					}
					else
					{
						//set the dashboard link to user_dashboard
						$this->page['dashboard_link'] = "/CodeIgniter_Project/dashboard/admin";
						$this->session->set_userdata('dashboard_link', $this->page['dashboard_link']);
						//go to admin_dashboard function which will login user and display admin dashboard info
						$dashboard_link['link'] = 'dashboard/admin';
						echo json_encode($dashboard_link);
					}

				}
				else
				{
					$this->signin_errors['signin_error'] = "Error: The information entered does not match any of our records!";
					$this->session->set_flashdata('signin_errors', $this->signin_errors);
					echo json_encode($this->signin_errors);

				}				
			}
			else
			{
				$this->signin_errors['signin_error'] = "Error: The information entered does not match any of our records!";
				$this->session->set_flashdata('signin_errors', $this->signin_errors);
				echo json_encode($this->signin_errors);

			}
		}
	}

	public function admin_dashboard()
	{
		$this->user_logged_in = $this->session->userdata('user_logged_in');
		$this->logged_user_info = $this->session->userdata('logged_user_info');

		if(!empty($this->user_logged_in) and $this->logged_user_info->user_status != 'normal')
		{
			$this->logged_user_info->user_rows = $this->users_list();
			$this->page['dashboard_link'] = $this->session->userdata('dashboard_link');
			$this->page['title'] = "Admin Dashboard";
			// $this->logged_user_info = $this->session->userdata('logged_user_info');
			$this->inside_header();
			$this->load->view('admin_dashboard.php', $this->logged_user_info);
		}
		else
		{
			redirect(base_url('/user/log_off'));
		}
	}

	public function new_user()
	{
		$this->user_logged_in = $this->session->userdata('user_logged_in');
		$this->logged_user_info = $this->session->userdata('logged_user_info');

		if(!empty($this->user_logged_in) and $this->logged_user_info->user_status != 'normal')
		{
			$this->notifications['register_success'] = $this->session->flashdata('register_success');
			$this->notifications['register_errors'] = $this->session->flashdata('register_errors');
			$this->page['dashboard_link'] = $this->session->userdata('dashboard_link');
			$this->page['title'] = "New User";
			$this->inside_header();
			$this->load->view('new_user.php', $this->notifications);
		}
		else
		{
			redirect(base_url('/user/log_off'));
		}	
	}

	public function process_new_user()
	{
		$this->load->library('form_validation');
		$this->form_validation->set_rules('first_name', 'First Name', 'alpha|required|xss_clean');
		$this->form_validation->set_rules('last_name', 'Last Name', 'alpha|required|xss_clean');
		$this->form_validation->set_rules('email', 'Email', 'valid_email|required|xss_clean');
		$this->form_validation->set_rules('password', 'Password', 'min_length[8]|required|xss_clean');
		$this->form_validation->set_rules('confirm_password', 'Confirm Password', 'matches[password]|required|xss_clean');

		if($this->form_validation->run() === FALSE)
		{
			$this->register_errors['first_name'] = form_error('first_name');
			$this->register_errors['last_name'] = form_error('last_name');
			$this->register_errors['email'] = form_error('email');
			$this->register_errors['password'] = form_error('password');
			$this->register_errors['confirm_password'] = form_error('confirm_password');
			$this->session->set_flashdata('register_errors', $this->register_errors);
			echo json_encode($this->register_errors);
		}
		else
		{
			//take email and check if user exists
			$this->user_info['email'] = $this->input->post('email');
			//send data to query in model page that will see if this entry exists in database
			$this->load->model('User_model');
			$this->user_exists = $this->User_model->check_user_exist($this->user_info);

			// if someone has that email address
			if($this->user_exists != NULL)
			{
				$this->register_errors['register_error'] = "Error: Email {$this->user_info['email']} is already in use!";
				$this->session->set_flashdata('register_errors', $this->register_errors);
				echo json_encode($this->register_errors);
			}
			else
			{
				$this->load->library('encrypt');
				$encrypted_password = $this->encrypt->encode($this->input->post('password'));
				//set user data into variables to send to database
				$this->user_info['first_name'] = $this->input->post('first_name');
				$this->user_info['last_name'] = $this->input->post('last_name');
				$this->user_info['email'] = $this->input->post('email');
				$this->user_info['password'] = $encrypted_password;
				$this->user_info['created_at'] = date('Y-m-d H:i:s');
				//add success message for new user page
				$this->register_success['message'] = "New user successfully created";
				$this->session->set_flashdata('register_success', $this->register_success);
				//send data to query in model page that will see if this first entry in database
				$this->load->model('User_model');
				$this->first_entry = $this->User_model->check_first_entry();
				//logic to set admin or user level
				if($this->first_entry != NULL)
				{
					$this->user_info['user_level'] = '1';
				}
				else
				{
					$this->user_info['user_level'] = '9';
				}
				//send data to query in model page that will set data in database
				$this->load->model('User_model');
				$this->User_model->register_user($this->user_info);
				//go to new_user function which will display success message
				echo json_encode($this->register_success);
			}
		}
	}

	public function edit_user()
	{
		$this->user_logged_in = $this->session->userdata('user_logged_in');
		$this->logged_user_info = $this->session->userdata('logged_user_info');
		
		if(!empty($this->user_logged_in)  and $this->logged_user_info->user_status != 'normal')
		{
			$this->id = $_SERVER['REQUEST_URI'];
			$this->id = explode("/", $this->id);
			$this->session->set_userdata('edit_id', $this->id[4]);
			$this->user_info['email'] = $this->input->post('email');
			$this->load->model('User_model');
			$this->edit_user_info = $this->User_model->get_user_info($this->user_info);
			$this->notifications['edit_users_info'] = $this->edit_user_info;			
			$this->notifications['update_success'] = $this->session->flashdata('update_success');
			$this->notifications['edit_errors'] = $this->session->flashdata('edit_errors');
			$this->page['dashboard_link'] = $this->session->userdata('dashboard_link');
			$this->page['title'] = "Edit User";
			$this->inside_header();
			$this->load->view('edit_user.php', $this->notifications);	
		}
		else
		{
			redirect(base_url('/user/log_off'));
		}
	}

	public function process_edit_user_info()
	{
		$id['id'] = $this->session->userdata('edit_id');
		$this->load->library('form_validation');
		$this->form_validation->set_rules('first_name', 'First Name', 'alpha|required|xss_clean');
		$this->form_validation->set_rules('last_name', 'Last Name', 'alpha|required|xss_clean');
		$this->form_validation->set_rules('email', 'Email', 'valid_email|required|xss_clean');

		if($this->form_validation->run() === FALSE)
		{
			$this->edit_errors['first_name'] = form_error('first_name');
			$this->edit_errors['last_name'] = form_error('last_name');
			$this->edit_errors['email'] = form_error('email');
			$this->session->set_flashdata('edit_errors', $this->edit_errors);
			echo json_encode($this->edit_errors);
		}
		else
		{
			//get current edit user info - to be able to allow admin to select users existing own email and only not allow to select other already existent emails.
			$this->load->model('User_model');
			$users_edit_info = $this->User_model->get_user_profile_info($id);			
			//take email and check if user exists
			$this->user_info['email'] = $this->input->post('email');
			//send data to query in model page that will see if this entry exists in database
			$this->user_exists = $this->User_model->check_user_exist($this->user_info);

			// if someone has that email address and that email address is not the one of the person we are editing
			if($this->user_exists != NULL and $this->user_exists->email != $users_edit_info->email)
			{
					$this->register_errors['register_error'] = "Error: Email {$this->user_info['email']} is already in use!";
					$this->session->set_flashdata('register_errors', $this->register_errors);
					echo json_encode($this->register_errors);
			}
			else
			{
				if($this->input->post('user_level') == 'Admin')
				{
					$this->edit_user_info['user_level'] = '9';
				}
				else
				{
					$this->edit_user_info['user_level'] = '1';
				}
				//set user data into variables to send to database
				$this->edit_user_info['id'] = $this->input->post('id');
				$this->edit_user_info['first_name'] = $this->input->post('first_name');
				$this->edit_user_info['last_name'] = $this->input->post('last_name');
				$this->edit_user_info['email'] = $this->input->post('email');
				$this->edit_user_info['updated_at'] = date('Y-m-d H:i:s');
				//add success message for new user page
				$this->update_success['info_message'] = "Information successfully updated";
				$this->session->set_flashdata('update_success', $this->update_success);
				//send data to query in model page that will set data in database
				$this->load->model('User_model');
				$this->User_model->update_profile_info($this->edit_user_info);
				//go to new_user function which will display success message
				echo json_encode($this->update_success);
			}
		}
	}

	public function process_edit_user_pw()
	{
		$id = $this->session->userdata('edit_id');
		$this->load->library('form_validation');
		$this->form_validation->set_rules('password', 'Password', 'min_length[8]|required|xss_clean');
		$this->form_validation->set_rules('confirm_password', 'Confirm Password', 'matches[password]|required|xss_clean');

		if($this->form_validation->run() === FALSE)
		{
			$this->edit_errors['password'] = form_error('password');
			$this->edit_errors['confirm_password'] = form_error('confirm_password');
			$this->session->set_flashdata('edit_errors', $this->edit_errors);
			echo json_encode($this->edit_errors);
		}
		else
		{
			//load library to encrypt password
			$this->load->library('encrypt');
			$encrypted_password = $this->encrypt->encode($this->input->post('password'));
			//set user data into variables to send to database
			$this->edit_user_info['id'] = $this->input->post('id');
			$this->edit_user_info['password'] = $encrypted_password;
			$this->edit_user_info['updated_at'] = date('Y-m-d H:i:s');
			//add success message for new user page
			$this->update_success['pw_message'] = "Password successfully updated";
			$this->session->set_flashdata('update_success', $this->update_success);
			//send data to query in model page that will set data in database
			$this->load->model('User_model');
			$this->User_model->update_profile_info($this->edit_user_info);
			//go to new_user function which will display success message
			echo json_encode($this->update_success);
		}
	}

	public function user_dashboard()
	{
		$this->user_logged_in = $this->session->userdata('user_logged_in');

		if(!empty($this->user_logged_in))
		{
			$this->user_table['user_rows'] = $this->users_list();
			$this->page['dashboard_link'] = $this->session->userdata('dashboard_link');
			$this->page['title'] = "User Dashboard";
			$this->inside_header();
			$this->load->view('user_dashboard.php', $this->user_table);
		}
		else
		{
			redirect(base_url('/user/log_off'));
		}		
	}

	public function users_list()
	{
		$this->load->model('User_model');
		return $this->User_model->get_users_list();
	}

	public function user_profile()
	{
		$this->user_logged_in = $this->session->userdata('user_logged_in');

		if(!empty($this->user_logged_in))
		{
			$this->logged_user_info = $this->session->userdata('logged_user_info');
			$this->notifications['logged_user_id'] = $this->logged_user_info->id;
			
			$this->id = $_SERVER['REQUEST_URI'];
			$this->id = explode("/", $this->id);
			$this->get_user_info['id'] = $this->id[4];
			$this->load->model('User_model');
			$this->user_profile_info = $this->User_model->get_user_profile_info($this->get_user_info);

			$this->notifications['html'] = "";
			
			//this get's all the messages for this spacific users profile, and sets to variable to pass to view page
			$messages = $this->get_messages($this->get_user_info);
			//get the comments for each of the messages on this users profile - already only has the meeages from this users profile because of the get_message function  
			foreach($messages as $message) 
			{
				$this->notifications['html'] .= "
								<h4 class='clear float_left'>{$message['first_name']} {$message['last_name']} wrote</h4>
							    <p class='date float_right'>";
				
				$now = date('F jS Y g:i:s A');
				$date1 = new DateTime($message['created_at']);
				$date2 = new DateTime($now);
				$interval = $date1->diff($date2);

				if($interval->d >= 7) 
				{
					$thedate = explode(" ", $message['created_at']);
					$this->notifications['html'] .="{$thedate[0]} {$thedate[1]} {$thedate[2]}";
				}
				elseif($interval->d >= 2 and $interval->d < 7)
				{
					$this->notifications['html'] .="{$interval->d} days ago";
				}
				elseif($interval->d == 1) 
				{
					$this->notifications['html'] .="{$interval->d} day ago";
				}
				elseif($interval->d == 0 and $interval->h >= 2) 
				{
					$this->notifications['html'] .="{$interval->h} hours ago";
				}
				elseif($interval->h == 1) 
				{
					$this->notifications['html'] .="{$interval->h} hour ago";	
				}
				elseif($interval->h < 1 and $interval->i >= 2) 
				{
					$this->notifications['html'] .="{$interval->i} minutes ago";
				}
				elseif($interval->i == 1)
				{
					$this->notifications['html'] .="{$interval->i} minute ago";
				}
				elseif($interval->i < 1)
				{
					$this->notifications['html'] .="Just now";
				}
					
				$this->notifications['html'] .="</p>
								<div class='clear' id='message_post'>{$message['message']}<br/><br/></div>
								<div id='post_comment' class='float_right'>
								<!-- display comment -->
								<div class='clear'></div>";
				
				$comments = $this->get_comments($message['id']);
				
				if(!empty($comments))
				{				
					foreach($comments as $comment)
					{
						$this->notifications['html'] .= "					
							<h4 class='float_left'>{$comment['first_name']} {$comment['last_name']} wrote</h4>
							<p class='date float_right'>";
							
						$now = date('F jS Y g:i:s A');
						$date1 = new DateTime($comment['created_at']);
						$date2 = new DateTime($now);
						$interval = $date1->diff($date2);

						if($interval->d >= 7) 
						{
							$thedate = explode(" ", $comment['created_at']);
							$this->notifications['html'] .="{$thedate[0]} {$thedate[1]} {$thedate[2]}";
						}
						elseif($interval->d >= 2 and $interval->d < 7)
						{
							$this->notifications['html'] .="{$interval->d} days ago";
						}
						elseif($interval->d == 1) 
						{
							$this->notifications['html'] .="{$interval->d} day ago";
						}
						elseif($interval->d == 0 and $interval->h >= 2) 
						{
							$this->notifications['html'] .="{$interval->h} hours ago";
						}
						elseif($interval->h == 1) 
						{
							$this->notifications['html'] .="{$interval->h} hour ago";	
						}
						elseif($interval->h < 1 and $interval->i >= 2) 
						{
							$this->notifications['html'] .="{$interval->i} minutes ago";
						}
						elseif($interval->i == 1)
						{
							$this->notifications['html'] .="{$interval->i} minute ago";
						}
						elseif($interval->i < 1)
						{
							$this->notifications['html'] .="Just now";
						}

						$this->notifications['html'] .="</p>
							<div class='clear float_right' id='comment_post'>{$comment['comment']}<br/><br/></div>";
					}
				}

				$this->notifications['html'] .= "
								<!-- post comment -->
								<form class='clear' action='/CodeIgniter_Project/user/post_comment' method='post'>
									<input type='hidden' name='user_id' value='";
				
				if(!empty($this->notifications['logged_user_id'])){  
				
				$this->notifications['html'] .= "{$this->notifications['logged_user_id']}"; 
				
				}
				
				$this->notifications['html'] .= "'/>
									<input type='hidden' name='message_id' value='{$message['id']}' />
									<input type='hidden' name='profile_user_id' value='";
				
				if(!empty($this->user_profile_info)){

				$this->notifications['html'] .= "{$this->user_profile_info->id}";

				}
				
				$this->notifications['html'] .= "'/>
									<textarea class='float_right' name='comment' id='comment' placeholder='Write a comment' rows=3 cols=120></textarea>
									<input class='clear float_right btn green btn-default' type='submit' value='Post' id='message_button'/>
								</form>
						  </div>";
			}
			
			$this->notifications['user_profile_info'] = $this->user_profile_info;
			$this->page['dashboard_link'] = $this->session->userdata('dashboard_link');
			$this->page['title'] = "User Information";
			$this->inside_header();
			$this->load->view('user_profile.php', $this->notifications);
		}
		else
		{
			redirect(base_url('/user/log_off'));
		}		
	}

	public function edit_profile()
	{
		$this->user_logged_in = $this->session->userdata('user_logged_in');

		if(!empty($this->user_logged_in))
		{
			$this->notifications['update_success'] = $this->session->flashdata('update_success');
			$this->notifications['edit_errors'] = $this->session->flashdata('edit_errors');
			$this->page['dashboard_link'] = $this->session->userdata('dashboard_link');
			$this->page['title'] = "Edit Profile";
			$this->inside_header();
			$this->load->view('edit_profile.php', $this->notifications);
		}
		else
		{
			redirect(base_url('/user/log_off'));
		}
	}

	public function process_edit_profile_info()
	{
		$this->load->library('form_validation');
		$this->form_validation->set_rules('first_name', 'First Name', 'alpha|required|xss_clean');
		$this->form_validation->set_rules('last_name', 'Last Name', 'alpha|required|xss_clean');
		$this->form_validation->set_rules('email', 'Email', 'valid_email|required|xss_clean');

		if($this->form_validation->run() === FALSE)
		{
			$this->edit_errors['first_name'] = form_error('first_name');
			$this->edit_errors['last_name'] = form_error('last_name');
			$this->edit_errors['email'] = form_error('email');
			$this->session->set_flashdata('edit_errors', $this->edit_errors);
			echo json_encode($this->edit_errors);
		}
		else
		{
			//get logged in user info - to be able to allow user to select own email and only not allow to select other already existent emails.
			$this->logged_user_info = $this->session->userdata('logged_user_info');
			//take email and check if user exists
			$this->user_info['email'] = $this->input->post('email');
			//send data to query in model page that will see if this entry exists in database
			$this->load->model('User_model');
			$this->user_exists = $this->User_model->check_user_exist($this->user_info);

			// if someone has that email address and the email is not their own (i.e. the person that is logged in and trying to edit his own profile)
			if($this->user_exists != NULL and $this->user_exists->email != $this->logged_user_info->email)
			{
				// if($this->user_exists->email != $this->logged_user_info->email)
				// {
					$this->register_errors['register_error'] = "Error: Email {$this->user_info['email']} is already in use!";
					$this->session->set_flashdata('register_errors', $this->register_errors);
					echo json_encode($this->register_errors);
			}
			else
			{
				$this->logged_user_info = $this->session->userdata('logged_user_info');
				//set user data into variables to send to database
				$this->edit_profile_info['id'] = $this->logged_user_info->id;
				$this->edit_profile_info['first_name'] = $this->input->post('first_name');
				$this->edit_profile_info['last_name'] = $this->input->post('last_name');
				$this->edit_profile_info['email'] = $this->input->post('email');
				$this->edit_profile_info['updated_at'] = date('Y-m-d H:i:s');
				//add success message for new user page
				$this->update_success['info_message'] = "Information successfully updated";
				$this->session->set_flashdata('update_success', $this->update_success);
				//send data to query in model page that will set data in database
				$this->load->model('User_model');
				$this->User_model->update_profile_info($this->edit_profile_info);
				//go to new_user function which will display success message
				echo json_encode($this->update_success);
			}
		}
	}

	public function process_edit_profile_pw()
	{
		$this->load->library('form_validation');
		$this->form_validation->set_rules('password', 'Password', 'min_length[8]|required|xss_clean');
		$this->form_validation->set_rules('confirm_password', 'Confirm Password', 'matches[password]|required|xss_clean');

		if($this->form_validation->run() === FALSE)
		{
			$this->edit_errors['password'] = form_error('password');
			$this->edit_errors['confirm_password'] = form_error('confirm_password');
			$this->session->set_flashdata('edit_errors', $this->edit_errors);
			echo json_encode($this->edit_errors);
		}
		else
		{
			$this->logged_user_info = $this->session->userdata('logged_user_info');
			//load library to encrypt password
			$this->load->library('encrypt');
			$encrypted_password = $this->encrypt->encode($this->input->post('password'));
			//set user data into variables to send to database
			$this->edit_profile_info['id'] = $this->logged_user_info->id;
			$this->edit_profile_info['password'] = $encrypted_password;
			$this->edit_profile_info['updated_at'] = date('Y-m-d H:i:s');
			//add success message for new user page
			$this->update_success['pw_message'] = "Password successfully updated";
			$this->session->set_flashdata('update_success', $this->update_success);
			//send data to query in model page that will set data in database
			$this->load->model('User_model');
			$this->User_model->update_profile_info($this->edit_profile_info);
			//go to new_user function which will display success message
			echo json_encode($this->update_success);
		}
	}

	public function process_edit_profile_description()
	{
		$this->load->library('form_validation');
		$this->form_validation->set_rules('description', 'Description', 'required|xss_clean');

		if($this->form_validation->run() === FALSE)
		{
			$this->edit_errors['description'] = form_error('description');
			$this->session->set_flashdata('edit_errors', $this->edit_errors);
			echo json_encode($this->edit_errors);
		}
		else
		{
			$this->logged_user_info = $this->session->userdata('logged_user_info');
			//set user data into variables to send to database
			$this->edit_profile_info['id'] = $this->logged_user_info->id;
			$this->edit_profile_info['description'] = $this->input->post('description');
			$this->edit_profile_info['updated_at'] = date('Y-m-d H:i:s');
			//add success message for new user page
			$this->update_success['description_message'] = "Information successfully updated";
			$this->session->set_flashdata('update_success', $this->update_success);
			//send data to query in model page that will set data in database
			$this->load->model('User_model');
			$this->User_model->update_profile_info($this->edit_profile_info);
			//go to new_user function which will display success message
			echo json_encode($this->update_success);
		}
	}

	public function post_message()
	{		
		$this->message_info['user_id'] = $this->input->post('user_id');
		$this->message_info['profile_user_id'] = $this->input->post('profile_user_id');
		$this->message_info['message'] = $this->input->post('message');
		$this->message_info['created_at'] = date('Y-m-d H:i:s');

		$this->load->model('User_model');
		$this->User_model->post_message($this->message_info);
		
		$current_id = $this->input->post('profile_user_id');
		redirect(base_url('/users/show/'. $current_id));
	}

	public function post_comment()
	{
		$current_id = $this->input->post('profile_user_id');
		
		$this->comment_info['user_id'] = $this->input->post('user_id');
		$this->comment_info['message_id'] = $this->input->post('message_id');
		$this->comment_info['comment'] = $this->input->post('comment');
		$this->comment_info['created_at'] = date('Y-m-d H:i:s');

		$this->load->model('User_model');
		$this->User_model->post_comment($this->comment_info);
		
		redirect(base_url('/users/show/'. $current_id));
	}

	public function get_messages($user_info)
	{
		$this->profile_info['profile_user_id'] = $user_info['id'];
		$this->load->model('User_model');
		return $this->User_model->get_messages($this->profile_info);	
	}

	public function get_comments($messages_info)
	{
		$this->profile_info['message_id'] = $messages_info;
		$this->load->model('User_model');
		return $this->User_model->get_comments($this->profile_info);
	}

	public function delete_user()
	{
		$this->user_info['email'] = $this->input->post('email');
		$this->load->model('User_model');
		$this->User_model->delete_user($this->user_info);
		redirect(base_url('/dashboard/admin'));
	}

	public function log_off()
	{
		$this->session->sess_destroy();
		redirect(base_url('/'));
	}

}

/* End of file user.php */
/* Location: /application/controllers/user.php */