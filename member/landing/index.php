<?php include __DIR__."/../compo/head.php"; ?>
<body class="bg-light">
    <header class="bg-white">
        <div class="container text-center py-5">
            <h1 class="m-0"><img src="<?= $seo_configuration_data['icon'] ?>" style="width:70px; height: 70px;" alt="Logo"></h1>
        </div>
        <div class="d-flex justify-content-center text-uppercase gap-4 pb-4" style="margin-top: -30px;">
            <?php 
                foreach([
                    ["name"=>"home", "link"=>"/$country/"],
                    ["name"=>"about", "link"=>"/$country/about"],
                    ["name"=>"services", "link"=>"/$country/services"],  
                    ["name"=>"contact", "link"=>"/$country/contact"],
                    ["name"=>"project", "link"=>"/$country/project"],
                ] as $nav_item):
            ?>
            <a href="<?= $nav_item['link'] ?>" class="text-decoration-none text-dark fw-medium"><?= $nav_item['name'] ?></a>
            <?php endforeach; ?>
        </div>
    </header>
</body>
</html>