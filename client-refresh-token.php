    <!DOCTYPE HTML>
    <html><head>
    <script type="text/javascript" src="https://www.google.com/jsapi"</script>
    <title>Google API Client Refresh Token Example</title>
    </head><body>
    <?php    
    include 'credentials.php';
    require_once 'src/Google/autoload.php';
    $gprefreshtoken = load_token();
    $client = new Google_Client();
    $client->setClientId($gpclientid);
    $client->setClientSecret($gpclientsecret);
    echo "Refresh token: ".$gprefreshtoken;
    try {
    $client->refreshToken($gprefreshtoken);
    $client->verifyIdToken();
    $service = new Google_Service_Analytics($client);  
     $accounts = $service->management_accountSummaries->listManagementAccountSummaries();
     
     $projectId="";
       if((isset($_COOKIE['webcodeview-id1'])) && (is_numeric($_COOKIE['webcodeview-id1'])) ) $projectId=$_COOKIE['webcodeview-id1'];
        if((isset($_GET['view-id'])) && (is_numeric($_GET['view-id']))){ setcookie("webcodeview-id1", $_GET['view-id'], time()+60*60*24*365); $projectId=$_GET['view-id'];}
        
        echo '<form action="" method="get">';
                 foreach ($accounts->getItems() as $item) {
        echo "<b>Account:</b> ",$item['name'], "  " , $item['id'], "<br /> \n";
        echo '<select name="view-id">';
        foreach($item->getWebProperties() as $wp) {
        //  echo '-----<b>WebProperty:</b> ' ,$wp['name'], "  " , $wp['id'], "<br /> \n";    
          $views = $wp->getProfiles();
          if (!is_null($views)) {
            foreach($wp->getProfiles() as $view) {
              if(empty($projectId)) $projectId=$view['id'];
              echo '<option value="'.$view['id'].'"'; if($view['id']==$projectId) echo "selected";
              echo '>'.$view['name'].' - '.$wp['name'].'</option>';    
            }  // closes profile
          }
        } // Closes web property
        echo '<input type="submit" value="Set"></select></form>';
    $_params[] = 'date';
    $_params[] = 'date_day';
    $_params[] = 'date_month';
    $_params[] = 'date_year';
    $_params[] = 'visits';
    $_params1[] = 'visits';
    $_params[] = 'pageviews';
    $_params[] = 'bounces';
    $_params[] = 'entrance_bounce_rate';
    $_params[] = 'visit_bounce_rate';
    $_params[] = 'avg_time_on_site';
    $from = date('Y-m-d', time()-14*24*60*60); // 7 days
    $to = date('Y-m-d', time()-24*60*60); // today
    $metrics = 'ga:visits,ga:pageviews,ga:bounces,ga:entranceBounceRate,ga:visitBounceRate,ga:avgTimeOnSite';
    $dimensions = 'ga:date,ga:day,ga:month,ga:year';
    $data = $service->data_ga->get('ga:'.$projectId, $from, $to, $metrics, array('dimensions' => $dimensions));
    echo '   <script type="text/javascript">
          google.load("visualization", "1", {packages:["corechart"]});
          google.setOnLoadCallback(drawChart);
          function drawChart() {
            var data = google.visualization.arrayToDataTable([ ';
     
          echo "['Day','Visits'],";
    foreach($data['rows'] as $row) {
       $dataRow = array();
      
       foreach($_params as $colNr => $column) { 
       
       if($column=='date_day')
       echo "['".$row[$colNr].'';
     if($column=='date_month')
       echo " ".$row[$colNr]."', ";
       if($column=='visits')
       echo "".$row[$colNr].']';
    if($column=='visits') echo ","; 
       }
    }
    echo "]);
            var options = {
              title: 'Visits per day',
              hAxis: {title: 'Day',  titleTextStyle: {color: '#333'}},
              vAxis: {minValue: 0}
          };
            var chart = new google.visualization.AreaChart(document.getElementById('chart_div'));
            chart.draw(data, options);
          }
        </script>";
    echo '<div id="chart_div" style=" height: 400px;"></div>';
      }
    }
    catch (Exception $e) {
    echo('Error '. $e->getMessage());
    }
    ?>
