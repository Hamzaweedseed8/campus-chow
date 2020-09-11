<?php 
  require_once '../db.php';
  if(isset($_POST["orderNow"])){
    $id = $_POST['id'];
    $sql =  $con->query("SELECT * FROM rest_foods WHERE id = '$id'");
    $row = mysqli_fetch_array($sql);
?>
<style type="text/css">
  .modal-backdrop{
    position: unset !important;
  }
  .modal-content{
    box-shadow: 0 2px 5px rgba(0,0,0,0.4);
  }
  #modal_errors p{
    color: #fff !important;
  }
</style>
<!-- detaialsmodal box-->
  <div class="modal fade " id="details-modal" tabindex="-1" role="dailog" aria-labelledby="details-1" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title text-center"><?=$row['name'];?></h4>
          <button class="close" type="button" onclick="closeModal()" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="container-fluid">
            <div class="row">
              <div class="col-md-12">
              <span id="modal_errors" class="bg-danger"></span>
              </div>
            </div>
              <div class="row">
                
                  <div class="col-sm-6 fotorama" >
                      <?php $photos = explode(',',$row['pictures']);
                        foreach($photos as $photo): ?>
                      <div class="center ">
                      <img src="<?=$photo;?> " alt="<?= $row['name']; ?>" class="img-fluid" style="margin: 15px auto;">
                    </div>
                  <?php endforeach ;?>
                </div>
                <div class="col-sm-6">
                  <h4>Details</h4>
                  <p>Price: Gh&cent<?=$row['price']; ?></p>
                  <p>Restaurant Name: <?=$row['restaurant_name']; ?></p>
                    <div class="form-group">
                      <div class="col-md-12">
                        <label for="quantity">Quantity</label>
                        <input type="number" class="form-control" id="quantity" name="quantity" min="0">
                      </div>
                    </div>
                </div>
              </div>
          </div>
          <div class="modal-footer">
            <button class="btn btn-danger" onclick="closeModal()">Close</button>
            <a class="btn btn-warning" id="addToCart" cartid="<?=$row['id'];?>">Add to Orders</a>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script>
    $(function(){
      $('.fotorama').fotorama({'loop':true,'autoplay':true});
    });
    function closeModal(){
      jQuery('#details-modal').modal('hide');
      setTimeout(function(){
        jQuery('#details-modal').remove();
        jQuery('.modal-backdrop').remove();
      },500);
    }
  </script>
<?php  }?>