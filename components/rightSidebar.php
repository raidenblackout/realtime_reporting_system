
<div class="right-sidebar">
    <div class="container d-flex flex-column justify-content-center w-20">
        <div class="header d-flex align-items-center justify-content-center">
            <strong style="text-align: center">Categories</strong>
        </div>

        <?php
        require_once 'modules/dependencyImporter.php';
        $categoryList = getCategories();
        foreach ($categoryList as $category) {
            echo '<a href="/realtime_reporting_system/explore.php?category=' . $category['c_name'] . '" class="btn '.($category['c_name']=='Emergency'? 'btn-danger': 'bg-color-main'). ' btn-sm">'. $category['c_name'] . '</a>';
        }
        ?>
    </div>
</div>