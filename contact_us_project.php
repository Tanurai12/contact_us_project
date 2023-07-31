<!--php file-->
<?php
 $nError=" ";
 $pError=" ";
 $eError=" ";
 $sError=" ";
 $mError=" ";
 $test="  ";
 function test_input($data) //use to make data proper 
 {
    
    $data=trim($data);
    $data=stripslashes($data);
    $data=htmlspecialchars($data);
    return $data;
 }
 
if(isset($_POST['submit'])) //check to submit
{
   //form validation---------------------

    if(empty($_POST['name']))
    {
        $nError="*required ";
    }
    else 
    {
        $name=test_input($_POST['name']);
        if(!preg_match("/^[a-zA-Z']*$/",$name))
        $nError="*Alphabet Only";

    }
    if(empty($_POST['phone']))
    {
        $pError="*required ";
    }
    if(empty($_POST['mail']))
    {
        $eError="*required ";
    }
    else 
    {
        $mail=test_input($_POST['mail']);
        if(!filter_var($mail,FILTER_VALIDATE_EMAIL))
        $eError="*Invalid mail";

    }
    if(empty($_POST['sub']))
    {
        $sError="*required ";
    }
    if(empty($_POST['msg']))
    {
        $mError="*required ";
    }


else  //if data entered properly then sent it into database------I used mysql
{

    $name=$_POST['name'];
    $phone=$_POST['phone'];
    $email=$_POST['mail'];
    $subject=$_POST['sub'];
    $message=$_POST['msg'];
     $con=mysqli_connect('localhost','root'); //connection to database
    mysqli_select_db($con,'db1');
   $q="INSERT INTO contact_form(name,phone,email,subject,message,time) VALUES('$name','$phone','$email','$subject','$message', CURRENT_TIME())";
    $t=mysqli_query($con,$q);
    if($t)
    {

       $test= "Data sent successfully";


 //code to sent mail to the user and owner both----------in my case, have some issue with port after updating window ..so unable to sent but this code is right I used it before
       $mailto="test@techsolvitservices.com"; //owner email address
       $from=$_POST['mail'];//sender email address
       $name=$_POST['name'];//user name
       $subject=$_POST['sub'];
       $subject2="Your message submitted successfully";//this is for client

       $message="client name:".$name."wrote the folloeing message".$_POST['msg'];//for owner
       $message2="Dear ".$name."Thank you for contacting us! we'll back to you shortly";//for client
       $headers="from :".$from; //to owner
       $headers2="from :".$mailto; //client receive
       $result=mail($mailto,$subject,$message,$headers); //send email to website owner
       $result2=mail($from,$subject2,$message2,$headers2);//send to user

       if(($result)&&(result2))//if mail sent properly----------------
       {
        echo "mail sennt !";
       }
       else
       {
       echo "failed to sent !!";

       }
    }
    else{
       $test= "something went wrong !";
    
    }

     mysqli_close($con);
    }

}
?>


<!--Form creation in HTML-->

<!DOCTYPE html>
<html >
<head>
    
    <title>Contact Form</title>
    <style>  

            /*little CSS here*/
        div{
           text-align: center;
            text-justify: auto;
            background-color: aqua;
            width: 500px;
            height: 500px;
            border-radius: 90px;
            margin-left: 450px;
            margin: auto;
            padding: 5px;
            padding-top: 20px;
            padding-right: 20px;
           
        
        }
        label{
            width: 100px;
            display:inline-block ;
        }
    
        body{
            background-color:pink;
        }
        span{
            color:red;

        }
        #test{
            text-align:center;
            color:green;
            text-justify: auto;
            margin-left: 630px;
            padding-top: 100px;
            font-size:30px;
        }
       </style>

</head>
<body>
<div id="form">
    <form method="post" action="  "> <!--Actual form here
         use action "  " means don't have to go other file and method is post to send data securely  -->
        
        <h2 style="text-decoration: underline;">Contact Us</h2>
        <label>Full Name:</label><input type="text" name="name"><br><span><?php echo $nError; ?></span><br><br>
        <label>Phone:</label><input type="number" name="phone"><br><span><?php echo $pError; ?></span><br><br>
        <label>Email Id:</label><input type="text" name="mail"><br><span><?php echo $eError; ?></span><br><br>
        <label>Subject:</label><textarea type="text" name="sub"></textarea><br><span><?php echo $sError; ?></span><br><br>
        <label>Message:</label><textarea type="text" name="msg" cols="20" rows="6"></textarea><br><span><?php echo $mError; ?></span><br><br>
        <span style="margin-left: 100px;" ><input type="submit" name="submit"><br><br></span>

    </form>
    
</div>
<span id=test ><?php echo $test  ?></span><!--to print if data submit successfiully-->
</body>
<!--THANK YOU!!
Tanu Kumari-->
</html>



