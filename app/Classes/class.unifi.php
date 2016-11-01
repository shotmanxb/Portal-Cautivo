<?php

namespace App\Classes;

class Unifiapi {
   
   public $user="admin";
   public $password="jmtz1";
   public $site="default";
   public $baseurl="https://192.168.25.1:8443";
   public $is_loggedin=false;
   private $cookies="";
   public $debug=false;
   
   function __construct($user="",$password="",$baseurl="",$site="") {
      if ($user != "") $this->user = $user;
      if ($password != "") $this->password = $password;
      if ($baseurl != "") $this->baseurl = $baseurl;
      if ($site != "") $this->site = $site;
   }
      
   function __destruct() {
      if ($this->is_loggedin) {
         $this->logout();
      }
   }   
   
   /*
   Login to unifi Controller
   */
   
   public function login() {
      $this->cookies="";
      $ch=$this->get_curl_obj();
      curl_setopt($ch, CURLOPT_HEADER, 1);
      curl_setopt($ch, CURLOPT_URL, $this->baseurl."/login");
      curl_setopt($ch, CURLOPT_POSTFIELDS,"login=login&username=".$this->user."&password=".$this->password);
      $content=curl_exec($ch);
      $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
      $header = substr($content, 0, $header_size);
      $body = trim(substr($content, $header_size));
      $code=curl_getinfo($ch,CURLINFO_HTTP_CODE);
      curl_close ($ch);
      preg_match_all('|Set-Cookie: (.*);|U', $header, $results);   
      if (isset($results[1])) {
         $this->cookies = implode(';', $results[1]);
         if (strlen($body) < 10) {
            if (($code >= 200) && ($code < 400)) {
               if (strpos($this->cookies,"unifises") !== FALSE) {
                  $this->is_loggedin=true;
                  }
               }
            }
         }
      return $this->is_loggedin;
   }
   public function loginv4() {
      $this->cookies="";
      $ch=$this->get_curl_obj();
      curl_setopt($ch, CURLOPT_HEADER, 1);
      curl_setopt($ch, CURLOPT_URL, $this->baseurl."/api/login");
      curl_setopt($ch, CURLOPT_POSTFIELDS,json_encode(array("username" => $this->user, "password" =>$this->password)).":");
      $content=curl_exec($ch);
      $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
      $header = substr($content, 0, $header_size);
      $body = trim(substr($content, $header_size));
      $code=curl_getinfo($ch,CURLINFO_HTTP_CODE);
      curl_close ($ch);
      preg_match_all('|Set-Cookie: (.*);|U', $header, $results);   
      if (isset($results[1])) {
         $this->cookies = implode(';', $results[1]);
         if (!empty($body)) {
            if (($code >= 200) && ($code < 400)) {
               if (strpos($this->cookies,"unifises") !== FALSE) {
                  $this->is_loggedin=true;
                  }
               }
            }
         }
      return $this->is_loggedin;
   }
   
   /*
   Logout from unifi Controller
   */
   public function logout() {
      if (!$this->is_loggedin) return false;
      $return=false;
      $content=$this->exec_curl($this->baseurl."/logout");
      $this->is_loggedin=false;
      $this->cookies="";
      return $return;   
      }
   public function logoutv4() {
      if (!$this->is_loggedin) return false;
      $return=false;
      $content=$this->exec_curl($this->baseurl."/api/logout");
      $this->is_loggedin=false;
      $this->cookies="";
      return $return;   
      }


   /*
   Authorize a mac address
   paramater <mac address>,<minutes until expires from now>
   return true on success 
   */
   public function authorize_guest($mac,$minutes,$ap_mac = NULL) {
      $mac=strtolower($mac);
      if (!$this->is_loggedin) return false;
      $return=false;
      $content=$this->exec_curl($this->baseurl."/api/s/".$this->site."/cmd/stamgr","json={'cmd':'authorize-guest', 'mac':'".$mac."', 'minutes':".$minutes.", '$ap_mac':'".$ap_mac."' }");
      $content_decoded=json_decode($content);
      if (isset($content_decoded->meta->rc)) {
         if ($content_decoded->meta->rc == "ok") {
            $return=true;
         }      
      }
      return $return;   
   }  

   /*
   unauthorize a mac address
   paramater <mac address>
   return true on success 
   */
   public function unauthorize_guest($mac) {
      $mac=strtolower($mac);
      if (!$this->is_loggedin) return false;
      $return=false;
      $content=$this->exec_curl($this->baseurl."/api/s/".$this->site."/cmd/stamgr","json={'cmd':'unauthorize-guest', 'mac':'".$mac."'}");
      $content_decoded=json_decode($content);
      if (isset($content_decoded->meta->rc)) {
         if ($content_decoded->meta->rc == "ok") {
            $return=true;
         }      
      }
      return $return;   
   }  

   /*
   reconnect a client
   paramater <mac address>
   return true on success 
   */
   public function reconnect_sta($mac) {
      $mac=strtolower($mac);
      if (!$this->is_loggedin) return false;
      $return=false;
      $content=$this->exec_curl($this->baseurl."/api/s/".$this->site."/cmd/stamgr","json={'cmd':'kick-sta', 'mac':'".$mac."'}");
      $content_decoded=json_decode($content);
      if (isset($content_decoded->meta->rc)) {
         if ($content_decoded->meta->rc == "ok") {
            $return=true;
         }      
      }
      return $return;   
   }  

   /*
   block a client
   paramater <mac address>
   return true on success 
   */
   public function block_sta($mac) {
      $mac=strtolower($mac);
      if (!$this->is_loggedin) return false;
      $return=false;
      $content=$this->exec_curl($this->baseurl."/api/s/".$this->site."/cmd/stamgr","json={'cmd':'block-sta', 'mac':'".$mac."'}");
      $content_decoded=json_decode($content);
      if (isset($content_decoded->meta->rc)) {
         if ($content_decoded->meta->rc == "ok") {
            $return=true;
         }      
      }
      return $return;   
   }  

   /*
   unblock a client
   paramater <mac address>
   return true on success 
   */
   public function unblock_sta($mac) {
      $mac=strtolower($mac);
      if (!$this->is_loggedin) return false;
      $return=false;
      $content=$this->exec_curl($this->baseurl."/api/s/".$this->site."/cmd/stamgr","json={'cmd':'unblock-sta', 'mac':'".$mac."'}");
      $content_decoded=json_decode($content);
      if (isset($content_decoded->meta->rc)) {
         if ($content_decoded->meta->rc == "ok") {
            $return=true;
         }      
      }
      return $return;   
   }  

   /*
   list guests
   returns a array of guest objects
   */
   public function list_guests() {
      $return=array();
      if (!$this->is_loggedin) return $return;
      $return=array();
      $content=$this->exec_curl($this->baseurl."/api/s/".$this->site."/stat/guest","json={}");
      $content_decoded=json_decode($content);
      if (isset($content_decoded->meta->rc)) {
         if ($content_decoded->meta->rc == "ok") {
            if (is_array($content_decoded->data)) {
               foreach ($content_decoded->data as $guest) {
                  $return[]=$guest;
                  }
               }
         }      
      }
      return $return;   
   }  

   /*
   list vouchers 
   returns a array of voucher objects
   */
   public function get_vouchers($create_time="") {
      $return=array();
      if (!$this->is_loggedin) return $return;
      $return=array();
      $json="";
      if (trim($create_time) != "") {
         $json.="'create_time':".$create_time."";
      }
      $content=$this->exec_curl($this->baseurl."/api/s/".$this->site."/stat/voucher","json={".$json."}");
      $content_decoded=json_decode($content);
      if (isset($content_decoded->meta->rc)) {
         if ($content_decoded->meta->rc == "ok") {
            if (is_array($content_decoded->data)) {
               foreach ($content_decoded->data as $voucher) {
                  $return[]=$voucher;
                  }
               }
         }      
      }
      return $return;   
   }  

   /*
   unblock a client
   paramater <minutes>,<number_of_vouchers_to_create>,<note>,<up>,<down>,<mb>
   returns a array of vouchers codes (Note: without the "-" in the middle)
   */
   public function create_voucher($minutes,$number_of_vouchers_to_create=1,$note="",$up=0,$down=0,$Mbytes=0) {
      $return=array();
      if (!$this->is_loggedin) return $return;
      $json="'cmd':'create-voucher','expire':".$minutes.",'n':".$number_of_vouchers_to_create."";
      if (trim($note) != "") {
         $json.=",'note':'".$note."'";
      }
      if ($up > 0) {
         $json.=",'up':".$up."";
      }
      if ($down > 0) {
         $json.=", 'down':".$down."";
      }
      if ($Mbytes > 0) {
         $json.=", 'bytes':".$Mbytes."";
      }
      $content=$this->exec_curl($this->baseurl."/api/s/".$this->site."/cmd/hotspot","json={".$json."}");
      $content_decoded=json_decode($content);
         if ($content_decoded->meta->rc == "ok") {
            if (is_array($content_decoded->data)) {
               $obj=$content_decoded->data[0];
               foreach ($this->get_vouchers($obj->create_time) as $voucher)  {
                  $return[]=$voucher->code;
                  }
            }
         }
      return $return;   
   }  

   private function exec_curl($url,$data="") {
      $ch=$this->get_curl_obj();
      curl_setopt($ch, CURLOPT_URL, $url);
      if (trim($data) != "") {
         curl_setopt($ch, CURLOPT_POSTFIELDS,$data);
      } else {
         curl_setopt($ch, CURLOPT_POST, FALSE);
      }
      $content=curl_exec($ch);
      if ($this->debug == true) {
         print "---------------------\n<br>\n";
         print $url."\n<br>\n";
         print $data."\n<br>\n";
         print "---------------------\n<br>\n";
         print $content."\n<br>\n";
         print "---------------------\n<br>\n";
         }
      curl_close ($ch);
      return $content;
   }   
      
   private function get_curl_obj() {
      $ch = curl_init();
      curl_setopt($ch, CURLOPT_POST, TRUE);
      curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE); 
      curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
      curl_setopt($ch, CURLOPT_SSLVERSION, 3);
      curl_setopt($ch, CURLOPT_SSLVERSION, 'CURL_SSLVERSION_TLSv1');
      curl_setopt($ch , CURLOPT_RETURNTRANSFER, true);
      if ($this->debug == true) {
         curl_setopt($ch, CURLOPT_VERBOSE, TRUE);    
      }
      if ($this->cookies != "") {
         curl_setopt($ch, CURLOPT_COOKIE,  $this->cookies);
         }
      return $ch;
   }
   
}
