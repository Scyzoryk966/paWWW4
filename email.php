<?php

session_start();

function sanitize_my_email($field) {
    $field = filter_var($field, FILTER_SANITIZE_EMAIL);
    if (filter_var($field, FILTER_VALIDATE_EMAIL)) {
        return true;
    } else {
        return false;
    }
}
$to_email = $_SESSION['email'];
$subject = 'Testing PHP Mail';
$message = '
<html lang="pl">
<head>
<title>HTML email</title>
<style>
table {
    border-collapse: collapse;
    overflow-x: auto;
    color: black;
    width: auto;
}

th, td {
    text-align: left;
    padding: 8px;
}

</style>
</head>
<body>
<p>LISTA ZAKUPÓW:</p>
 <table border="1">
                <tr>
                    <th>Nazwa:</th>
                    <th>Ilość:</th>
                    <th>Cena:</th>
                </tr> 
               
';
$message .= $_POST['mail'];
$message .= '
</table>
</body>
</html>';
echo $message;
$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

// More headers
$headers .= 'From: <ListaZakupow@example.com>' . "\r\n";
$headers .= 'Cc: cc@example.com' . "\r\n";

mail($to,$subject,$message,$headers);
$secure_check = sanitize_my_email($to_email);
if ($secure_check == false) {
    $_SESSION['err_mail'] = "Invalid input";
    header('Location: index.php');
    exit();
} else { //send email
    mail($to_email, $subject, $message, $headers);
    $_SESSION['err_mail'] = "Lista została wysłana na e-mail.";
    header('Location: index.php');
    exit();
}
