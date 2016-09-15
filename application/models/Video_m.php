<?php
/**
 * Created by PhpStorm.
 * User: kucin
 * Date: 2016/5/13 0013
 * Time: 14:56
 */
class Video_m extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function get_videos()
    {
        $query = $this->db->select('video_order, name, address')
            ->get('video');
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
    }
    public function get_video_by_order($video_order)
    {
        $condition = array(
            'video_order =' => $video_order,
        );
        $query = $this->db->select('video_order, name, address')
            ->where($condition)
            ->get('video');
        if ($query->num_rows() > 0) {
            return $query->row_array();
        }
    }
    public function get_video_by_name($name)
    {
        $condition = array(
            'name ' => $name,
        );
        $query = $this->db->select('video_order, name, address')
            ->like($condition)
            ->get('video');
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
    }
}