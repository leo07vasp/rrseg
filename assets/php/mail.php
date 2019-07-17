<?php

    // Only process POST reqeusts.
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Get the form fields and remove whitespace.
        $first_name = strip_tags(trim($_POST["name"]));
				$first_name = str_replace(array("\r","\n"),array(" "," "),$first_name);
        $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
        
        $message = trim($_POST["message"]);

        // Check that data was sent to the mailer.
        if ( empty($first_name) OR !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            // Set a 400 (bad request) response code and exit.
            http_response_code(400);
            echo "Por favor complete seus dados.";
            exit;
        }

        // Set the recipient email address.
        // FIXME: Update this to your desired email address.
        $recipient = "contato@rrsegurancaltr.com.br";

        // Set the email subject.
        $subject = "Novo a partir do site, contato de $first_name";

        // Build the email content.
        $email_content = "Nome: $first_name\n";
        $email_content .= "Email: $email\n\n";
        $email_content .= "Mensagem:\n$message\n";

        // Build the email headers.
        $email_headers = "From: $first_name <$email>";

        // Send the email.
        if (mail($recipient, $subject, $email_content, $email_headers)) {
            // Set a 200 (okay) response code.
            http_response_code(200);
            echo "Obrigado sua mensagem foi enviada.";
        } else {
            // Set a 500 (internal server error) response code.
            http_response_code(500);
            echo "Oops! Algo errado aconteceu n«ªo conseguimos processar sua mensagem.";
        }

    } else {
        // Not a POST request, set a 403 (forbidden) response code.
        http_response_code(403);
        echo "Temos um problema e n«ªo conseguimos enviar sua mensagem.";
    }

?>
