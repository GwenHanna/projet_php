<?php
require_once './classes/Errors.php';
require_once './classes/Config.php';
require_once './classes/Db.php';

class EmailValidationException extends Exception
{
}
class EmailSpamExeption extends Exception
{
}

class Email
{

    private string $email;


    /**
     * Construction de l'instance Email
     *
     * @param string $email
     * @throws EmailValidationException Vérification de l'email
     * @throws EmailSpamExeption Verification des spams
     */
    public function __construct(string $email)
    {
        if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
            throw new EmailValidationException(Errors::getCodes(Errors::ERR_VALIDATION_EMAIL));
        } elseif ($this->isSpam($email) === true) {
            throw new EmailSpamExeption(Errors::getCodes(Errors::ERR_SPAM_EMAIL));
        } else {
            $this->email = $email;
        }
    }

    public function isEmailBDD(string $email): bool
    {
        $users = $this->getEmailBDD();

        return in_array($email, $users);
    }

    /**
     * Récupération des emails dans la BDD
     *
     * @return array
     */
    private function getEmailBDD(): array
    {
        $db = new Db();
        $connexion = $db->getConnect();

        $r = $connexion->prepare('SELECT email FROM users');
        $r->execute();
        //Récupération de tout les Emails dans un array 1 dimmension
        $users = array_column($r->fetchAll(), 'email');

        return $users;
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
        return in_array($domain[1], Config::SPAM_DOMAIN);
    }

    public function getEmail(): string
    {
        return $this->email;
    }
}
