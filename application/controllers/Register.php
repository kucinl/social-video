<?php
class Register extends CI_Controller {
    public function index()
    {
        $this->load->helper(array('form', 'url'));
        
        $this->load->library('form_validation');

        $this->form_validation->set_rules('account', 'Account', 'required');
        $this->form_validation->set_rules('name', 'Username', 'required');
        $this->form_validation->set_rules('pwd', 'Password', 'required');
        $data['title'] = '注册页';
        if ($this->form_validation->run() == FALSE)
        {
            $this->load->view('register_view',$data);
        }
        else
        {
            $this->load->model('user');
            $this->user->create_account();
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