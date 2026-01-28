
<!DOCTYPE html>
<html lang="en">
<head>
    <?php
          $seo_configuration_data=[
               "icon"=>$seo_configuration['icon'] ?? "/image/logo.png",
                "title"=>$seo_configuration['title'] ?? "Big5Investo Community",
                "description"=>$seo_configuration['description'] ?? "Join the Big5 Investo community to connect with fellow investors, share insights, and stay updated on the latest market trends.",
                "keywords"=>$seo_configuration['keywords'] ?? "Big5 Investo, investment community, investor forum, market insights, financial discussions"
          ];
     ?>
    <meta charset="UTF-8">
    <title><?= $seo_configuration_data['title'] ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="manifest" href="/manifest.json">
    <meta name="theme-color" content="#0d6efd">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="description" content="<?= $seo_configuration_data['description'] ?>">
    <meta name="keywords" content="<?= $seo_configuration_data['keywords'] ?>">
    <link rel="icon" href="<?= $seo_configuration_data['icon'] ?>" type="image/x-icon">
    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <!-- <script src="https://cdn.onesignal.com/sdks/web/v16/OneSignalSDK.page.js" defer></script> -->
<script src="https://cdn.onesignal.com/sdks/web/v16/OneSignalSDK.sw.js" defer></script>
<script src="https://cdn.onesignal.com/sdks/web/v16/OneSignalSDK.page.js" defer></script> 
<script> 
window.OneSignalDeferred = window.OneSignalDeferred || []; 
OneSignalDeferred.push(async function(OneSignal) {
   await OneSignal.init({ appId: "d6666635-279c-4462-87bd-4558e9d7b004", }); 
   }); 
</script>
    <script>
        if ("serviceWorker" in navigator) {
            navigator.serviceWorker.register("/service-worker.js")
                .then(() => console.log("Service Worker registered"))
                .catch(err => console.error("SW error", err));
            }
    </script>
    <script src="/script.js"></script>
    <style>
       html, body { scroll-behavior: smooth; height: 100%; }
        .hero {
            background: linear-gradient(rgba(0,0,0,.75), rgba(0,0,0,.75)),
            url('https://images.unsplash.com/photo-1503387762-592deb58ef4e') center/cover no-repeat;
            color: #fff;
            min-height: 100vh;
            display: flex;
            align-items: center;
        }
        .highlight {
            color: #ffc107;
        }
    </style>

</head>