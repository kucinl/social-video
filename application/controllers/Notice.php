<?php
/**
 * Created by PhpStorm.
 * User: kucin
 * Date: 2016/5/19 0019
 * Time: 10:26
 */
class Notice extends CI_Controller {
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->model('user');
        $this->load->model('chat');
        $this->load->model('notice_m');
    }

    public function index()
    {

    }

    public function sent_invite_notice()
    {

        $from_name = $this->input->post('from_name');
        $video_name = $this->input->post('video_name');
        $video_order = $this->input->post('video_order');
        $type = 'invite';
        $from_account = $this->input->post('from_account');
        $to_account = $this->input->post('to_account');
        $title = $from_name.'邀请你观看'.$video_name;
        $content = base_url('video/room/'.$video_order.'/'.$from_account);
        $time = time();
        $data = array(
            'type' => $type,
            'from_account' => $from_account,
            'to_account' => $to_account,
            'type' => $type,
            'title' => $title,
            'content' => $content,
            'time' => $time
        );
        $this->notice_m->insert_notice($data);
    }

    public function get_new_notice()
    {
        $account = $this->input->cookie('account');
        ini_set("max_execution_time", "0");
        $time = time();
        $data = $this->notice_m->get_new_notice($account,$time);
        $i = 0;
        while (!isset($data))
        {
            if($i==80){
                echo json_encode(array('fail'=>"1"));
                exit();
            }
            usleep(500000);     // 休眠500ms释放cpu的占用
            $data = $this->notice_m->get_new_notice($account,$time);
            $i++;
        }
        echo json_encode($data);
        exit();
    }

    public function get_notices($limit)
    {
        $account_i = $this->input->cookie('account');
        $data = $this->notice_m->get_notices($account_i, $limit);
        echo json_encode($data);
    }

}