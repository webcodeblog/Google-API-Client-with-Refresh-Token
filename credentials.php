    <?php
    mysql_connect("<ADDRESS>","<USER>", "<PASSWORD>");
    @mysql_select_db("<DATABASE>") or die("NO DB CONNECTION");
    $gpclientid = '<CLIENT ID>';
    $gpclientsecret = '<CLIENT SECRET>';
    function save_token($token) {
      $exista=0;
        $rez=mysql_query("SELECT * FROM googleapi WHERE ip='".$_SERVER['REMOTE_ADDR']."'");
      while($r=mysql_fetch_array($rez))
      {
    $exista=1;
        }
        if($exista==1) {
          $query = "UPDATE googleapi SET token='" . $token . "' WHERE ip='" . $_SERVER['REMOTE_ADDR'] . "'";
        $result = mysql_query($query);
        } else {
          
            $query = "INSERT INTO googleapi (ip,token) VALUES ('".$_SERVER['REMOTE_ADDR']."', '".$token."')";
        $result = mysql_query($query);}}
    function load_token() { 
      $token="";
        $rez=mysql_query("SELECT * FROM googleapi WHERE ip='".$_SERVER['REMOTE_ADDR']."'");
      while($r=mysql_fetch_array($rez))
      {$token= $r['token'];}
      return $token;
    }
    ?>
