<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_Chat extends CI_Model {

    public function getUsers($conditions = array(), $fields = '') {
        if (count($conditions) > 0) {
            $this->db->where($conditions);
        }
        $this->db->from('users');

        $this->db->order_by("users.id_user", "asc");


        if ($fields != '') {
            $this->db->select($fields);
        } else {
            $this->db->select('users.id_user,users.username,users.email,users.is_online');
        }
        $resultt = $this->db->get();

        return $resultt->result();
    }

    public function getOnlineUsers() {
        $queryGet = $this->db->query("SELECT * FROM users ORDER BY username ASC");
        if ($queryGet->num_rows() > 0) {
            return $queryGet->result_array();
        }
    }

    public function heartBeatGet($username) {
        $queryGet = $this->db->query("SELECT * FROM chat WHERE (chat.id_to='$username' AND recd = 0) order by id_chat ASC")->result_array();
        return $queryGet;
    }

    public function heartBeatUpdate($username) {
        $this->db->query("UPDATE chat SET recd = 1 WHERE chat.id_to ='$username' AND recd = 0");
    }

    public function chatInsert($from, $to, $message) {
        $this->db->query("INSERT INTO chat(chat.id_from,chat.id_to,pesan) values ('$from','$to','$message')");
    } 

}

/* End of file M_Chat.php */
