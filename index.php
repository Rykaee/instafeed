/*
Author: Roosa Kontinen 2022
*/

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Instagram feed</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <div class="container-fluid p-5 bg-dark text-white text-center">
        <div class="row">
            <div class="col">
                <h1>Instagram feed</h1>
            </div>
        </div>
    </div>
    <div class="container-sm p-5 my-3 text-white text-center bg-secondary">
        <div class="row ">
            <div class="col">
                <?php
                    $fields = "id,media_type,media_url,thumbnail_url,timestamp,permalink,caption";

                    /*By default, Instagram API will give you a short-lived access token which is valid only for 24 hours.
                    Instagram Longl-Lived Access Token is valid for 60 days.
                    Long-lived tokens are valid for 60 days and can be refreshed as long as they are at least 24 hours old
                    but have not expired, and the app user has granted your app the instagram_graph_user_profile permission. 
                    Refreshed tokens are valid for 60 days from the date at which they are refreshed. */

                    $accToken = ""; // Set your Access Token here.
                    $mediaLimit = 3; // Set a number of display items.

                    function getData($url){
                        $ch = curl_init();
                        curl_setopt($ch, CURLOPT_URL, $url);
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                        curl_setopt($ch, CURLOPT_TIMEOUT, 20);
                        $result = curl_exec($ch);
                        curl_close($ch);
                        return $result;
                    }

                    $result = getData("https://graph.instagram.com/me/media?fields={$fields}&access_token={$accToken}&limit={$mediaLimit}");
                    $result_decode = json_decode($result, true);

                    foreach ($result_decode["data"] as $post) : {

                        $caption = $post["caption"];
                        $permalink = $post["permalink"];
                        $media_type = $post["media_type"];

                        if ($media_type == "VIDEO" ) {
                            $media_url = $post["thumbnail_url"]; }
                        else {
                            $media_url = $post["media_url"];
                        }
                    }
                    ?>
                    <div class="instagram_new">
                        <a class="insta-link" href="<?php echo $permalink; ?>" rel="noopener" target="_blank">
                            <img src="<?php echo $media_url; ?>" loading="lazy" alt="<?php echo $caption; ?>" class="insta-image">
                        </a>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</body>
</html>
