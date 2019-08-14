<?php

//////////////////////////////////////////////
/// Set A/B testing parameter and cookies ///
/////////////////////////////////////////////

  global $next_ab, $IE; // get parameter for next a/b testing.
  global $onepage, $facebook; // get parameter for onepage style.
  if (isset($_GET['utm_lang'])) {
    if ($_GET['utm_lang']) {
      $XQS_utm_lang = $_GET['utm_lang'];
    }
  }
  if (isset($_GET['post_diff'])) {
    if ($_GET['post_diff']) {
      $post_diff = $_GET['post_diff'];
    }
  }
  if (isset($_GET['utm_slide'])) {
    if ($_GET['utm_slide']) {
      $XQS_utm_slide = $_GET['utm_slide'];
    }
  }
  if (isset($_GET['utm_source']) || isset($_GET['utm_content'])) {
    if ($_GET['utm_source']) {
    //  $stickyLeft = true;
      $hasUtms = true;
      $XQS_utm_content = $_GET['utm_content'];
      $XQS_utm_source = $_GET['utm_source'];
    }
    $utm_array = array("newnext", "fb_ease", "gallery");
    if (in_array($_GET['utm_content'], $utm_array)) {
       $next_ab = $_GET['utm_content'];
       // $stickyLeft = true;
       $XQS_utm_content = $_GET['utm_content'];
    }
    if ($_GET['utm_content'] == 'fb_ease') {
      if($uri_segments[2] <= '3') {
        $next_ab = '_2slides';
      } else {
        $next_ab = 'newnext';
      }
    } 
    //echo "utm_content: ".$XQS_utm_content;
    if ($_GET['utm_content'] == 'one_newnext') { //  check for onepage url parameter
      $onepage = true;
      $XQS_utm_content = $_GET['utm_content'];
      // $stickyLeft = true;
    } 
    if ($_GET['utm_content'] == 'onequiz') { //  check for onequiz url parameter
      $onequiz = $_GET['utm_content'];
      $XQS_utm_content = $_GET['utm_content'];
      $next_ab = $_GET['utm_content'];
      $stickyLeft = true;
    }

    if ($_GET['utm_content'] == 'fgallery' || $_GET['utm_content'] == 'forganic') { //  check for fquiz url parameter
      $next_ab = true;
      $stickyLeft = false;
      if (in_array($uri_segments[2], array(0, 1))) {
         $fquiz = '1';
         $facebook = '1';
       } else if ($uri_segments[2] == '2') {
         $fquiz = '2';
         $facebook = 2;
       } else if ($uri_segments[2] == '3') {
         $fquiz = '3';
         $facebook = 2;
       } else if ($uri_segments[2] == '4') {
         $fquiz = false;
         $facebook = 4;
       } else {
         $facebook = 5;
         $fquiz = false;
       }
    }
    if ($_GET['utm_content'] == 'fquiz') { //  check for fquiz url parameter
      if (in_array($uri_segments[2], array(0, 1, 2))) {
         $fquiz = '1';
       } else if ($uri_segments[2] == '3') {
         $fquiz = '3';
       } else {
         $fquiz = '4';
       }
    }
  }
  if ((isset($_COOKIE['XQS']) || isset($_COOKIE['segid'])) && (empty($_GET) || $_GET['dev'])) {

    if (isset($_COOKIE['XQS'])) {
      $XQS64 = $_COOKIE['XQS'];
      $XQSdecode = base64_decode($XQS64);
      parse_str($XQSdecode, $XQS_array);
    } else {
      $segid = $_COOKIE['segid'];
      parse_str($segid, $XQS_array);
    }
  print_r($XQS_array);

    if (isset($XQS_array['utm_content']) != 'null' && isset($XQS_array['utm_content']) != 'null') {
      $XQS_utm_content = isset($XQS_array['utm_content']);
      $XQS_utm_source = isset($XQS_array['utm_source']);
      $XQS_utm_slide = isset($XQS_array['utm_slide']);
    }

    //echo "utm_medium: ".$XQS_utm_medium;

    if ($XQS_utm_content == 'newnext' || $XQS_utm_content == 'gallery') { // check if we've newnext
       $next_ab = $XQS_utm_content;
    //   $stickyLeft = true;
    }
    if ($XQS_utm_source) $hasUtms = true; // $stickyLeft = true;
    if ($XQS_utm_source == 'faok') $stickyLeft = true;
  
    if ($XQS_utm_content == 'one_newnext') $onepage = true;
    if ($XQS_utm_content == 'onequiz') {$onequiz = 'onequiz'; $next_ab = true; $stickyLeft = true;  }

    if ($XQS_utm_content == 'fb_ease') {
      if($uri_segments[2] <= '3') {
        $next_ab = '_2slides';
      } else {
        $next_ab = 'newnext';
      }
    } 
    if ($XQS_utm_content == 'fquiz') {

      if (in_array($uri_segments[2], array(0, 1))) {
         $fquiz = '1';
       } else if ($uri_segments[2] == '1') {
         $fquiz = '2';
       } else if (in_array($uri_segments[2], array(2, 3))) { 
         $fquiz = '3'; 
       } else {
         $fquiz = '4';
       }
    }
    if ($XQS_utm_content == 'fgallery' || $XQS_utm_content == 'forganic') {
      $next_ab = true;
      $stickyLeft = false;
      if (in_array($uri_segments[2], array(0, 1))) {
         $fquiz = '1';
         $facebook = '1';
       } else if ($uri_segments[2] == '2') {
         $fquiz = '1';
         $facebook = 2;
       } else if ($uri_segments[2] == '3') {
         $fquiz = '3';
         $facebook = 3;
       } else if ($uri_segments[2] == '4') {
         $fquiz = false;
         $facebook = 4;
       } else {
         $facebook = 5;
         $fquiz = false;
       }
    }
  }
if (isset($_GET['utm_source']) || isset($XQS_utm_source)) { 
  $taboola = (isset($_GET['utm_source']) == 'tala' || isset($_GET['utm_source']) == 'talas' || $XQS_utm_source == 'tala' || $XQS_utm_source =="talas") ? true : false;
  $outbrain = (isset($_GET['utm_source']) == 'ouin' || isset($_GET['utm_source']) == 'ouins' || $XQS_utm_source == 'ouin' || $XQS_utm_source =="ouins") ? true : false;
  $geni = (isset($_GET['utm_source']) == 'geni' || $XQS_utm_source =="geni") ? true : false;
}
  foreach ($_COOKIE as $Ckey => $Cvalue) {
    // find cookie key sp_id
    $sp = preg_match("/_sp_id/i", $Ckey, $value);
    if ($sp == 1) {
        $sp_id = $Cvalue;
        $sp_idCut_7 = substr($sp_id, 7, 1);
        $sp_idCut = substr($sp_id, 3, 1);

        // tests SegIDs from here:

        // Experiment: carry top banner with sticky header
        // $topAd_sticky = (preg_match("/[4-7]/i", $sp_idCut)) ? true : false;

    }
    // Enable Dev mode
    if ($Ckey == 'dev') $devMode = true;
  }

  if ($next_ab == '_2slides') $_2slides = true;

  if (strpos($_SERVER['HTTP_USER_AGENT'], 'Trident/7.0; rv:11.0') == true) $IE = true; 
  if ($detectedDevice == "mobile") $stickyLeft = false;
  if (isset($_GET['dev'])) { // Enable Dev mode
  //  setcookie('dev', $_GET['dev'], time() + (86400 * 30), "/");
    $devMode = true;
  }
  if (isset($_GET['dev']) && isset($_GET['nf'])) { // Dev Mode and NF name specified
      if (preg_match('/^[\/A-Za-z0-9_-]*\.js$/', $_GET['nf'])) {
        $nfBasename = $_GET['nf'];
      }
  }
  