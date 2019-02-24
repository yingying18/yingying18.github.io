<?php

// Set required fields
$required_fields = array('name','email');

// set error messages
$error_messages = array(
	'name' => 'Please enter a Name to proceed.',
	'email' => 'Please enter a valid Email Address to continue.',
);

// Set form status
$form_complete = FALSE;

// configure validation array
$validation = array();

// check form submittal
if(!empty($_POST)) {
	// Sanitise POST array
	foreach($_POST as $key => $value) {
            $_POST[$key] = remove_email_injection(trim($value));
        }
	
	// Loop into required fields and make sure they match our needs
	foreach($required_fields as $field) {		
		// the field has been submitted?
		if(!array_key_exists($field, $_POST)) {
                    array_push($validation, $field);
                }
		
		// check there is information in the field?
		if($_POST[$field] == '') {
                    array_push($validation, $field);
                }
		
		// validate the email address supplied
		if($field == 'email') {
                    if(!validate_email_address($_POST[$field])) {
                        array_push($validation, $field);
                    }
                }
	}
	
	// basic validation result
	if(count($validation) == 0) {
		// Prepare our content string
		$email_content = 'New Website Comment: ' . "\n\n";
		
		// simple email content
		foreach($_POST as $key => $value) {
                    if($key != 'submit') {
                        $email_content .= $key . ': ' . $value . "\n";
                    }
		}
		
		// if validation passed ok then send the email
		mail($email_to, $email_subject, $email_content);
		
		// Update form switch
		$form_complete = TRUE;
	}
}

function validate_email_address($email = FALSE) {
	return (preg_match('/^[^@\s]+@([-a-z0-9]+\.)+[a-z]{2,}$/i', $email))? TRUE : FALSE;
}

function remove_email_injection($field = FALSE) {
   return (str_ireplace(array("\r", "\n", "%0a", "%0d", "Content-Type:", "bcc:","to:","cc:"), '', $field));
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>
        <title>PHP Visitor Log Test</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="visitingLog.css">
        <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/mootools/1.3.0/mootools-yui-compressed.js"></script>
        <script type="text/javascript" src="validation.js"></script>
        <style type="text/css">
            #text {
                width: 68%;
                height: 63%;
                background: rgba(255, 0, 0, 0.3);
                overflow: auto;
            }
        </style>
        <style>
            body {
                background-image: url("http://www.nimsniche.com/wp-content/uploads/2015/06/website-design-background-images.jpeg");
                background-position: left top;
                background-size: 100% 100%;
                background-attachment: fixed;
            }
            ul.fixed {
                position: fixed;
                top: 230px;
                left: 130px;
                list-style: none;
                margin: 0;
                padding: 0;
                width: 10%;
                border-radius: 25px;
                background-color: transparent;
            }
            li a{
                display: block;
                color: red;
                padding: 8px 8px;
                text-align: center;
                text-decoration: none;
                
                border: 3px solid salmon;
            }
            li a:hover{
                background-color: darksalmon;
                color: white;
            }
            li a.active {
                background-color: crimson;
                color: white;
            }
            h1.fixed {
                position: fixed;
                top: 50px;
                left: 340px;
                color: red;
                width: 68%;
                height: 15%;
                text-align: center;
                font-size: 60px;
                font-weight: bold;
                font-style: italic;
                background-color: transparent;
            }
            div.fixed {
                position: fixed;
                top: 190px;
                left: 340px;
                color: black;
                width: 68%;
                height: 63%;
                border-radius: 25px;
                border: 2px solid crimson;
                padding: 10px;
                margin: 0;
                text-align: left;
                font-size: 20px;
                font-family: "Helvetica";
                background-color: transparent;
            }
        </style>
        <link rel="stylesheet" href="jquery.mCustomScrollbar.css"/>
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
        <script src="jquery.mCustomScrollbar.concat.min.js"></script>
        <script>
            (function($) {
                $(window).load(function() {
                    $("#text").mCustomScrollbar();
                });
            }) (jQuery);
        </script>
        <script type="text/javascript">
            var nameError = '<?php echo $error_messages['name']; ?>';
            var emailError = '<?php echo $error_messages['email']; ?>';
        </script>
    </head>
    <body>
        <ul class="fixed">
            <li><a href="index.html">Home</a></li>
            <li><a href="about.html">About</a></li>
            <li><a href="current.html">Current Work</a></li>
            <li><a id="color" class="active" href="visitorLog.php">Visitor Log</a></li>
        </ul>
        
        <h1 class="fixed">Visitor Form</h1>
        <div id="text" class="fixed">
            <div id="formWrap">
                <div id="form">
                    <?php if($form_complete === FALSE): ?>
                    <form action="visitorLog.php" method="post" id="comments_form">
                        <div class="row">
                            <div class="label">Name</div>
                            <div class="input">
                                <input type="text" id="name" class="detail" name="name" value="<?php echo isset($_POST['name'])? $_POST['name'] : ''; ?>" />
                                <?php if(in_array('name', $validation)): ?><span class="error"><?php echo $error_messages['name']; ?></span><?php endif; ?>
                            </div>
                        </div>

                        <!-- next -->

                        <div class="row">
                            <div class="label">Email</div>
                            <div class="input">
                                <input type="text" id="email" class="detail" name="email" value="<?php echo isset($_POST['email'])? $_POST['email'] : ''; ?>" />
                                <?php if(in_array('email', $validation)): ?><span class="error"><?php echo $error_messages['email']; ?></span><?php endif; ?>
                            </div>
                        </div>

                        <!-- next -->

                        <div class="row">
                            <div class="label">Comment</div>
                            <div class="input">
                                <textarea id="comment" name="comment" class="comm"></textarea>
                            </div>
                        </div>

                        <!-- next -->

                        <div class="submit">
                            <input type="submit" id="submit" name="submit" value="Submit"/>
                        </div>
                    </form>
                    <?php else: ?>
                    <p style="font-size: 35px; font-family: Arial, Helvetica, sans-serif; color: maroon">Thank you for visiting.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <div style="position: absolute; left: 5px; bottom: 5px">
            <img src="http://s3.narvii.com/image/iey3pe4x2pbwwfa5s6hf2daz6zrvtcef_hq.jpg" width="122" height="150" onclick="change()"/>
        </div>
        
        <script type="text/javascript">
            var myColors = ["crimson", "purple", "maroon", "lightbrown", "cadetblue", "cornflowerblue", "lightseagreen", "mistyrose", "plum", "palegreen", "maccasin", "violet"];
            var myImages = new Array ();
                myImages[1] = "http://www.nimsniche.com/wp-content/uploads/2015/06/website-design-background-images.jpeg";
                myImages[2] = "https://images.designtrends.com/wp-content/uploads/2016/03/01125050/Floral-Mauve-Butterfly-Pink-Background.jpg";
                myImages[3] = "https://wallpaperscraft.com/image/city_designs_background_light_66009_1920x1200.jpg";
                myImages[4] = "http://eskipaper.com/images/light-pink-wallpaper-4.jpg";
                myImages[5] = "http://www.pptgrounds.com/wp-content/uploads/2012/12/Colorful-Design-Floral-Vector-Illustration-PPT-Template.jpg";
                myImages[6] = "http://hd.1001christianclipart.com/wp-content/uploads/2014/12/ornament-christmas-snow-background.jpg";
                myImages[7] = "http://cdn26.us1.fansshare.com/photo/backgroundwallpapers/wallpapers-for-gt-purple-background-designs-purple-wallpaper-designs-for-walls-iphone-uk-bedroom-border-next-hd-background-wallpaper-design-1420655662.jpg";
                myImages[8] = "http://www.hdwallpapertec.com/wp-content/uploads/2015/06/Butterfly-Vector-Design-Background-HD-Wallpaper.jpg";
                myImages[9] = "http://down1.sucaitianxia.com/psd02/psd152/psds26252.jpg";
                myImages[10] = "http://img.phombo.com/img1/photocombo/833/cache/80_Abstract_Flowers_Design_Wallpapers_1920_X_1200__-2_display.jpg";
                myImages[11] = "http://www.wallhd4.com/wp-content/uploads/2015/04/butterfly-designs-wallpapers-hd-15.jpeg";
                myImages[12] = "https://image.freepik.com/free-vector/wooden-floor-and-butterflies_1048-1524.jpg";
            function change() {
                var rand = Math.floor(Math.random() * myImages.length);
                if (rand === 0) {
                    rand = 1;
                }
                document.getElementsByTagName("body")[0].setAttribute('style','background-image:url(' +myImages[rand]+ ')');
                
                var rnd = Math.floor(Math.random() * myColors.length);
                document.getElementById("color").style.backgroundColor = myColors[rnd];
                
            }
        </script>
        
    </body>
</html>

