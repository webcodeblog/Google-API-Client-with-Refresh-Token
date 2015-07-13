    <?php
    include 'credentials.php';
    require_once 'src/Google/autoload.php';
    $client = new Google_Client();
    $client->setClientId($gpclientid);
    $client->setClientSecret($gpclientsecret);
    $client->setScopes(array('https://www.googleapis.com/auth/analytics.readonly','https://www.googleapis.com/auth/plus.login'));
    $client->setRequestVisibleActions('http://schema.org/AddAction');
    $client->setAccessType('offline');
    $client->setApprovalPrompt('force');
    ///// Edit below ////////
    $client->setRedirectUri("http://www.webcodeblog.com/projects/analyticsapi/request.php?gp=1");
    if (!isset($_REQUEST['gp'])) {
    $authUrl = $client->createAuthUrl();
    echo('<a href="'. $authUrl .'">Login</a>');
    }
    if (isset($_REQUEST['gp']) && isset($_GET['code'])) {
    $client->authenticate($_GET['code']);
    $refreshToken = $client->getRefreshToken();
    save_token($refreshToken);
    ///// Edit below ////////
    $redirect = "http://www.webcodeblog.com/projects/analyticsapi/client-refresh-token.php";
          header('Location: ' . filter_var($redirect, FILTER_SANITIZE_URL));
    exit();
    }
    ?>
