<?php 
    namespace Controllers;
    require 'vendor/autoload.php';
    use PHPMailer\PHPMailer\PHPMailer;

    class EmailController{
        private $email;

        public function __construct(){
            $this->mail = new PHPMailer;
            $this->mail->isSMTP();                           
            $this->mail->Host = 'smtp.gmail.com';            
            $this->mail->SMTPAuth = true;                    
            $this->mail->Username = 'lorenzocampanellaprueba@gmail.com';
            $this->mail->Password = 'LoloPrueba98*';
            $this->mail->SMTPSecure = 'tls';          
            $this->mail->Port = 587;                  
            $this->mail->setFrom('lorenzocampanellaprueba@gmail.com', 'UTN');
            $this->mail->addReplyTo('lorenzocampanellaprueba@gmail.com', 'UTN');
            $this->mail->isHTML(true); 
        }

        public function sendEmail($toemail, $subject, $message){
            $bodyContent = $message;
            $bodyContent = 'Student:';
            $bodyContent .='<p>'.$message.'</p>';
            $bodyContent .= 'UTN 2021 - '.date('Y');

            $this->mail->Body = $bodyContent;
            $this->mail->addAddress($toemail);   
            $this->mail->Subject = $subject;
            $message= null;
            if(!$this->mail->send())
                $message = "ENVIO INCORRECTO";
            else
                $message = "ENVIO CORRECTO";
        }
    }
?>