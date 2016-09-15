<?php
class Chat extends CI_Model {

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
    
    public function get_new_chat($order,$account,$time)
    {
        $name = $this->input->post('name');
        $content = $this->input->post('content');
        $condition = array(
            'video_order =' => $order,
            'account' => $account,
            'time >' => $time,
        );
        $query = $this->db->select('name,content,time')
        ->where($condition)
        ->get('video_chat');
        $result = $query->result_array();
        if (count($result) < 1)
        {
        return NULL;
        }
        return $result;
    }

    public function set_new_event($order,$account,$type,$name,$content,$time,$v_time,$is_play)
    {
        $data = array(
            'type' => $type,
            'video_order' => $order,
            'account' => $account,
            'name' => $name,
            'content' => $content,
            'time' => $time,
            'v_time' => $v_time,
            'is_play' => $is_play
        );
        $this->db->insert('event', $data);
    }
    public function get_new_event($order,$account,$time)
    {
        $condition = array(
            'video_order =' => $order,
            'account' => $account,
            'time >' => $time,
        );
        $query = $this->db->select('type,name,content,time,v_time,is_play')
            ->where($condition)
            ->get('event');
        $result = $query->result_array();
        if (count($result) < 1)
        {
            return array('fail'=>"1");
        }
        return $result;
    }
    public function get_today_chat($order,$account,$time)
    {
        $condition = array(
            'video_order =' => $order,
            'account' => $account,
            'type' => 'chat'
        //    'time >' => $time,
        );
        $query = $this->db->select('type,name,content,time,v_time,is_play')
            ->where($condition)
            ->get('event');
        $result = $query->result_array();
        if (count($result) < 1)
        {
            return NULL;
        }
        return $result;
    }
}