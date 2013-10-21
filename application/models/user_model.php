<?php

class User_model extends CI_Model {

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }

    function check_first_entry()
    {
        return $this->db->query("SELECT * FROM users WHERE id = '1'")->row();
    }

    function check_user_exist($user_info)
    {
        return $this->db->query("SELECT * FROM users WHERE email = '{$user_info['email']}'")->row();
    }

    function register_user($user_info)
    {
        $this->db->insert('users', $user_info);
    }

    function get_user_info($user_info)
    {
        return $this->db->query("SELECT * FROM users WHERE email = '{$user_info['email']}'")->row();
    }

    function get_user_profile_info($user_info)
    {
        return $this->db->query("SELECT id, first_name, last_name, email, description, DATE_FORMAT(created_at,'%M %D %Y') as created_at_date, TIME_FORMAT(created_at, '%l:%i %p') as created_at_time FROM users WHERE id = '{$user_info['id']}'")->row();
    }

    function update_profile_info($edit_info)
    {
        $this->db->where('id', $edit_info['id']);
        $this->db->update('users', $edit_info);
    }

    function get_users_list()
    {
        return $this->db->query("SELECT id, first_name, last_name, email, DATE_FORMAT(created_at,'%M %D %Y') as created_at_date, TIME_FORMAT(created_at, '%l:%i %p') as created_at_time, user_level 
                                FROM users")->result_array();
    }

    function post_message($message_info)
    {
        $this->db->insert('messages', $message_info);
    }

    function post_comment($comment_info)
    {
        $this->db->insert('comments', $comment_info);
    }

    function get_messages($profile_info)
    {
        return $this->db->query("SELECT t1.first_name, t1.last_name, t2.id, t2.message, DATE_FORMAT(t2.created_at,'%M %D %Y %r') as created_at 
                                 FROM messages AS t2 
                                 LEFT JOIN users AS t1 
                                 ON t1.id = t2.user_id
                                 WHERE t2.profile_user_id = '{$profile_info['profile_user_id']}'
                                 ORDER BY t2.created_at DESC")->result_array();
    }

    function get_comments($profile_info)
    {
        return $this->db->query("SELECT t1.comment, t1.message_id, DATE_FORMAT(t1.created_at, '%M %D %Y %r') as created_at, 
                                        t3.first_name, t3.last_name FROM comments as t1 
                                        LEFT JOIN messages as t2 ON t1.message_id = t2.id 
                                        LEFT JOIN users as t3 ON t3.id = t1.user_id 
                                        WHERE t1.message_id = {$profile_info['message_id']} 
                                        ORDER BY t2.created_at ASC")->result_array();
    }

    function delete_user($user_info)
    {
        $this->db->query("DELETE FROM users WHERE email = '{$user_info['email']}'");
    }
}
/* End of file login_model.php */
/* Location: /application/models/login_model.php */