<?php

namespace App\Service;

use App\Client\StarWarsClientInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class MailService extends Service implements MailServiceInterface
{
    /**
     * @var MailerInterface
     */
    private MailerInterface $mailer;

    /**
     * @param StarWarsClientInterface $starWarsClient
     * @param MailerInterface $mailer
     */
    public function __construct(
        StarWarsClientInterface $starWarsClient,
        MailerInterface $mailer
    )
    {
        parent::__construct($starWarsClient);
        $this->mailer = $mailer;
    }

    /**
     * @inheritDoc
     */
    public function sendEmail(string $from, string $to, array $options = [])
    {
        $email = new Email();

        $email->from($from)->to($to);

        foreach ($options as $option => $value) {
            if (method_exists($email, $option)) {
                $email->{$option}($value);
            }
        }

        $this->mailer->send($email);
    }
}
