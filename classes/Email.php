<?php
require_once './classes/Errors.php';

class EmailValidationException extends Exception
{
}
class EmailSpamExeption extends Exception
{
}

class Email
{

    const SPAM_DPMAINS = ['fake.com', 'spam.com'];

    private string $email;


    public function __construct(string $email)
    {
        if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
            throw new EmailValidationException(Errors::getCodes(Errors::ERR_VALIDATION_EMAIL));
        } elseif ($this->isSpam($email) === true) {
            throw new EmailSpamExeption(Errors::getCodes(Errors::ERR_SPAM_EMAIL));
        }
    }

    /**
     * Undocumented function
     *
     * @param string $email
     * @return boolean
     */
    private function isSpam(string $email): bool
    {
        $domain = explode('@', $email);
        return in_array($domain[1], self::SPAM_DPMAINS);
    }
}
