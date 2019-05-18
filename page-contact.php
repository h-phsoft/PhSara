<div class="container">
  <div class="row mt-5 text-center">
    <div class="col-12">
      <img alt="On the Way to the Leisure Centre" title="" src="<?php echo $PH_BASE_PATH_IMAGES; ?>contact_2017.jpg" width="100%">
    </div>
  </div>
  <div class="row my-2 text-center">
    <div class="col-12">
      <h4><?php echo $cMenu->Menu_Name; ?></h4>
    </div>
  </div>
  <div class="row mb-4">
    <div class="col-12 col-sm-6">
      <div class="row mb-4">
        <div class="col-12 text-center">
          <h5>Contact the artist</h5>
        </div>
        <div class="col-12">
          <form id="formContactus" name="formContactus" action="<?php echo $PH_BASE_PATH . '/index.php?' . ph_Setting('Menu-SendMail'); ?>" method="POST">
            <div class="form-group">
              <input class="form-control" name="cus_name" type="text" placeholder="Name" required>
            </div>
            <div class="form-group">
              <input class="form-control" name="cus_email" type="text" placeholder="Email" required>
            </div>
            <div class="form-group">
              <input class="form-control" name="cus_subject" type="text" placeholder="Subject" required>
            </div>
            <div class="form-group">
              <textarea class="border form-control-plaintext" name="cus_message" rows="8" placeholder="Message" required style="padding: 10px;"></textarea>
            </div>
            <div class="form-group">
              <img style="float: left; padding-right: 5px; margin-bottom: 10px; cursor: pointer"
                   id="captcha_image0"
                   src="<?php echo $PH_BASE_PATH; ?>/PhApps/PhModules/securimage/securimage_show.php?<?php echo md5(uniqid(time())) ?>"
                   onclick="document.getElementById('captcha_image0').src = '<?php echo $PH_BASE_PATH; ?>/PhApps/PhModules/securimage/securimage_show.php?' + Math.random(); captcha_image_audioObj.refresh(); this.blur(); return false"
                   alt="CAPTCHA Image" title="click to refresh">
              </img>
              <div style="clear: both"></div>
              <input class="form-control" name="captcha_code0" id="captcha_code0" type="text" placeholder="Type the text" required>
            </div>
            <div class="form-group">
              <input class="btn btn-outline-secondary btn-block" type="submit" value="Submit">
            </div>
          </form>
        </div>
      </div>
    </div>
    <div class="col-12 col-sm-6">
      <div class="row mb-4">
        <div class="col-12 text-center">
          <h5>Subscribe to the Artist's newsletter</h5>
        </div>
        <div class="col-12">
          <form id="formNewsletter" name="formNewsletter" action="<?php echo $PH_BASE_PATH . '/index.php?' . ph_Setting('Menu-Subscribe'); ?>" method="post">
            <div class="form-group">
              <input class="form-control" type="text" placeholder="Name" name="sub_name" required>
            </div>
            <div class="form-group">
              <input class="form-control" type="text" placeholder="Email" name="sub_email" required>
            </div>
            <div class="form-group">
              <input class="form-control" type="text" placeholder="Country" name="sub_country" required>
            </div>
            <div class="form-group">
              <textarea class="border form-control-plaintext" placeholder="Occupation" name="sub_message" rows="8" required style="padding: 10px;"></textarea>
            </div>
            <div class="form-group">
              <img style="float: left; padding-right: 5px; margin-bottom: 10px; cursor: pointer"
                   id="captcha_image1"
                   src="<?php echo $PH_BASE_PATH; ?>/PhApps/PhModules/securimage/securimage_show.php?<?php echo md5(uniqid(time())) ?>"
                   onclick="document.getElementById('captcha_image1').src = '<?php echo $PH_BASE_PATH; ?>/PhApps/PhModules/securimage/securimage_show.php?' + Math.random(); captcha_image_audioObj.refresh(); this.blur(); return false"
                   alt="CAPTCHA Image" title="click to refresh">
              </img>
              <div style="clear: both"></div>
              <input class="form-control" name="captcha_code1" id="captcha_code1" type="text" placeholder="Type the text" required>
            </div>
            <div class="form-group">
              <input class="btn btn-outline-secondary btn-block" type="submit" name="subscribe" value="Subscribe" >
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript" src="<?php echo $PH_RELATIVE_PATH; ?>PhModules/securimage/securimage.js"></script>
