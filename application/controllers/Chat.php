<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Chat extends CI_Controller {

    
    public function __construct()
    {
        parent::__construct();
        $this->load->model('m_chat');
    }
    
//      ---------------------------------- Chat Switch ---------------------------------------------------------------------
    public function chatswitch()
 
  	{
  		$session_data_user = $this->session->userdata('session_data_user'); // Session Data
  		if (!isset($_SESSION['chatHistory'])) {
  			$_SESSION['chatHistory'] = array(); // session with chat history
  		}
  		if (!isset($_SESSION['openChatBoxes'])) {
  			$_SESSION['openChatBoxes'] = array(); // session with chat boxes opened
  		}
  		switch ($this->input->get('action')):
  		case 'chatheartbeat':
  			$this->chatheartbeat($session_data_user['username']);
  		case 'sendchat':
  			$this->sendChat($session_data_user['username']);
  		case 'closechat':
  			$this->closeChat();
  		case 'startchatsession':
  			$this->startChatSession($session_data_user['username']);
  		default:
  			break;
  		endswitch;
  	}



//      ---------------------------------- Chat Heart Beat ---------------------------------------------------------------------
    public function chatheartbeat($username)

  	{
  		$query[] = $this->m_chat->heartBeatGet($username);
  		$query[] = $this->m_chat->getOnlineUsers();
  		$items = '';
  		$userPhoto = '';
  		$chatBoxes = array();
  		if (!empty($query[0])) {
  			foreach($query[0] as $chat):
  				if (!isset($_SESSION['openChatBoxes'][$chat['id_from']]) && isset($_SESSION['chatHistory'][$chat['id_from']])) {
  					$items = $_SESSION['chatHistory'][$chat['id_from']];
  				}
  				foreach($query[1] as $row1):
  					if ($chat['id_from'] == $row1['username']) { // check for the photo name
  						$userPhoto = $row1['foto_user'];
  					}
  				endforeach;
  				$chat['pesan'] = $this->sanitize($chat['pesan']);
  				//      ---------------------------------- Reply with JSON ---------------------------------------------------
  				$items.= <<<EOD
                                                 {
                              "s": "0",
                              "f": "{$chat['id_from']}",
                              "m": "{$chat['pesan']}",
                              "t": "{$chat['ts_chat']}",
                              "photo":"{$userPhoto}"
                 },
EOD;
  				//      ---------------------------------- End of reply ------------------------------------------------------
  				if (!isset($_SESSION['chatHistory'][$chat['id_from']])) {
  					$_SESSION['chatHistory'][$chat['id_from']] = '';
  				}
  				//      ---------------------------------- Reply with JSON  Chat History --------------------------------------
  				$_SESSION['chatHistory'][$chat['id_from']].= <<<EOD
                                                         {
                              "s": "0",
                              "f": "{$chat['id_from']}",
                              "m": "{$chat['pesan']}",
                              "t": "{$chat['ts_chat']}",
                              "photo":"{$userPhoto}"
                 },
EOD;
  				//      ---------------------------------- End of reply -------------------------------------------------------
  				unset($_SESSION['tsChatBoxes'][$chat['id_from']]);
  				$_SESSION['openChatBoxes'][$chat['id_from']] = $chat['ts_chat'];
  			endforeach;
  		}
  		$this->m_chat->heartBeatUpdate($username);
  		if ($items != '') {
  			$items = substr($items, 0, -1);
  		}
  		header('Content-type: application/json');
  ?>
          {

          "items": [ <?php
  		echo $items; ?> ]
          }

          <?php
  		exit(0);
  	}

//      ---------------------------------- Chat Box Sessions ---------------------------------------------------------------------
public function chatBoxSession($chatbox)

  	{
  		$items = '';
  		if (isset($_SESSION['chatHistory'][$chatbox])) {
  			$items = $_SESSION['chatHistory'][$chatbox];
  		}
  		return $items;
  	}
  	function startChatSession($username)
  	{
  		$items = '';
  		if (!empty($_SESSION['openChatBoxes'])) {
  			foreach($_SESSION['openChatBoxes'] as $chatbox => $void) {
  				$items.= $this->chatBoxSession($chatbox);
  			}
  		}
  		if ($items != '') {
  			$items = substr($items, 0, -1);
  		}
  		header('Content-type: application/json');
  ?>
              {
              "username": "<?php
  		echo $username; ?>",
              "items": [ <?php
  		echo $items; ?>  ]
              }

              <?php
  		exit(0);
  	}


//      ---------------------------------- Chat Box Sent Chat ---------------------------------------------------------------------
public function sendChat($username)

  	{
  		$from = $username;
  		$to = $this->input->post('to');
  		$message = $this->input->post('message');
  		$_SESSION['openChatBoxes'][$to] = date('Y-m-d H:i:s', time());
  		$messagesan = $this->sanitize($message);
  		if (!isset($_SESSION['chatHistory'][$to])) {
  			$_SESSION['chatHistory'][$to] = '';
  		}
  		$_SESSION['chatHistory'][$to].= <<<EOD
  					   {
  			"s": "1",
  			"f": "{$to}",
  			"m": "{$messagesan}"
  	   },
EOD;
  		unset($_SESSION['tsChatBoxes'][$to]);
  		$this->m_chat->chatInsert($from, $to, $message);
  		echo "1";
  		exit(0);
  	}

//      ---------------------------------- Chat Box Close ----------------------------------------------------------------------------
public function closeChat()

  	{
  		unset($_SESSION['openChatBoxes'][$this->input->post('chatbox') ]);
  		echo "1";
  		exit(0);
  	}

//      ---------------------------------- Chat Box Clear chat message ----------------------------------------------------------------

public function sanitize($text)

  	{
  		$text = htmlspecialchars($text, ENT_QUOTES);
  		$text = str_replace("\n\r", "\n", $text);
  		$text = str_replace("\r\n", "\n", $text);
  		$text = str_replace("\n", "<br />", $text);
  		return $text;
  	}
}