<?php
/**
 * Created by PhpStorm.
 * User: kucin
 * Date: 2016/5/19 0019
 * Time: 14:20
 */
class Notice_m extends CI_Model {

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function insert_notice($data)
    {
        $this->db->insert('notice', $data);
    }

    public function get_all($account)
    {
        $condition = array(
            'account' => $account,
        );
        $query = $this->db->select('account', 'title', 'content', 'time', 'is_read')
            ->where($condition)
            ->order_by('time', 'DESC')
            ->get('notice');
        $result = $query->result_array();
        if (count($result) < 1)
        {
            return NULL;
        }
        return $result;
    }

    public function get_unread($account)
    {
        $condition = array(
            'account' => $account,
            'is_read' => 0
        );
        $query = $this->db->select('account', 'title', 'content', 'time', 'is_read')
            ->where($condition)
            ->order_by('time', 'DESC')
            ->get('notice');
        $result = $query->result_array();
        if (count($result) < 1)
        {
            return NULL;
        }
        return $result;
    }
    public function get_new_notice($account,$time)
    {
        $condition = array(
            'to_account =' => $account,
            'time >' => $time,
        );
        $query = $this->db->select('type,from_account,to_account,title,content,time,is_read')
            ->where($condition)
            ->get('notice');
        $result = $query->result_array();
        if (count($result) < 1)
        {
            return NULL;
        }
        return $result;
    }
    public function get_notices($account, $limit)
    {
        $condition = array(
            'to_account' => $account,
        );
        $query = $this->db->select('type,from_account,to_account,title,content,time,is_read')
            ->where($condition)
            ->limit($limit)
            ->order_by('time', 'DESC')
            ->get('notice');
        $result = $query->result_array();
        if (count($result) < 1)
        {
            return NULL;
        }
        return $result;
    }
}