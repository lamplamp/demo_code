<?php
class Users extends Controller
{
    function __construct()
    {
		parent::Controller();
    }

    function index()
    {
        // Claims demo home page
		$this->load->view('users/login');
    }

    function auth()
    {
        // Remove <p> tags around error messages
        $this->validation->set_error_delimiters('', '');

        // Set cascading validation rules
		$rules['email']='trim|required|valid_email|xss_clean';
		$rules['password']='trim|required|min_length[6]|xss_clean';

		$this->validation->set_rules($rules);

        $data=array();
		if ($this->validation->run()==FALSE)
		{
			// Validation failed
			$data['error_message']='Please fix errors in fields labeled red:';
			$this->load->view('users/login', $data);
		}
		else
		{
			$this->load->model('user');

			$email=strtolower(trim($this->input->post('email')));
			$password=trim($this->input->post('password'));
			$user=$this->user->authenticate($email, $password);

			if (empty($user))
			{
				$data['error_message']='Invalid Email or password (case sensitive).  Please try again:';
				$this->load->view('users/login', $data);
			}
			else
			{
				$this->session->set_userdata('user_id', $user->id);
				redirect('trips');
			}
		}
    }

    function logout()
    {
		$this->session->sess_destroy();
		redirect('users', 'refresh');
    }

    function register()
    {
		$this->load->view('users/register');
    }

    function edit()
    {
        // Check user_id
        $user_id=$this->session->userdata('user_id');
        if (empty($user_id))
        {
            redirect('users', 'refresh');
		}
		
        $this->load->model('user');
        $data['user']=$this->user->get_user_profile_by_id($user_id);
        $this->load->view('users/edit', $data);
    }

    function create()
    {
        switch ($this->input->post('submit'))
        {
            case 'Create My Account':
                // Remove <p> tags around error messages
                $this->validation->set_error_delimiters('', '');

                // Set cascading validation rules
    	        $rules['first_name']='trim|required|xss_clean';
				$rules['last_name']='trim|required|xss_clean';
				$rules['gender']='required';
				$rules['birthdate']='trim|required|callback_date_format_check|xss_clean';
				$rules['address1']='trim|required|xss_clean';
				$rules['city']='trim|required|xss_clean';
				$rules['state']='trim|required|xss_clean';
				$rules['zip']='trim|required|xss_clean';
				$rules['country']='trim|required|xss_clean';
				$rules['home_phone']='trim|required|xss_clean';
				$rules['email']='trim|required|valid_email|callback_dup_email_check|xss_clean';
				$rules['password']='trim|required|min_length[6]|matches[retyped_password]|xss_clean';
				$rules['retyped_password']='trim|required|min_length[6]|xss_clean';

    	        $this->validation->set_rules($rules);

                $data=array();
				if ($this->validation->run()==FALSE)
				{
					// Validation failed
					$data['error_message']='Please fix errors in fields marked red:';
					$this->load->view('users/register', $data);
				}
				else
				{
					$this->load->model('user');
					$insert_id=$this->user->create();
					if ($insert_id!=-1)
					{
						$this->session->set_userdata('user_id', $insert_id);
						redirect('trips', 'refresh');
					}
					else
					{
						$data['error_message']='System error.  Please try again:';
						$this->load->view('users/register', $data);
					}
				}
                break;
            case 'Cancel':
                redirect('users', 'refresh');
                break;
		}
    }

    function forgot_password()
    {
		$this->load->view('users/forgot_password');
    }

    function retrieve_password()
    {
        switch ($this->input->post('submit'))
        {
            case 'Retrieve My Password':
                // Remove <p> tags around error messages
                $this->validation->set_error_delimiters('', '');

                // Set cascading validation rules
    	        $rules['first_name']='trim|required|xss_clean';
				$rules['last_name']='trim|required|xss_clean';
				$rules['birthdate']='trim|required|callback_date_format_check|xss_clean';
				$rules['zip']='trim|required|xss_clean';
				$rules['email']='trim|required|valid_email|xss_clean';

    	        $this->validation->set_rules($rules);

                $data=array();
				if ($this->validation->run()==FALSE)
				{
					// Validation failed
					$data['error_message']='Please fix errors in fields marked red:';
					$this->load->view('users/forgot_password', $data);
				}
				else
				{
					$this->load->model('user');
						if ($this->user->get_password_by_profile()===FALSE)
						{
							$data['error_message']='No matching record found.  Please try again:';
							$this->load->view('users/forgot_password', $data);
						}
						else
						{
							$data['email']=$this->input->xss_clean(trim($this->input->post('email')));
							$this->load->view('users/sent_password', $data);
						}
				}
                break;
            case 'Cancel':
                redirect('users', 'refresh');
                break;
		}
    }

    function modify()
    {
        // This is a session protected page
        $user_id=$this->session->userdata('user_id');
        if (empty($user_id))
            redirect('users', 'refresh');

        switch ($this->input->post('submit'))
        {
            case 'Update My Profile':
                // Remove <p> tags around error messages
                $this->validation->set_error_delimiters('', '');

                // Set cascading validation rules
    	        $rules['first_name']='trim|required|xss_clean';
				$rules['last_name']='trim|required|xss_clean';
				$rules['gender']='required';
				$rules['birthdate']='trim|required|callback_date_format_check|xss_clean';
				$rules['address1']='trim|required|xss_clean';
				$rules['city']='trim|required|xss_clean';
				$rules['state']='trim|required|xss_clean';
				$rules['zip']='trim|required|xss_clean';
				$rules['country']='trim|required|xss_clean';
				$rules['home_phone']='trim|required|xss_clean';
				// $rules['email']='trim|required|valid_email|xss_clean';
				$rules['password']='trim|required|min_length[6]|matches[retyped_password]|xss_clean';
				$rules['retyped_password']='trim|required|min_length[6]|xss_clean';

    	        $this->validation->set_rules($rules);

                $data=array();
				if ($this->validation->run()==FALSE)
				{
					// Validation failed
					$data['error_message']='Please fix errors in fields marked red:';
					$this->load->view('users/edit', $data);
				}
				else
				{
					// Validation ok
					$this->load->model('user');
					if ($this->user->modify()==FALSE)
					{
						// Fail to update user profile
						$data['error_message']='System error.  Please try again:';
						$this->load->view('users/edit', $data);
					}
					else
					{
						// Update successful
						// redirect('trips', 'refresh');

						$data['good_news']='User profile successfully updated!';

						$this->load->model('user');
						$data['user']=$this->user->get_user_by_id($user_id);
						$this->load->model('trip');
						$data['trips']=$this->trip->get_trips_by_user_id($user_id);
						$this->load->view('trips/home', $data);
					}
				}
                break;
            case 'Cancel':
                redirect('trips', 'refresh');
                break;
		}
    }

    function date_format_check($date)
    {
        if (preg_match("/^\d{1,2}\/\d{1,2}\/\d{4}$/", $date))
        {
            return TRUE;
        }
        else
        {
            $this->validation->set_message('date_format_check', 'Please use mm/dd/yyyy date format.');
            return FALSE;
        }
    }

    function dup_email_check($email)
    {
        // Check if email(account) already exists
		$this->load->model('user');
        if ($this->user->user_exists($email))
        {
            $this->validation->set_message('dup_email_check', 'This Email already has an account.');
            return FALSE;
        }
        else
        {
            return TRUE;
		}
	}
?>
