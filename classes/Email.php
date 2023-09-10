<?php
require_once './classes/Errors.php';
require_once './classes/Config.php';
require_once './init/init.php';

class EmailValidationException extends Exception
{
}
class EmailSpamExeption extends Exception
{
}
class EmailAlreadyBdd extends Exception
{
}

class Email
{

    private string $email;
    private Db $dbInstance;

    /**
     * Construction de l'instance Email
     *
     * @param string $email
     * @param Db Instance de BDD
     * @throws EmailValidationException Vérification de l'email
     * @throws EmailSpamExeption Verification des spams
     * @throws EmailAlreadyBdd
     */
    public function __construct(string $email, Db $dbIntance)
    {
        $this->dbInstance = $dbIntance;
        if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
            throw new EmailValidationException(Errors::getCodes(Config::ERR_VALIDATION_EMAIL));
        } elseif ($this->isSpam($email) === true) {
            throw new EmailSpamExeption(Errors::getCodes(Config::ERR_SPAM_EMAIL));
        }
        $this->email = $email;
    }


    /******************************************* FONCTIONS ****************************************************************/

    /**
     * Envoie une Exeption si l'email est déja présente dans la BDD
     *
     * @throws EmailAlreadyBdd 
     * @param string $email
     * @return bool
     */
    public function isEmailDb($email): bool
    {
        $emails = $this->getEmailsDb();
        return in_array($email, $emails);
    }

    private function isSpam(string $email): bool
    {
        $domain = explode('@', $email);
        return in_array($domain[1], Config::SPAM_DOMAIN);
    }

    /******************************************* REQUETE SELECCTION ****************************************************************/

    public function isConfirmedConnection(string $pass): bool
    {
        $EmailAndPass = $this->getEmailAndPassword();
        $passwordHashed = $EmailAndPass['passWord'];

        return password_verify($pass, $passwordHashed);
    }

    /**
     * Récupère l'eamil et le password de l'itilisateur
     *
     *@return  array
     */
    private function getEmailAndPassword(): array|bool
    {
        $query = 'SELECT `email`, `passWord` FROM `users` WHERE users.email = :userEmail';

        $r = $this->dbInstance->getConnect()->prepare($query);
        $r->bindValue(':userEmail', $this->email, PDO::PARAM_STR);
        try {
            $r->execute();
            $res = $r->fetch(PDO::FETCH_ASSOC);
            return $res;
        } catch (PDOException  $e) {
            $error = $e->getMessage();
        }
    }

    /**
     * Récupération des emails dans la BDD
     *
     * @return array
     */
    private function getEmailsDb(): array
    {

        $query = 'SELECT email FROM users';
        $r = $this->dbInstance->getConnect()->prepare($query);
        $r->execute();

        //Récupération de tout les Emails dans un array 1 dimmension
        $emails = $r->fetchAll(PDO::FETCH_COLUMN);
        return $emails;
    }

    /**
     * Vérifie si un email est un spam 
     *
     * @param string $email
     * @return boolean
     */

    /******************************************* GETER ****************************************************************/

    /**
     * Récupère l'email de user
     *
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }
}
