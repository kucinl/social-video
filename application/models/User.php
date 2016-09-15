<?php
class User extends CI_Model {

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
    
    public function create_account()
    {
        $account = $this->input->post('account');
        $nick_name = $this->input->post('name');
        $pwd = $this->input->post('pwd');
        $md5_pwd = md5($pwd);
        $this->db->query('insert into user (account,nick_name,pwd) values ("'.$account.'","'.$nick_name.'","'.$md5_pwd.'");');
    }
    public function check_account()
    {
        $account = $this->input->post('account');
        $pwd = $this->input->post('pwd');
        $md5_pwd = md5($pwd);
        $query = $this->db->query('select pwd from user where account = "'.$account.'";');
        $row =$query->row();
        if(!isset($row->pwd))
        {
            return FALSE;
        }
        if($md5_pwd != $row->pwd)
        {
            return FALSE;
        }       
         return TRUE;
    }
    public function get_user_info($account)
    {
        $condition = array(
            'account' => $account
        );
        $query = $this->db->select('account,nick_name,i_img,sex,age,city,city_list.name city_name,city_list.province city_province,career,career_list.name career_name')
            ->from('user')
            ->join('city_list','user.city=city_list.city_id','LEFT')
            ->join('career_list','user.career=career_list.career_id','LEFT')
            ->where($condition)
            ->get();
        $row = $query->row_array();
        return $row;
    }
    public function get_user_info_byname($name)
    {
        $condition = array(
            'nick_name' => $name
        );
        $query = $this->db->select('account, nick_name name, i_img avatar')
            ->from('user')
            ->like($condition)
            ->get();
        $row = $query->result_array();
        return $row;
    }

    function update_user_info($account, $data){
        $this->db->where('account',$account)
        ->update('user', $data);
        return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
    }
    function update_pwd($account,$old_pwd,$new_pwd){
        $md5_pwd = md5($old_pwd);
        $query = $this->db->where(array('account'=>$account))
        ->get('user');
        $row =$query->row();
        if(!isset($row->pwd))
        {
            return FALSE;
        }
        if($md5_pwd != $row->pwd)
        {
            return FALSE;
        }
        $this->db->where('account',$account)
        ->update('user', array('pwd'=>md5($new_pwd)));
        return TRUE;
    }
    function update_avatar($avatar,$uid)
    {
        $this->db->where('uid',$uid);
        $this->db->update('users', array('avatar'=>$avatar));
    }
    public function get_recommend_list($account, $limit)
    {
        $condition = array(
            'account1' => $account
        );
        $friends_account =array();
        $friends = $this->get_friend_list($account);
        if($friends != null){
            foreach ($friends as $row)
            {
                array_push($friends_account,$row['account']);
            }
            $query = $this->db->select('account2 account, nick_name name, i_img avatar')
                ->from('recommend')
                ->join('user','account=account2','LEFT')
                ->where($condition)
                ->where_not_in('account', $friends_account)
                ->order_by('score', 'DESC')
                ->limit($limit)
                ->get();
        }else{
            $query = $this->db->select('account2 account, nick_name name, i_img avatar')
                ->from('recommend')
                ->join('user','account=account2','LEFT')
                ->where($condition)
                ->order_by('score', 'DESC')
                ->limit($limit)
                ->get();
        }
        $result = $query->result_array();
        if (count($result) < 1)
        {
            return NULL;
        }
        return $result;
    }
    public function add_friend($account1, $account2, $time)
    {
        $data = array(
            'account1' => $account1,
            'account2' => $account2,
            'time' => $time
        );
        $this->db->insert('friend', $data);
    }
    public function delete_friend($account1, $account2)
    {
        $data = array(
            'account1' => $account1,
            'account2' => $account2
        );
        $this->db->where($data)
        ->delete('friend');
    }
    public function get_friend_list($account)
    {
        $condition = array(
            'account1' => $account
        );
        $query = $this->db->select('account2 account, nick_name name, i_img avatar')
            ->from('friend')
            ->join('user','account=account2','LEFT')
            ->where($condition)
            ->order_by('time', 'DESC')
            ->get();
        $result = $query->result_array();
        if (count($result) < 1)
        {
            return NULL;
        }
        return $result;
    }
}