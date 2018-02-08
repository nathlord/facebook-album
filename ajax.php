<?php 
    
$appId = '155177361731935';
$appSecret = '62c1825ce1ff16e873eff134fbbeb063';

if(!session_id()){
    session_start();
}

/*
 * Get access token using Facebook Graph API
 */
if(isset($_SESSION['facebook_access_token'])){
    // Get access token from session
    $access_token = $_SESSION['facebook_access_token'];
}else{
    // Facebook app id & app secret 
    $appId = '155177361731935'; 
    $appSecret = '62c1825ce1ff16e873eff134fbbeb063';
    
    // Generate access token
    $graphActLink = "https://graph.facebook.com/oauth/access_token?client_id={$appId}&client_secret={$appSecret}&grant_type=client_credentials";

    #print_r($graphActLink);
    
    // Retrieve access token
    $accessTokenJson = file_get_contents($graphActLink);
    $accessTokenObj = json_decode($accessTokenJson);
    $access_token = $accessTokenObj->access_token;
    
    // Store access token in session
    $_SESSION['facebook_access_token'] = $access_token;
}

// Get photo albums of Facebook page using Facebook Graph API
$fields = "id,name,description,link,cover_photo,count";
$fb_page_id = "1438451763044761";
$album_id = '472758686102628';
$graphPhoLink = isset($_REQUEST['link']) ? $_REQUEST['link'] : "https://graph.facebook.com/v2.12/{$album_id}/photos?fields=count,created_time,images,likes.summary(true),link,source,caption&access_token={$access_token}&limit=20";


$jsonData = file_get_contents($graphPhoLink);
$fbPhotoObj = json_decode($jsonData, true, 512, JSON_BIGINT_AS_STRING);

$array = array();
// Facebook albums content

// foreach ($fbPhotoObj['data'] as $key => $value) {
//     //GET LIKES FOR PHOTO

//     $id = $value['id'];
//     $image_link = "https://graph.facebook.com/v2.12/{$id}/photos?fields=created_time,likes,link,source,caption&access_token={$access_token}";
//     $jsonData = file_get_contents($image_link);
//     $image_link_obj = json_decode($jsonData, true, 512, JSON_BIGINT_AS_STRING);
// }


$array['photo'] = $fbPhotoObj['data'];



// foreach($fbPhotoData as $k => $data){
//     $imageData = end($data['images']);
//     $imgSource = isset($imageData['source'])?$imageData['source']:'';
//     $name = isset($data['caption'])?$data['caption']:'';
//     $array['photo'][$k]['caption']    = $name; 
//     $array['photo'][$k]['source']  = $imgSource;
// }

$array['paging'] = $fbPhotoObj['paging'];

echo json_encode($array);

?>