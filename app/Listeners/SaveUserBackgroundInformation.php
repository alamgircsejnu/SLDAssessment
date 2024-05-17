<?php

namespace App\Listeners;

use App\Events\UserSaved;
use App\services\UserServiceInterface;

class SaveUserBackgroundInformation
{
    private UserServiceInterface $userService;
    private bool $called = true;

    /**
     * Create the event listener.
     */
    public function __construct(UserServiceInterface $userService)
    {
        $this->userService = $userService;
    }

    /**
     * Handle the event.
     */
    public function handle(UserSaved $event): void
    {
        $this->userService->saveUserDetails($event->user);
    }

    public function hasBeenCalled(): bool
    {
        return $this->called;
    }
}
