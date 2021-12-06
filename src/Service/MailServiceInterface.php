<?php

namespace App\Service;

use Symfony\Component\Mailer\Exception\TransportExceptionInterface;

interface MailServiceInterface
{
    /**
     * @param string $from
     * @param string $to
     * @param array $options
     * @return void
     * @throws TransportExceptionInterface
     */
    public function sendEmail(string $from, string $to, array $options = []);
}
