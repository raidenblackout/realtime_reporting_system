
<div class="jumbotron">
  <h1 class="display-4" style="color: red">Emergency</h1>
  <p class="lead" style="color:red" id="emergency-headline">
  <?php
  require_once 'modules/checkAuthentication.php';
  require_once 'modules/dependencyImporter.php';
  $sql = "SELECT * FROM `post` WHERE `p_category` = 'Emergency' ORDER BY `p_id` DESC LIMIT 1";
  $result = $conn->query($sql);
  $row = '';
  if($result && $result->num_rows>0){
    $row = $result->fetch_assoc();
    echo $row['p_content'];
  }else{
    echo "No emergency post yet";
  }
  ?></p>
  <p class="lead" id="headline-link-container"> 
    <?php
      if($result->num_rows>0){
        echo '<a class="btn btn-danger btn-sm" href="/realtime_reporting_system/explore.php?post_id='.$row['p_id'].'" role="button" id="emergency-link">Learn more</a>';
      }
    ?>
  </p>
</div>