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
          <form action="<?php echo $PH_BASE_PATH . '/mailsend'; ?>" method="POST">
            <div class="form-group">
              <input class="form-control" name="name" type="text" placeholder="Name" required>
            </div>
            <div class="form-group">
              <input class="form-control" name="email" type="text" placeholder="Email" required>
            </div>
            <div class="form-group">
              <input class="form-control" name="subject" type="text" placeholder="Subject" required>
            </div>
            <div class="form-group">
              <textarea class="border form-control-plaintext" name="message" rows="8" placeholder="Message" required></textarea>
            </div>
            <div class="form-group">
              <input class="btn btn-block" type="submit" value="Submit">
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
          <form id="formNewsletter" name="formNewsletter" action="<?php echo$PH_BASE_PATH . '/subsave'; ?>"  method="post">
            <div class="form-group">
              <input class="form-control" type="text" placeholder="Name" name="name" required>
            </div>
            <div class="form-group">
              <input class="form-control" type="text" placeholder="Email" name="email" required>
            </div>
            <div class="form-group">
              <input class="form-control" type="text" placeholder="Country" name="country" required>
            </div>
            <div class="form-group">
              <textarea class="border form-control-plaintext" name="occupation" rows="8" placeholder="Occupation" required></textarea>
            </div>
            <div class="form-group">
              <input class="btn btn-block" type="submit" name="subscribe" value="Subscribe" >
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
