<?php
/**
 * Created by PhpStorm.
 * User: kucin
 * Date: 2016/5/15 0015
 * Time: 2:01
 */
class Site_m extends CI_Model {

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function insert($account, $video_order, $last_time, $watch_time, $score)
    {
        $data = array(
            'account' => $account,
            'video_order' => $video_order,
            'last_time' => $last_time,
            'watch_time' => $watch_time,
            'score' => $score,
        );
        $this->db->insert('history', $data);
    }
    public function get_city_list()
    {
        $query = $this->db->select('city_id, name, province')
            ->get('city_list');
        $arr = $query->result_array();
        $result = array();
        foreach ($arr as $i => $v){
            if(!array_key_exists($v['province'],$result))
                $result[$v['province']] = array();
            array_push($result[$v['province']],$v);
        }
        return $result;
    }
    public function get_career_list()
    {
        $query = $this->db->select('career_id, name')
            ->get('career_list');
        $result = $query->result_array();
        return $result;
    }
    public function get_by_account($account, $limit)
    {
        $condition = array(
            'account' => $account,
        );
        $query = $this->db->select('account, history.video_order, name, last_time, watch_time, score')
            ->from('history')
            ->join('video','video.video_order=history.video_order','LEFT')
            ->where($condition)
            ->order_by('last_time', 'DESC')
            ->limit($limit)
            ->get();
        $result = $query->result_array();
        if (count($result) < 1)
        {
            return NULL;
        }
        return $result;
    }
}