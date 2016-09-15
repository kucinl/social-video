<?php
/**
 * Created by PhpStorm.
 * User: kucin
 * Date: 2016/5/21 0021
 * Time: 0:14
 */
class Search extends CI_Controller {
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->model('user');
        $this->load->model('video_m');
    }
    public function index()
    {
        $account = $this->input->cookie('account');
        if(!isset($account))
        {
            header('Location: '.base_url().'login');
        }
        $data = $this->user->get_user_info($account);
        $data['title'] = '搜索';
        $word = $this->input->get('word');
        $data['video_result'] = $this->video_m->get_video_by_name($word);
        $data['user_result'] = $this->user->get_user_info_byname($word);
        $this->load->view('search_result_v',$data);
        //echo json_encode($data);
    }
}