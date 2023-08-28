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
    private static Email|null $emailIstance = null;

    /**
     * Construction de l'instance Email
     *
     * @param string $email
     * @param Db Instance de BDD
     * @throws EmailValidationException Vérification de l'email
     * @throws EmailSpamExeption Verification des spams
     */
    public function __construct(string $email, Db $dbIntance)
    {
        if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
            throw new EmailValidationException(Errors::getCodes(Config::ERR_VALIDATION_EMAIL));
        } elseif ($this->isSpam($email) === true) {
            throw new EmailSpamExeption(Errors::getCodes(Config::ERR_SPAM_EMAIL));
        } else {
            $this->email = $email;
            $this->dbInstance = $dbIntance;
        }
    }

    /**
     * Undocumented function
     *
     * @param Email $emailIstance
     * @param string $email
     * @param Db $dbInstance
     * @return Email
     */
    static function getInstance(string $email, Db $dbInstance): Email
    {
        if (self::$emailIstance === null) {
            return new self($email, $dbInstance);
        } else {
            return self::$emailIstance;
        }
    }

    /******************************************* FONCTIONS ****************************************************************/

    /**
     * Envoie une Exeption si l'email est déja présente dans la BDD
     *
     * @throws EmailAlreadyBdd 
     * @param string $email
     * @return bool
     */
    public function isEmailBDD(): bool
    {
        $users = $this->getEmailBDD();

        if (in_array($this->email, $users)) {
            return true;
        } else {
            return false;
        }
    }

    private function isSpam(string $email): bool
    {
        $domain = explode('@', $email);
        return in_array($domain[1], Config::SPAM_DOMAIN);
    }

    /******************************************* REQUETE SELECCTION ****************************************************************/

    public function isVerificationConnexion(string $pass): bool
    {
        $verif = $this->getEmailAndPassword();
        $passwordHashed = $verif['passWord'];

        return password_verify($pass, $passwordHashed);
    }

    /**
     * Récupère l'eamil et le password de l'itilisateur
     *
     *@return  array
     */
    private function getEmailAndPassword(): array
    {
        $querry = 'SELECT `email`, `passWord` FROM `users` WHERE users.email = :userId';

        $r = $this->dbInstance->getConnect()->prepare($querry);
        $r->bindParam(':userId', $this->email, PDO::PARAM_STR);
        var_dump($this->email);
        try {
            $r->execute();
            $res = $r->fetch(PDO::FETCH_ASSOC);
            var_dump($res);
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
    private function getEmailBDD(): array
    {
        // $db = new Db();
        // $connexion = $db->getConnect();

        $querry = 'SELECT email FROM users';
        $r = $this->dbInstance->getConnect()->prepare($querry);
        $r->execute();

        //Récupération de tout les Emails dans un array 1 dimmension
        $users = array_column($r->fetchAll(), 'email');

        return $users;
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
