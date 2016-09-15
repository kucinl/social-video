<?php
class Video extends CI_Controller {
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->model('user');
        $this->load->model('chat');
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
        if(!isset($data))
        {
             header('Location: '.base_url().'login');
        }
        $data['title'] = '视频主页';
        $data['video_list'] = $this->video_m->get_videos();
        $data['recommend_list'] = $this->user->get_recommend_list($account, 10);
        $this->load->view('video_index_view',$data);
    }
    
    public function room($order,$room_account)
    {
        $account = $this->input->cookie('account');
        if(!isset($account))
        {
             header('Location: '.base_url().'login');
        }
        $data = $this->user->get_user_info($account);
        if(!isset($data))
        {
             header('Location: '.base_url().'login');
        }
        $data['title'] = $data['nick_name'].'的视频房';
        $data['order'] = $order;
        $data['room_account'] = $room_account;
        $data['video'] = $this->video_m->get_video_by_order($order);
        $data['friend_list'] =  $this->user->get_friend_list($account);
        $f_address = 'docs/video/json/'.$order.'_'.$room_account.'.json';
        if(!file_exists($f_address))
        {
            $j_file = fopen($f_address,'w');
            $j_array = array('name'=>$data['nick_name'],'is_play'=>0,'v_time'=>0,'m_time'=>time());
            $j_txt = json_encode($j_array);
            fwrite($j_file, $j_txt);
        }
        $this->load->view('video_room_view',$data);
    }
    
    public function insert_chat($order,$account)
    {
        $time = time();
        $this->chat->insert_chat($order,$account,$time);      
    }
    public function get_new_chat($order,$account)
    {
        ini_set("max_execution_time", "0");
        $time = time();
        $data = $this->chat->get_new_chat($order,$account,$time);
        $i = 0;
        while (!isset($data))
        {
            if($i==80){
                echo json_encode(array('fail'=>"1"));
                exit();
            }
            usleep(500000);     // 休眠500ms释放cpu的占用
            clearstatcache();  // 清除文件状态缓存
            $data = $this->chat->get_new_chat($order,$account,$time);
            $i++;
            }
        $response = array();
        $i=0;
        foreach ($data as $row)
        {
            $response[$i]['time'] = $row['time'];
            $response[$i]['name'] = $row['name'];
            $response[$i]['content'] = $row['content'];       
            $i++;
        }
        echo json_encode($response);
        exit();
    }
    public function get_play_progress($order,$room_account)
    {        
        // 设置请求运行时间不限制，解决因为超过服务器运行时间而结束请求
        ini_set("max_execution_time", "0");

        $filename  = 'docs/video/json/'.$order.'_'.$room_account.'.json';

        $lastmodif    = time();
        clearstatcache();  // 清除文件状态缓存
        $currentmodif = filemtime($filename);

        /* 如果当前返回的文件修改unix时间戳小于或等于上次的修改时间，
         * 表明文件没有更新不需要推送消息
         * 如果当前返回的文件修改unix时间戳大于上次的修改时间
         * 表明文件有更新需要输出修改的内容作为推送消息
         */
        $i = 0;
        while ($currentmodif <= $lastmodif)
        {
            if($i==80){
                echo json_encode(array('fail'=>"1"));
                exit();
            }
            usleep(500000);     // 休眠500ms释放cpu的占用
            clearstatcache();  // 清除文件状态缓存
            $currentmodif = filemtime($filename);
            $i++;
        }

        // 推送信息处理(需要推送说明文件有更改，推送信息包含本次修改时间、内容)
        $response = file_get_contents($filename);
        echo $response;
        flush();
        exit();
    }
    public function set_play_progress($order,$room_account)
    {        
        $f_address  = 'docs/video/json/'.$order.'_'.$room_account.'.json';
        $name = $this->input->post('name');
        $v_time = floatval($this->input->post('v_time'));
        $m_time = floatval($this->input->post('m_time'));
        $is_play = $this->input->post('is_play');
        if($is_play == 'true')
        {
            $is_play = 1;
        }else
        {
            $is_play = 0;
        }
        clearstatcache();  // 清除文件状态缓存
        $j_file = fopen($f_address,'w');
        $j_array = array('name'=>$name,'is_play'=>$is_play,'v_time'=>$v_time,'m_time'=>$m_time);
        $j_txt = json_encode($j_array);
        fwrite($j_file, $j_txt);
        flush();
    }

    public function set_new_event($order,$account)
    {
        $time = time();
        $f_address  = 'docs/video/json/'.$order.'_'.$account.'.json';
        $name = $this->input->post('name');
        $content = $this->input->post('content');
        $type = $this->input->post('type');
        $v_time = $this->input->post('v_time');
        $is_play = $this->input->post('is_play');
        if($is_play == 'true')
        {
            $is_play = 1;
        }else
        {
            $is_play = 0;
        }
        $j_file = fopen($f_address,'w');
        $this->chat->set_new_event($order,$account,$type,$name,$content,$time,$v_time,$is_play);
        fwrite($j_file, 'r');
        flush();
    }

    public function get_new_event($order,$room_account)
    {
        ini_set("max_execution_time", "0");
        $filename  = 'docs/video/json/'.$order.'_'.$room_account.'.json';
        $lastmodif    = filemtime($filename);
        clearstatcache();  // 清除文件状态缓存
        $currentmodif = filemtime($filename);
        $i = 0;
        while ($currentmodif <= $lastmodif)
        {
            if($i==80){
                echo json_encode(array('fail'=>"1"));
                exit();
            }
            usleep(500000);     // 休眠500ms释放cpu的占用
            clearstatcache();  // 清除文件状态缓存
            clearstatcache();  // 清除文件状态缓存
            $currentmodif = filemtime($filename);
            $i++;
        }
        $data = $this->chat->get_new_event($order,$room_account,$lastmodif);
        echo json_encode($data);
        exit();
    }
    public function get_today_chat($order,$account)
    {
        $time = time();
        $data = $this->chat->get_today_chat($order,$account,$time);
        echo json_encode($data);
        exit();
    }

}