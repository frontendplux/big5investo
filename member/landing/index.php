<?php include __DIR__."/../compo/head.php"; ?>
<body class="bg-light">
    <header class="bg-white">
        <div class="container text-center py-5">
            <h1 class="m-0"><img src="<?= $seo_configuration_data['icon'] ?>" style="width:70px; height: 70px;" alt="Logo"></h1>
        </div>
        <div class="d-flex justify-content-center text-uppercase gap-4 pb-4" style="margin-top: -30px;">
            <?php 
                foreach([
                    ["name"=>"home", "link"=>"/$country/member/"],
                    ["name"=>"services", "link"=>"/$country/company"],  
                    ["name"=>"project", "link"=>"/$country/project"],
                ] as $nav_item):
            ?>
            <a href="<?= $nav_item['link'] ?>" class="text-decoration-none text-dark fw-medium"><?= $nav_item['name'] ?></a>
            <?php endforeach; ?>
        </div>
    </header>

    <div class="container d-sm-flex">
        <div class="p-2 col-3">
            <div class="bg-white">
                <a href="">company</a>
            </div>
        </div>
        <div class="p-2 col-9">
            <div class="bg-white p-2">
                <div class="p-2 bg-light">
                    <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Deserunt, corrupti.</p>
                    <div>
                        <a href="">mine now <span>0.56</span></a>
                    </div>
                </div>
            </div>
            <div class="d-flex gap-2 my-4 text-capitalize">
                <a href="" class="btn btn-warning px-3">next</a> 
                <a href="" class="btn btn-warning px-3">preview</a>
            </div>
        </div>
    </div>
</body>
</html>