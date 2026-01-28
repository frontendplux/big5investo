    <?php
          $seo_configuration_data=[
               "icon"=>$seo_configuration['icon'] ?? "/image/logo.png",
                "title"=>$seo_configuration['title'] ?? "Big5Investo Community",
                "description"=>$seo_configuration['description'] ?? "Join the Big5 Investo community to connect with fellow investors, share insights, and stay updated on the latest market trends.",
                "keywords"=>$seo_configuration['keywords'] ?? "Big5 Investo, investment community, investor forum, market insights, financial discussions"
          ];
     ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.remixicon.com/releases/v2.5.0/css/remixicon.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <meta name="description" content="<?= $seo_configuration_data['description'] ?>">
    <meta name="keywords" content="<?= $seo_configuration_data['keywords'] ?>">
    <link rel="icon" href="<?= $seo_configuration_data['icon'] ?>" type="image/x-icon">
    <title><?= $seo_configuration_data['title'] ?></title>
</head>