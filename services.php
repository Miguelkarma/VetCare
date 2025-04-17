<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Our Services</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.6.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        :root {
            --primary: #4e73df;
            --secondary: #f8f9fc;
            --accent: #4e73df;
            --text-dark: #5a5c69;
            --text-light: #858796;
            --border: #e3e6f0;
        }

        body {
            font-family: 'Nunito', 'Segoe UI', Roboto, Arial, sans-serif;
            
            color: var(--text-dark);
        }

        .page-header {
            background: radial-gradient(
        65.28% 65.28% at 50% 100%,
        rgba(247, 227, 202, 0.644) 0%,
        /* Tan color */ rgba(210, 180, 140, 0) 100%
      ),
      linear-gradient(0deg, #f1d2bd, #ddc3b2); /* Beige color */
            padding: 1.5rem 0;
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
            margin-bottom: 2rem;
            border-radius:1em;
            
        }

        .page-header h2 {
            margin-bottom: 0;
            font-weight: 700;
            color:rgb(75, 49, 12);
        }

        .category-card {
            border-radius: 0.5rem;
            box-shadow: 0 0.15rem 1.75rem rgba(0, 0, 0, 0.03);
            margin-bottom: 1.5rem;
        }

        .category-card .card-header {
            background: radial-gradient(
        65.28% 65.28% at 50% 100%,
        rgba(247, 227, 202, 0.644) 0%,
        /* Tan color */ rgba(210, 180, 140, 0) 100%
      ),
      linear-gradient(0deg, #f1d2bd, #ddc3b2); /* Beige color */
      color:rgb(75, 49, 12);
            font-weight: 700;
            border-top-left-radius: 0.5rem;
            border-top-right-radius: 0.5rem;
            padding: 1rem 1.25rem;
        }

        .list-group-item {
            border-color: var(--border);
            padding: 0.75rem 1.25rem;
            transition: all 0.2s ease; 
            background-color:rgb(255, 255, 255);
            color:rgb(75, 49, 12)!important;
        }

      

        .list-group{
            color:rgb(75, 49, 12);
        }

        .custom-checkbox .custom-control-input:checked ~ .custom-control-label::before {
            background-color: var(--primary);
            border-color: var(--primary);
        }

        .custom-control-label {
            font-weight: 500;
            cursor: pointer;
        }

        .service-item {
            margin-bottom: 1rem;
            border-radius: 0.5rem !important;
            box-shadow: 0 0.15rem 1.75rem rgba(0, 0, 0, 0.03);
            transition: all 0.3s ease;
        }

        .service-item:hover {
            transform: translateY(-2px);
            box-shadow: 0 0.5rem 1.75rem rgba(0, 0, 0, 0.05);
        }

        .service-item a {
            padding: 1rem;
            text-decoration: none !important;
        }

        .service-item h3 {
            font-size: 1.25rem;
            font-weight: 700;
            color:rgb(75, 49, 12)!important;
            margin-bottom: 0.25rem;
        }

        .service-item small {
            color:rgb(75, 49, 12)!important;
            font-style: italic;
        }

        .collapse-icon {
            color: var(--primary);
            font-size: 1rem;
            transition: all 0.2s ease;
        }

        .service-item .collapse {
            padding: 0 1rem 1rem;
        }

        .service-fee {
            background-color: rgb(219, 200, 172)!important;
            color:rgb(75, 49, 12)!important;
            padding: 0.25rem 0.75rem;
            border-radius: 1rem;
            font-weight: 600;
            display: inline-block;
        }

        .search-box {
            margin-bottom: 1.5rem;
            position: relative;
        }

        .search-box input {
            padding-left: 2.5rem;
            border-radius: 2rem;
            border: 1px solid var(--border);
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.03);
        }

        .search-box i {
            position: absolute;
            left: 1rem;
            top: 0.75rem;
            color: var(--text-light);
        }

        @media (max-width: 767.98px) {
            .col-md-4, .col-md-8 {
                margin-bottom: 1.5rem;
            }
        }
    </style>
</head>
<body>
    <?php 
    $cid = isset($_GET['cids']) ? $_GET['cids'] : 'all';
    ?>

    <div class="page-header">
        <div class="container">
            <h2><i class="fas fa-concierge-bell mr-2"></i>Our Services</h2>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <div class="card category-card">
                    <div class="card-header">
                        <i class="fas fa-filter mr-2"></i>Categories
                    </div>
                    <div class="list-group list-group-flush">
                        <div class="list-group-item">
                            <div class="custom-control custom-checkbox">
                              <input class="custom-control-input" type="checkbox" id="category_all" value="all" <?= $cid =='all' ? "checked" :"" ?>>
                              <label for="category_all" class="custom-control-label">All Categories</label>
                            </div>
                        </div>
                        <?php 
                        $cat_qry = $conn->query("SELECT * FROM `category_list` where delete_flag = 0");
                        while($row = $cat_qry->fetch_assoc()):
                        ?>
                        <div class="list-group-item">
                            <div class="custom-control custom-checkbox">
                                <input class="custom-control-input category-item" type="checkbox" id="category_<?= $row['id'] ?>" value="<?= $row['id'] ?>" <?= $cid=='all' || in_array($row['id'],explode(',',$cid)) ? "checked" : "" ?>>
                                <label for="category_<?= $row['id'] ?>" class="custom-control-label"><?= $row['name'] ?></label>
                            </div>
                        </div>
                        <?php endwhile; ?>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="search-box">
                    <i class="fas fa-search"></i>
                    <input type="text" id="search" class="form-control" placeholder="Search services...">
                </div>
                <div class="list-group" id="service-list">
                    <?php 
                    $categories = $conn->query("SELECT * FROM `category_list`");
                    $cat_arr = array_column($categories->fetch_all(MYSQLI_ASSOC),'name','id');
                    $cwhere = "";
                    if($cid != 'all'){
                        $cwhere .= " and ";
                        $_cw = "";
                        foreach(explode(',',$cid) as $v){
                            if(!empty($_cw)) $_cw .= " or ";
                            $_cw .= "CONCAT('|',REPLACE(category_ids,',','|,|'),'|') LIKE '%|{$v}|%'";
                        }
                        $cwhere .= "({$_cw})";
                    }
                    $services = $conn->query("SELECT * FROM `service_list` where delete_flag = 0 {$cwhere} order by `name` asc");
                    while($row = $services->fetch_assoc()):
                        $for = '';
                        foreach(explode(',',$row['category_ids']) as $v){
                            if(isset($cat_arr[$v])){
                                if(!empty($for)) $for .= ", ";
                                $for.= $cat_arr[$v];
                            }
                        }
                        $for = empty($for) ? "N/A" : $for;
                    ?>
                    <div class="list-group-item service-item">
                        <a class="d-flex w-100 text-dark align-items-center" href="#service_<?= $row['id'] ?>" data-toggle="collapse">
                            <div class="col-11 px-0">
                                <h3><?= ucwords($row['name']) ?></h3>
                                <small><i class="fas fa-tags mr-1"></i><?= $for ?></small>
                            </div>
                            <div class="col-1 text-right px-0">
                                <i class="fas fa-plus collapse-icon"></i>
                            </div>
                        </a>
                        <div class="collapse" id="service_<?= $row['id'] ?>">
                            <hr>
                            <div class="d-flex justify-content-end mb-3">
                                <span class="service-fee"><i class="fas fa-dollar-sign mr-1"></i><?= number_format($row['fee'],2) ?></span>
                            </div>
                            <div class="service-description">
                                <?= html_entity_decode($row['description']) ?>
                            </div>
                        </div>
                    </div>
                    <?php endwhile; ?>
                    <div id="no_result" style="display:none" class="text-center p-4">
                        <i class="fas fa-search fa-3x text-muted mb-3"></i>
                        <h5 class="text-muted">No services found</h5>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.6.2/js/bootstrap.bundle.min.js"></script>
    <script>
        function _category_filter(){
            if($('#category_all').is(":checked") == true){
                location.href="./?page=services"
            }else{
                var cids = [];
                $('.category-item:checked').each(function(){
                    cids.push($(this).val())
                })
                cids = encodeURI(cids.join(","))
                location.href="./?page=services&cids="+cids
            }
        }
        $(function(){
            $('#category_all').change(function(){
                if($(this).is(":checked") == true){
                    $('.category-item').prop("checked",true)
                    _category_filter()
                }else{
                    $('.category-item').prop("checked",false)
                }
            })
            $('.category-item').change(function(){
                if($('.category-item:checked').length < $('.category-item').length){
                    $('#category_all').prop("checked",false)
                }else{
                    $('#category_all').prop("checked",true)
                }
                _category_filter()
            })
            $('.collapse').on('show.bs.collapse', function () {
                $(this).parent().siblings().find('.collapse').collapse('hide')
                $(this).parent().siblings().find('.collapse-icon').removeClass('fa-minus').addClass('fa-plus')
                $(this).parent().find('.collapse-icon').removeClass('fa-plus').addClass('fa-minus')
                $("html, body").animate({scrollTop:$(this).parent().offset().top - 20},'fast')
            })
            $('.collapse').on('hidden.bs.collapse', function () {
                $(this).parent().find('.collapse-icon').removeClass('fa-minus').addClass('fa-plus')
            })

            $('#search').on("input",function(e){
                var _search = $(this).val().toLowerCase()
                $('#service-list .service-item').each(function(){
                    var _txt = $(this).text().toLowerCase()
                    if(_txt.includes(_search) === true){
                        $(this).toggle(true)
                    }else{
                        $(this).toggle(false)
                    }
                    if($('#service-list .service-item:visible').length <= 0){
                        $("#no_result").show('slow')
                    }else{
                        $("#no_result").hide('slow')
                    }
                })
            })
        })
    </script>
</body>
</html>