<?php  
class Login extends MY_Controller
{
	public function admin_login()
	{
		$this->load->database();
		$this->load->helper('url');
		$this->load->helper(array('form', 'url'));
		$data = array();
		$this->load->view('admin/login',$data);
		
		
	}

	public function do_login()
	{
		$this->load->database();
		$this->load->model('admin');
		$this->load->helper('url');
		list($username, $password) = array(
			$this->input->get_post('username', TRUE), 
			$this->input->get_post('password', TRUE)
		);
		
		$this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');

        $config = array(
		    array(
		        'field' => 'username',
		        'label' => 'Username',
		        'rules' => 'required',
		        'errors' => array(
		        	'required' => '用户名不能为空'
		        ),
		    ),
		    array(
		        'field' => 'password',
		        'label' => 'Password',
		        'rules' => 'required',
		        'errors' => array(
		            'required' => '密码不能为空'
		        )
		    )
		);

		$this->form_validation->set_rules($config);
		if ($this->form_validation->run() === FALSE)
        {
             foreach($this->set_errors_messge() as $value)
             {
             	if(form_error($value))
             	{
             		echo form_error($value);
             		break;
             	}
             }
        }
        else
        {
        	$check_re = $this->admin->check_account($username, md5($password));
        	if($check_re !== FALSE)
        	{
        		$hash = password_hash(md5($password), PASSWORD_BCRYPT);
	        	if (password_verify($check_re, $hash)) {
	        		echo 'TRUE';
				} else {
				    echo '账号或密码错误';
				}    
        	}
        	else
        	{
        		echo '账号或密码错误';
        	}
        }
	}

	public function set_errors_messge($label = FALSE)
	{
		$message = array('username', 'password');
		if(is_array($label))
		{
			return $message = array_merge($message,$label);
		}
		elseif($label !== FALSE)
		{
			return array_push($message, $label);
		}
		return $message;
	}

}