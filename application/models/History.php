<?php
/**
 * Created by PhpStorm.
 * User: kucin
 * Date: 2016/5/8 0008
 * Time: 23:15
 */
class History extends CI_Model {

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function insert($account, $room_account,$video_order, $last_time, $watch_time, $score)
    {
        $data = array(
            'account' => $account,
            'room_account' => $room_account,
            'video_order' => $video_order,
            'last_time' => $last_time,
            'watch_time' => $watch_time,
            'score' => $score,
        );
        $this->db->insert('history', $data);
    }
    public function get_newest($video_order,$account)
    {
        $condition = array(
            'video_order =' => $video_order,
            'account' => $account,
        );
        $query = $this->db->select('account, video_order, last_time, watch_time, score')
            ->where($condition)
            ->select_max('last_time')
            ->get('history');
        $result = $query->row_array();
        return $result;
    }
    public function get_by_account($account, $limit)
    {
        $condition = array(
            'account' => $account,
        );
        $query = $this->db->select('account, history.video_order video_order, name, last_time, watch_time, score')
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