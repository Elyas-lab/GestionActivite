<?php

namespace App\Exception;

use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;

class NotAuthorizedException extends CustomUserMessageAuthenticationException
{
    public function __construct(string $message = 'Utilisateur non autorisé.', array $messageData = [], int $code = 0, \Throwable $previous = null)
    {
        parent::__construct($message, $messageData, $code, $previous);
    }
}
