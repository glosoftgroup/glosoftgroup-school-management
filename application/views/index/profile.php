<div class="col-md-12 whitebg">
    <?php
    $user = $this->ion_auth->get_user();
    ?> 
    <div class="row">
        <div class="col-md-4">

            <div class="widget">
                <div class="profile clearfix">
                    <div class="image sps center">
                        <?php echo theme_image('member.png', array('class' => "img-polaroid")); ?>
                    </div>                        
                    <div class="info-s">
                        <h2><?php echo trim($user->first_name . ' ' . $user->last_name); ?></h2>
                        <p><strong>&nbsp;</strong> </p>
                        <p><strong>Email:</strong> <?php echo $user->email; ?></p>
                        <p><strong>Phone:</strong> <?php echo $user->phone; ?></p>
                        <p><strong>Registration Date:</strong> <?php echo $user->created_on > 0 ? date('d M Y H:i', $user->created_on) : ' - '; ?></p>
                        <p><strong>Last Login:</strong> <?php echo $user->last_login > 0 ? date('d M Y H:i', $user->last_login) : 'Never'; ?></p>
                        <?php
                        //    foreach ($gs as $g)
                        //  {
                        ?>
                        <div class="status"><?php //echo rtrim($g->description, 's');   ?></div>
                        <?php //} ?>
                    </div>

                </div>
            </div>
        </div>

      

    </div>
</div>
<?php /* <div class="col-md-6">

  <div class="timeline">

  <div class="event">
  <div class="date red">15<span>min ago</span></div>
  <div class="icon"><span class="icos-comments3"></span></div>
  <div class="body">
  <div class="arrow"></div>
  <div class="head">Leave comment on <a href="img/examples/photo/example_3.jpg" class="fb">image</a>:</div>
  <div class="text">Really great!!! I like it! What kind of lens do you use???</div>
  </div>
  </div>


  <div class="event">
  <div class="date">18<span>April</span></div>
  <div class="icon"><span class="icos-user3"></span></div>
  <div class="body">
  <div class="arrow"></div>
  <div class="head">Change image to:</div>
  <div class="text">
  <?php echo theme_image('member.png', array('class' => "img-polaroid")); ?>
  </div>
  </div>
  </div>
  <div class="event">
  <div class="date">16<span>April</span></div>
  <div class="icon"><span class="icos-clipboard1"></span></div>
  <div class="body">
  <div class="arrow"></div>
  <div class="head">Add new article in <a href="#">category</a>:</div>
  <div class="text typography">
  <h5>Lorem ipsum dolor, sit amet</h5>
  <p>Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure.</p>
  <?php echo theme_image('examples/photo/example_7s.jpg', array('class' => "img-polaroid")); ?>
  </div>
  </div>
  </div>

  <div class="event">
  <div class="date">12<span>April</span></div>
  <div class="icon"><span class="icos-power"></span></div>
  <div class="body">
  <div class="arrow"></div>
  <div class="head">Request technical support:</div>
  <div class="text">
  I need MySQL dump! Quickly!!! Cause customers will kill me, if i don't give it...
  </div>
  </div>
  </div>

  <div class="event">
  <div class="icon"><span class="icos-arrow-down4"></span></div>
  <div class="body">
  <div class="arrow"></div>
  <div class="head"><a href="#">Older</a></div>
  </div>
  </div>

  </div>

  </div> */ ?>
 