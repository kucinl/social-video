<?php
class Personer extends CI_Controller {
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('function');
        $this->load->model('user');
        $this->load->model('history');
        $this->load->model('notice_m');
        $this->load->model('site_m');
    }
    
    public function index()
    {
        $account = $this->input->cookie('account');
        $this->information($account);
    }
    
    public function information($account)
    {
        $account_i = $this->input->cookie('account');
        $data_i = $this->user->get_user_info($account_i);
        if(!isset($data_i))
        {
             header('Location: '.base_url().'login');
        }
        $data = $data_i;
        $data['title'] = $data_i['nick_name'].'的个人信息';
        $data['account_info'] = $this->user->get_user_info($account);
        $data['city_list'] = $this->site_m->get_city_list();
        $data['career_list'] = $this->site_m->get_career_list();
        $this->load->view('information_view',$data);
    }
    public function friend()
    {
        $account_i = $this->input->cookie('account');
        $data = $this->user->get_user_info($account_i);
        if(!isset($data))
        {
            header('Location: '.base_url().'login');
        }
        $data['title'] = $data['nick_name'].'的好友管理';
        $data['friend_list'] = $this->user->get_friend_list($account_i);
        $this->load->view('friend_v',$data);
    }
    public function history()
    {
        $account_i = $this->input->cookie('account');
        $data = $this->user->get_user_info($account_i);
        if(!isset($data))
        {
             header('Location: '.base_url().'login');
        }
        $data['title'] = $data['nick_name'].'的历史记录';
        $limit = 100;
        $data['history_list'] = $this->history->get_by_account($account_i, $limit);
        $this->load->view('history_view',$data);
    }
    public function notice()
    {
        $account_i = $this->input->cookie('account');
        $data = $this->user->get_user_info($account_i);
        if(!isset($data))
        {
             header('Location: '.base_url().'login');
        }
        $data['title'] = $data['nick_name'].'的消息通知';
        $limit = 100;
        $data['notice_list'] = $this->notice_m->get_notices($account_i, $limit);
        $this->load->view('notice_view',$data);
    }
    public function insert_history($video_order)
    {
        $account = $this->input->cookie('account');
        $room_account = $this->input->post('room_account');
        $watch_time = $this->input->post('time');;
        $last_time = time();
        $score = $this->input->post('score');
        $this->history->insert($account,$room_account,$video_order, $last_time, $watch_time, $score);
    }
    public function get_history($limit)
    {
        $account_i = $this->input->cookie('account');
        $data_i = $this->user->get_user_info($account_i);
        if(!isset($data_i))
        {
            header('Location: '.base_url().'login');
        }
        $data = $this->history->get_by_account($account_i, $limit);
        echo json_encode($data);
    }

    public function update_settings()
    {
        $account = $this->input->cookie('account');

            $data = array(
                'nick_name' => $this->input->post('name'),
                'sex' => $this->input->post('sex'),
                'age' => $this->input->post('age'),
                'city' => $this->input->post('city'),
                'career' => $this->input->post('career')
            );
            $this->user->update_user_info($account, $data);
                redirect('personer');

    }
    public function update_avatar()
    {
        $account = $this->input->cookie('account');
        $config['upload_path'] = './upload/user/avatar';
        $config['allowed_types'] = 'gif|jpg|png';
        //   $config['overwrite'] = true;
        $config['encrypt_name'] = TRUE;
        $config['max_size'] = 1024;

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('avatar_file'))
        {
            echo $this->upload->display_errors();
        }
        else
        {
            $avatar = $this->upload->data('file_name');
        }
        $data = array(
            'i_img' => $avatar,
        );
        $this->user->update_user_info($account, $data);
            redirect('personer');
    }

    public function update_pwd()
    {
        $account = $this->input->cookie('account');
        $old_pwd = $this->input->post('old_pwd');
        $new_pwd = $this->input->post('new_pwd');
        if(!$this->user->update_pwd($account, $old_pwd, $new_pwd)){
            show_message('原密码错误！！');
        }else{
            redirect('personer');
        }
    }

    public function add_friend($account2)
    {
        $account = $this->input->cookie('account');
        $time = time();
        $this->user->add_friend($account, $account2, $time);
        redirect('video');
    }
    public function delete_friend($account2)
    {
        $account = $this->input->cookie('account');
        $this->user->delete_friend($account, $account2);
        redirect('personer/friend');
    }

}