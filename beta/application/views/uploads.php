<html>
<head>
<title>Upload Form</title>
<script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script>
function readURL(input,id) {
  if (input.files && input.files[0]) {
    var reader = new FileReader();
    reader.onload = function (e) {
      $('#'+id).attr('src', e.target.result).width(50).height(50);
    };
    reader.readAsDataURL(input.files[0]);
  }
}
</script>
</head>
<body>
<?php echo form_open_multipart('uploads');?>
<div class="form-group">
    <label>Select image</label>
     <div data-provides="fileupload" class="fileupload fileupload-new">
      <div style="width: 67px; height: 50px;" class="fileupload-new img-thumbnail">
        <img id="userfile_preview" class="media-object img-thumbnail pull-left" src="<?php if(!empty($profile_image)){  echo base_url(); ?>uploads/profile/<?php echo $profile_image; } else {  echo base_url(); ?>img/no_img.png<?php } ?>" alt="" />
      </div>                  
      <span class="btn btn-default btn-file">
            <input name="userfile" id="userfile" type="file" onchange="readURL(this,'userfile_preview');" />
      </span>                 
      <span class="required-server"><?php echo form_error('userfile'); ?> </span>
      </div>
  </div>
<br />
<br />
<input type="submit" value="upload" name="submit"/>
</form>
</body>
</html>