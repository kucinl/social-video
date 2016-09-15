<?php
class Login extends CI_Controller {
    public function index()
    {
        $this->load->helper(array('form', 'url', 'cookie'));
        
        $this->load->library('form_validation');

        $this->form_validation->set_rules('account', 'Username', 'required');
        $this->form_validation->set_rules('pwd', 'Password', 'required');
        $data['titile'] = '登录页';
        if ($this->form_validation->run() == FALSE)
        {
            $this->load->view('login_view',$data);
        }
        else
        {
            $this->load->model('user');
            if($this->user->check_account() == FALSE)
            {
                $this->load->view('login_view',$data);
            }
            else
            {
                $cookie = array(
                    'name'   => 'account',
                    'value'  => $this->input->post('account'),
                    'expire' => '86500',
                );
                $this->input->set_cookie($cookie);
                header('Location: '.base_url().'video');
            }
            
        }
    }
    public function logout ()
    {
        $this->load->helper(array('url', 'cookie'));
        delete_cookie('account');
        redirect('login');
    }

}