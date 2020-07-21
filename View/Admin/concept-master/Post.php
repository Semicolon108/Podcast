<?php
    //include_once "../../../Classes/Model/Session.class.php";
    //include_once "../../../Classes/Database.php";
    include_once "../../../vendor/Autoload.php"; 
    
    $user = new Podcast;
    if(!$user::is_logged_in()){
        $user::login_error_redirect("Login/login.php");
    }
    include_once "../../../src/requests.inc.php";
    include_once "../../../src/header.inc.php";
?>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="content">
                <!--content-->
                <!--?php include_once "../../../src/requests.inc.php";?-->
                <form action="Post.php<?=((isset($_GET['edit']))?'?edit='.$edit_id:'')?>" method="POST" id='form' enctype="multipart/form-data">
                    <div class="row my-4 mx-3">
                        <div class="form-group col-12 col-md-6 col-sm-12">
                            <label for="name">Title</label>
                            <input type="text" name="title" class="form-control" value="<?=((isset($_GET['edit']))?$data['title']:'')?>">
                        </div>
                        <div class="form-group col-12 col-md-6 col-sm-12">
                        <?php
                           if(isset($_GET['edit']) && !empty($data['pod_photo'])):
                        ?> 
                            <div style='width:150px;height:90px;'>
                                <img src="<?=$data['pod_photo']?>" class='img-fluid' alt="img">
                                <div class="upload-btn-wrapper text-center col-12 " >
                                    <button class="bttn mx-4"><i class="fas fa-pencil-alt"></i></button>
                                    <input type="file" name="photo" class='edit'/>
                                </div>
                            </div>
                        <?php
                            else:
                        ?>    
                                <label for="photo">Cover Image</label>
                                <input type="file" name="photo" class="form-control">
                        <?php
                            endif;
                        ?>        
                        </div>
                    </div>
                    <div class="row mx-3 my-4">
                        <div class="form-group col-md-12 col-lg-6 col-sm-12">
                        <?php
                           if(isset($_GET['edit']) && !empty($data['pod_file'])):
                        ?> 
                            <div style='width:1005;'>
                            <audio id="player2" preload="none" controls style="max-width: 100%">
                               <source src="<?=$data['pod_file']?>" type="audio/mp3">
                            </audio>
                            <div class="upload-btn-wrapper col-12 my-2" >
                                <button class="bttn mx-4"><i class="fas fa-pencil-alt"></i></button>
                                <input type="file" name="pod_file" class='edit'/>
                            </div>
                            </div>
                        <?php
                            else:
                        ?>    
                                <label for="podcast">Podcast</label>
                                <input type="file" name="pod_file" id="podcast" class="form-control">
                        <?php
                            endif;
                        ?>    
                        </div>
                        <div class="form-group col-md-5 col-sm-12 my-5">
                            <label for="Category">Tag:</label>
                            <input type="text" name="tag" class="form-control" value="<?=((isset($_GET['edit']))?$data['tag']:'')?>">
                        </div>
                    </div>
            <!--/div-->
                    <div class="row mx-3 my-4">
                        <div class="form-group col-md-8 col-sm-8">
                            <label for="description">Description*:</label>
                            <textarea id="description" name="description" class="form-control tinymce" rows="6"><?=((isset($_GET['edit']))?$data['description']:'')?></textarea>
                        </div>
                        <div class="form-group pull-right col-sm-4 col-md-4"><br>
                            <a href="post.php" class="btn btn-outline-dark">Cancel</a>&nbsp;&nbsp;
                            <input type="submit" value="<?=((isset($_GET['edit']))?'Edit':'Add')?>" name="<?=((isset($_GET['edit']))?'edit':'submit')?>" class=" btn btn-outline-success pull-right">
                        </div><div class="çlearfix"></div>
                    </div>
                </form>
            </div>
        </div>
    </div>   
</div>
</div><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
<!-- ============================================================== -->
<!-- footer -->
<!-- ============================================================== -->
<div class="footer">
   <div class="container-fluid">
        <div class="row">
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                Copyright © 2018 Concept. All rights reserved. Dashboard by <a href="https://colorlib.com/wp/">Colorlib</a>.
            </div>
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                <div class="text-md-right footer-links d-none d-sm-block">
                    <a href="../../index.php">Podcast</a>
                    <a href="javascript: void(0);">About</a>
                    <a href="javascript: void(0);">Support</a>
                    <a href="javascript: void(0);">Contact Us</a>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- ============================================================== -->
<!-- end footer -->
<!-- ============================================================== -->
</div>
<!-- ============================================================== -->
<!-- end wrapper  -->
<!-- ============================================================== -->
</div>
</div>
<!--Modal-->
<div class="modal" tabindex="-1" id='myModal' role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body d-flex justify-content-center">
          <table class='text-center'>
              <thead>
                  <tr>
                      <th>Size</th>
                      <th>Quantity</th>
                  </tr>
              </thead>
              <tbody id='receiver'>

              </tbody>
          </table>
      </div>
      <div class="modal-footer">
        <button type="button" id='save' data-dismiss='modal' class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>
<!-- ============================================================== -->
<!-- end main wrapper  -->
<!-- ============================================================== -->
<!-- Optional JavaScript -->
<!-- jquery 3.3.1  -->
<script src="assets/vendor/jquery/jquery-3.3.1.min.js"></script>
<!-- bootstap bundle js-->
<script src="assets/vendor/bootstrap/js/bootstrap.bundle.js"></script>
<!-- slimscroll js-->
<script src="assets/vendor/slimscroll/jquery.slimscroll.js"></script>
<!-- main js-->
<script src="assets/libs/js/main-js.js"></script>
</body>

 
</html>