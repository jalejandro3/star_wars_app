<?php

namespace App\EventListener;

use App\Event\UserLoggedInEvent;
use App\Service\MailServiceInterface;

class UserLoggedInListener
{
    /**
     * @var MailServiceInterface
     */
    private MailServiceInterface $mailService;

    /**
     * @param MailServiceInterface $mailService
     */
    public function __construct(MailServiceInterface $mailService)
    {
        $this->mailService = $mailService;
    }

    /**
     * @param UserLoggedInEvent $event
     * @return void
     */
    public function onUserLoggedIn(UserLoggedInEvent $event)
    {
        $user = $event->getUser();
        $from = 'starwars-agileana@email.com';
        $options = [
            'subject' => "Star Wars Agileana App log in",
            'text' => "Hello {$user->getEmail()}, thanks for logged in! We hope you enjoy all the Star Wars movie information."
        ];

        $this->mailService->sendEmail($from, $user->getEmail(), $options);
    }
}
