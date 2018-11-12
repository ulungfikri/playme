<?php
    //category,user_id,title,views,author_name,duration,img_url
function loadJSON($myHITurl){
    if($GLOBALS['debug']){
        echo 'url : '.$myHITurl.PHP_EOL.'<br><br>';
    }
    $ch = curl_init ();
    $timeout = 14; // 100; // set to zero for no timeout
    curl_setopt ( $ch, CURLOPT_URL, $myHITurl );
    curl_setopt ( $ch, CURLOPT_HEADER, 0 );
    curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, 1 );
    curl_setopt ( $ch, CURLOPT_CONNECTTIMEOUT, $timeout );
    curl_setopt ( $ch, CURLOPT_SSL_VERIFYPEER, 0);
    $resp = curl_exec ( $ch );
    if (curl_errno ( $ch )) {
        echo curl_error ( $ch );
        curl_close ( $ch );
        exit ();
    }
    curl_close ( $ch );
    if($GLOBALS['debug']){
        echo 'JSON : '.$resp.PHP_EOL.'<br><br>';
    }
    return $resp;
}

function postData($myHITurl,$data){
    if($GLOBALS['debug']){
        echo 'url : '.$myHITurl.PHP_EOL.'<br><br>';
    }
    $ch = curl_init ();
    $timeout = 10; // 100; // set to zero for no timeout
    curl_setopt ( $ch, CURLOPT_URL, $myHITurl );
    curl_setopt ( $ch, CURLOPT_POST, 1);
    curl_setopt ( $ch, CURLOPT_POSTFIELDS, $data );
    curl_setopt ( $ch, CURLOPT_HEADER, 0);
    curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt ( $ch, CURLOPT_CONNECTTIMEOUT, $timeout );
    curl_setopt ( $ch, CURLOPT_SSL_VERIFYPEER, 0);
    $resp = curl_exec ( $ch );
    if (curl_errno ( $ch )) {
        echo curl_error ( $ch );
        curl_close ( $ch );
        exit ();
    }
    curl_close ( $ch );
    if($GLOBALS['debug']){
        echo 'JSON : '.$resp.PHP_EOL.'<br><br>';
    }
    return $resp;
}

function getData($url,$mode,$showColumns){
    $fields=explode(",",$showColumns);
    $result=loadJSON($url);
    $result=json_decode($result);
    if($GLOBALS['debug']){
        echo 'Struct : ';var_dump($result);echo PHP_EOL.'<br><br>';
        echo 'Fields : ';var_dump($fields);echo PHP_EOL.'<br><br>';
    }

    $no = 0;
    $total = 0;
    $newarr = array();
    foreach ($result as $key => $row) {    
        $newarr[$no]["name"] = $key;
        if(isset($fields[0])){
            $name = isset($row->nb_pageviews) ? $row->nb_pageviews : 0;
        }
    }
    return $data;
}

function titling($title){
    $title = preg_replace('/[^a-z0-9]+/', ' ', strtolower($title));
    $title = trim($title);
    $title = str_replace(" ","-",$title);
    return $title;
}

$debug = false;
$staging = false;
$data1 = "";
if(isset($_REQUEST['debug']))$debug = true;

include_once('app.php');

//error_log(sprintf("server: %s\n", print_r($_SERVER, true)));
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
$domainName = $_SERVER['HTTP_HOST'].'/index.php';
if($debug) echo 'Http Host:'.$_SERVER['HTTP_HOST'].'<br>';
$_GET['appTitle'] = APP_TITLE;
$_GET['appPageName'] = APP_PAGENAME . ' - Home';
$_GET['appNextPageHref'] = '/about.php';
$_GET['appNextPageText'] = 'ABOUT';
$_GET['appSsoVer'] = APP_SSOVERSION;
$_GET['appClientKey'] = MERCHANT_CLIENT_KEY;
$_GET['mncDigitalUrl'] = MNC_DIGITAL_URL;
$_GET['userFullname'] = 'not login yet';
$_GET['userEmail'] = '';
$_GET['username'] = '';

// error_log(sprintf("cookies: %s\n", print_r($_COOKIE, true)));
if(isset($_COOKIE['ZxnsQxZ6IoI22OoX'])) {
    $cuuid = $_COOKIE['ZxnsQxZ6IoI22OoX'];
    $cpath = $_SERVER['DOCUMENT_ROOT']."/data/".$cuuid;
    if($debug) echo 'cuuid:'.$cuuid.'<br>';
    if($debug) echo 'Doc Root:'.$_SERVER['DOCUMENT_ROOT'].'<br>';
    if($debug) echo 'cpath:'.$cpath.'<br>';
    if(file_exists($cpath)) {
        $scallback = file_get_contents($cpath."/callback.json");
        $jcallback = json_decode($scallback);
        if($jcallback != null) {
            if(array_key_exists('profile', $jcallback)) {
                $_GET['username'] = $jcallback->username;
                $sprofile = urldecode($jcallback->profile);
                $jprofile = json_decode($sprofile);
                if($jprofile != null) {
                    $_GET['userFullname'] = $jprofile->firstname . " " . $jprofile->lastname;
                    $_GET['userEmail'] = $jprofile->email;
                    $_GET['gender'] = $jprofile->gender;
                    $_GET['date_of_birth'] = $jprofile->date_of_birth;
                    $_GET['url_profile'] = $jprofile->url_profile;
                    $_GET['address'] = $jprofile->address;
                    $_GET['phone_number'] = $jprofile->phone_number;
                    $_GET['s_id'] = $jprofile->s_id;
                    if($debug) echo 'userFullname:'.$jprofile->firstname . " " . $jprofile->lastname.'<br>';
                    if($debug) echo 'userEmail:'.$jprofile->email.'<br>';
                }
            }
        }
    }
}else{
    echo 'Cookies ZxnsQxZ6IoI22OoX Not Found<br>';
}

if($staging){
    $host = "http://10.10.16.247:8983/solr/metube_videos1/";
    $picurl = "http://clips.metube.co.id/cc-content/uploads/thumbs/";
    $clipurl = "http://clips.metube.co.id/videos/";
    $play = "http://clips.metube.co.id/embed/";
}else{
    $host = "http://10.10.16.40:8983/solr/metube_videos/";
    $picurl = "https://cdn-static.metube.id/thumbs/";
    $clipurl = "https://www.metube.id/videos/";
    $play = "https://www.metube.id/embed/";
}
if(isset($_REQUEST['ct']))$ct = $_REQUEST['ct']; else $ct="Music";
if(isset($_REQUEST['ch']))$ch = $_REQUEST['ch']; else $ch="40";
if(isset($_REQUEST['id']))$id = $_REQUEST['id']; else $id="59171";
?> 
