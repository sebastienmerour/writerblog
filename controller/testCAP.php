<?php
$postData = $statusMsg = '';
$status = 'error';

// If the form is submitted
if(isset($_POST['submit'])){
    $postData = $_POST;

    // Validate form fields
    if(!empty($_POST['name']) && !empty($_POST['email']) && !empty($_POST['message'])){

        // Validate reCAPTCHA box
        if(isset($_POST['g-recaptcha-response']) && !empty($_POST['g-recaptcha-response'])){
            // Google reCAPTCHA API secret key
            $secretKey = 'Your_reCAPTCHA_Secret_Key';

            // Verify the reCAPTCHA response
            $verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$secretKey.'&response='.$_POST['g-recaptcha-response']);

            // Decode json data
            $responseData = json_decode($verifyResponse);

            // If reCAPTCHA response is valid
            if($responseData->success){
                // Posted form data
                $name = !empty($_POST['name'])?$_POST['name']:'';
                $email = !empty($_POST['email'])?$_POST['email']:'';
                $message = !empty($_POST['message'])?$_POST['message']:'';

                // Send email notification to the site admin
                $to = 'admin@example.com';
                $subject = 'New contact form have been submitted';
                $htmlContent = "
                    <h1>Contact request details</h1>
                    <p><b>Name: </b>".$name."</p>
                    <p><b>Email: </b>".$email."</p>
                    <p><b>Message: </b>".$message."</p>
                ";

                // Always set content-type when sending HTML email
                $headers = "MIME-Version: 1.0" . "\r\n";
                $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
                // More headers
                $headers .= 'From:'.$name.' <'.$email.'>' . "\r\n";

                // Send email
                @mail($to,$subject,$htmlContent,$headers);

                $status = 'success';
                $statusMsg = 'Your contact request has submitted successfully.';
                $postData = '';
            }else{
                $statusMsg = 'Robot verification failed, please try again.';
            }
        }else{
            $statusMsg = 'Please check on the reCAPTCHA box.';
        }
    }else{
        $statusMsg = 'Please fill all the mandatory fields.';
    }
}
?>
