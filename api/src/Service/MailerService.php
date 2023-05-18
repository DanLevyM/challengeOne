<?php

namespace App\Service;

use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mime\Address;

class ApiMailerService
{
    static function send_email($to, $subject, $text)
    {
        $email = (new TemplatedEmail())
            ->from(new Address('mkajeiou3@myges.fr', 'Cozy Challenge'))
            ->to($to)
            ->subject($subject)
            ->html($text);

        return $email;
    }
}