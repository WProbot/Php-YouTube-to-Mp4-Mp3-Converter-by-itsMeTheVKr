<?php
$response = array(
    'data' => null,
    'error' => null,
);
$isResponse = false;
$isError = false;
$isSuccessResponse = false;
$providerName = null;
$url = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $isResponse = true;
    require_once __DIR__ . '/YoutubeDownloader.php';
    try {
        if (!isset($_POST['url']) || !trim($_POST['url'])) {
            throw new VideoDownloaderException("Url does not set");
        }
        $url = trim($_POST['url']);
        $yd = new YoutubeDownloader($url);
        $fullInfo = $yd->getFullInfo();
        $videoId = $fullInfo['video_id'];
        $response['data'] = array(
            'baseInfo' => $yd->getBaseInfo(),
            'downloadInfo' => $yd->getDownloadsInfo(),
        );
        $isSuccessResponse = true;
    } catch (Exception $e) {
        $isError = true;
        header('Bad request', true, 400);
        $response['error'] = $e->getMessage();
    }
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">          
    <link rel="shortcut icon" href="/logo.png">
<link rel="apple-touch-icon-precomposed" href="/logo.png">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="bootstrap.min.css">
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css">
    <title> Php YouTube to Mp4 And Mp3 Converter by @itsMeTheVKr </title>
</head>
<body>
<div class="container">
    <h1> YouTube Videos Downloader By URL  </h1>
    <form action="" method="post" id="download-form">
        <div class="row">
            <div class="col-md-10">
                <div class="form-group <?= $isError ? 'has-error' : '' ?>">
                    <input id="video-url" title="Video url" type="text" name="url" placeholder="Video url"
                           class="form-control" value="<?= htmlspecialchars($url) ?>"/>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <button class="btn btn-primary btn-block"> Download Now! </button>
                </div>
            </div>
        </div>
    </form>
    <div class="alert alert-danger" role="alert" id="error-block" style="display: <?= $isError ? 'block' : 'none' ?>">
        <?= $isError ? $response['error'] : '' ?>
    </div>

    <?php if ($isSuccessResponse): ?>
        <?php
        $baseInfo = $response['data']['baseInfo'];
        $downloadInfo = $response['data']['downloadInfo'];
        ?>
    <?php endif; ?>

    <h3 id="video-name">
        <?php if ($isSuccessResponse): ?>
            <?= htmlspecialchars($baseInfo['name']) ?>
        <?php endif; ?>
    </h3>

    <div class="row">
        <div class="col-md-6" style="display: <?= $isSuccessResponse ? 'block' : 'none' ?>">
            <div id="video-preview">
                <?php if ($isSuccessResponse): ?>
                    <img src="<?= $baseInfo['previewUrl'] ?>" alt="Video preview"
                         class="img-responsive img-thumbnail img-rounded">
                <?php endif; ?>
            </div>
            <pre id="video-description">
                <?php if ($isSuccessResponse): ?>
                    <?= htmlspecialchars($baseInfo['description']) ?>
                <?php endif; ?>
            </pre>
        </div>
        <div class="col-md-6">
            <table id="download-list" class="table">
                <thead <?= !$isSuccessResponse ? 'style="display: none"' : '' ?>>
                <tr>
                    <th><center>Download Link</center></th>
                </tr>
                </thead>
                <tbody>
                <?php if ($isSuccessResponse): ?>
                        <tr>
                            <td>
                   
   <iframe  sandbox="allow-scripts allow-same-origin"   style="width:100%;height:110px;border:0;overflow:hidden;" scrolling="no" src="https://vkrdl.000webhostapp.com/apis/d/?u=<?= htmlspecialchars($url) ?>&f=mp3"></iframe>
       <iframe  sandbox="allow-scripts allow-same-origin"   style="width:100%;height:110px;border:0;overflow:hidden;" scrolling="no" src="https://vkrdl.000webhostapp.com/apis/d/?u=<?= htmlspecialchars($url) ?>&f=360"></iframe>
   <iframe  sandbox="allow-scripts allow-same-origin"   style="width:100%;height:110px;border:0;overflow:hidden;" scrolling="no" src="https://vkrdl.000webhostapp.com/apis/d/?u=<?= htmlspecialchars($url) ?>&f=720"></iframe>
                            <a href="http://vkrdl.000webhostapp.com/@download/?url=<?= htmlspecialchars($url) ?>">   <button class="btn btn-primary btn-block">  More Download Format </button>
                </a>
                    
                            </td>
                      </tr>
                      <tr>
                          <td>
                           <h3>  Thanks For using our service Dear User ... Please contact us for any kind of suggestion or problem if you have .... </h3>
                              
                          </td>
                          
                      </tr>
                       <tr>
                          <td>
                           <h2> &copy; Powered By @itsMeTheVKr  </h2> All Right Reserved <?php
    echo $a= date("Y");
   ?>
                              
                          </td>
                          
                      </tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<div id="load-shadow"
     style="display: none; width: 100%; height: 100%; left: 0; top: 0; background: rgba(63, 0, 255, 0.31); z-index: 10; position: fixed;"></div>
</body>
<script src="//code.jquery.com/jquery-2.2.4.min.js"></script>
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script> <!--<script src="js/youtube-downloader.js"></script>-->

<style type="text/css">img[src*="https://cdn.000webhost.com/000webhost/logo/footer-powered-by-000webhost-white2.png"] { display: none;}</style>
</html>
