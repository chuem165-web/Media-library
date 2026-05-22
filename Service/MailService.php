<?php

use PHPMailer\PHPMailer\PHPMailer;

class MailService
    extends BaseService
{
    public function sendSuggestion(
        array $data
    ): void {

        $mail =
            new PHPMailer(
                true
            );

        $mail->isSMTP();

        $mail->Host =
            $this->env(
                'MAIL_HOST'
            );

        $mail->Port =
            $this->env(
                'MAIL_PORT'
            );

        $mail->SMTPAuth =
            true;

        $mail->Username =
            $this->env(
                'MAIL_USERNAME'
            );

        $mail->Password =
            $this->env(
                'MAIL_PASSWORD'
            );

        $mail->SMTPSecure =
            PHPMailer
                ::ENCRYPTION_SMTPS;

        $mail->setFrom(
            $this->env(
                'MAIL_FROM_EMAIL'
            ),

            $this->env(
                'MAIL_FROM_NAME'
            )
        );

        $recipient = $this->env(
            'MAIL_TO',
            $this->env('MAIL_FROM_EMAIL')
        );

        if (empty($recipient)) {
            throw new RuntimeException(
                'No recipient configured for outgoing mail.'
            );
        }

        $mail->addAddress($recipient);

        if (!empty($data['email'])) {
            $mail->addReplyTo(
                $data['email'],
                $data['name'] ?? ''
            );
        }

        $mail->isHTML(true);
        $mail->Subject = 'New media suggestion submitted';
        $mail->Body = sprintf(
            '<h1>New Suggestion</h1>
            <p><strong>Name:</strong> %s</p>
            <p><strong>Email:</strong> %s</p>
            <p><strong>Category:</strong> %s</p>
            <p><strong>Title:</strong> %s</p>
            <p><strong>Format:</strong> %s</p>
            <p><strong>Genre:</strong> %s</p>
            <p><strong>Year:</strong> %s</p>
            <p><strong>Details:</strong><br/>%s</p>',
            htmlspecialchars($data['name'], ENT_QUOTES | ENT_HTML5),
            htmlspecialchars($data['email'], ENT_QUOTES | ENT_HTML5),
            htmlspecialchars($data['category'], ENT_QUOTES | ENT_HTML5),
            htmlspecialchars($data['title'], ENT_QUOTES | ENT_HTML5),
            htmlspecialchars($data['format'], ENT_QUOTES | ENT_HTML5),
            htmlspecialchars($data['genre'], ENT_QUOTES | ENT_HTML5),
            htmlspecialchars($data['year'], ENT_QUOTES | ENT_HTML5),
            nl2br(htmlspecialchars($data['details'], ENT_QUOTES | ENT_HTML5))
        );
        $mail->AltBody = sprintf(
            "New Suggestion\nName: %s\nEmail: %s\nCategory: %s\nTitle: %s\nFormat: %s\nGenre: %s\nYear: %s\nDetails: %s",
            $data['name'],
            $data['email'],
            $data['category'],
            $data['title'],
            $data['format'],
            $data['genre'],
            $data['year'],
            $data['details']
        );

        $mail->send();
    }
}