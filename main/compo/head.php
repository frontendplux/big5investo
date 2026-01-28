
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
    <meta name="description" content="<?= $seo_configuration_data['description'] ?>">
    <meta name="keywords" content="<?= $seo_configuration_data['keywords'] ?>">
    <link rel="icon" href="<?= $seo_configuration_data['icon'] ?>" type="image/x-icon">
    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
     <script src="https://www.gstatic.com/firebasejs/9.23.0/firebase-app-compat.js"></script>
     <script src="https://www.gstatic.com/firebasejs/9.23.0/firebase-messaging-compat.js"></script>
     <script>
        const firebaseConfig = {
  apiKey: "YOUR_API_KEY",
  authDomain: "YOUR_PROJECT.firebaseapp.com",
  projectId: "YOUR_PROJECT",
  messagingSenderId: "YOUR_SENDER_ID",
  appId: "YOUR_APP_ID"
};

firebase.initializeApp(firebaseConfig);
const messaging = firebase.messaging();

async function subscribe() {
  try {
    const permission = await Notification.requestPermission();
    if (permission !== "granted") return alert("Permission denied");

    const token = await messaging.getToken({
      vapidKey: "YOUR_PUBLIC_VAPID_KEY"
    });

    fetch("save_token.php", {
      method: "POST",
      headers: {"Content-Type": "application/json"},
      body: JSON.stringify({ token })
    });

    alert("Subscribed!");
  } catch (err) {
    console.error(err);
  }
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