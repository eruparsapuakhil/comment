<?php
$server="localhost";
$user="root";
$pass="";
$dbname="reviews";
$conn=mysqli_connect($server,$user,$pass,$dbname);

if(!$conn)
{
  die("connection failed:".mysqli_connect_error());
}
else {
    if(isset($_POST['submit']))
    {
    $name1=$_POST['name1'];
    $mail=$_POST['mail'];
    $comment=$_POST['cmnt'];
    if (!filter_var($mail,FILTER_VALIDATE_EMAIL)&&!preg_match("/^[a-zA-Z0-9 ]*$/",$name)) {
        header("Location:form.php?error=invalid");
          exit();
      }
      elseif(!filter_var($mail,FILTER_VALIDATE_EMAIL)){
        header("Location:form.php?error=invalidmail");
        exit();

      }
      elseif(!preg_match("/^[a-zA-Z0-9 ]*$/",$name)){
        header("Location:form.php?error=invalidname");
        exit();

      }
      else{
        $sql= "SELECT email FROM comment WHERE email=?";
        $stmt=mysqli_stmt_init($conn);
        if(!mysqli_stmt_prepare($stmt,$sql))
        {
          header("Location:form.php?error=sqlerror");
            exit();
        }
        else{
          mysqli_stmt_bind_param($stmt,"s",$mail);
          mysqli_stmt_execute($stmt);
          mysqli_stmt_store_result($stmt);
          $result=mysqli_stmt_num_rows($stmt);
          if($result>0)
          {
            header("Location:form.php?error=comnted");
              exit();
          }
          else{
            $sql="INSERT INTO comment(user,email,comment)VALUES(?,?,?)";

              $stmt=mysqli_stmt_init($conn);
              if(!mysqli_stmt_prepare($stmt,$sql))
              {
                header("Location:form.php?error=sqlerror");
                  exit();
              }
              else{
                mysqli_stmt_bind_param($stmt,"sss",$name1,$mail,$comment);
                mysqli_stmt_execute($stmt);
                header("Location:form.php?error=success");
                  exit();
              }
               
            }
    }
}
    }   


}
?>
