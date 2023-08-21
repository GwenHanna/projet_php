<?php
require_once './classes/Db.php';
require_once './classes/Errors.php';
require_once './classes/Utils.php';

class User
{
    private $id;
    private $firstname;
    private $lastname;
    private $pass;
    private $email;
    private $datecreated;
    private $picture;
    private $statut;
    private $birthday;
    private $locality;
    private $bio;
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    private function getPass($pass)
    {
        $connexion = $this->db->getConnect();

        $r = $connexion->prepare('SELECT `passWord` FROM `users` WHERE `passWord` = :pass');
        $r->bindParam(':pass', $pass, PDO::PARAM_STR);
        $r->execute();
        $user = $r->fetch();
    }

    /**
     * Connect function
     *
     * @param string $email
     * @param string $pass
     * @return array
     */
    public function connect(string $email, string $pass)
    {
        $connexion = $this->db->getConnect();

        $recipesStatment = $connexion->prepare('SELECT * FROM `users` WHERE `email` = :email');
        $recipesStatment->bindParam(':email', $email, PDO::PARAM_STR);
        $recipesStatment->execute();
        $user = $recipesStatment->fetch();

        if ($user === false) {
            Utils::redirect('connexion.php?error=' . Errors::ERR_CONNECT_EMAIL);
        } else if ($pass != $user['passWord']) {
            Utils::redirect('connexion.php?error=' . Errors::ERR_CONNECT_PASS);
        } else {
            echo "Vous êtes connecter";



            $this->id = $user['id'];
            $this->firstname = $user['firstname'];
            $this->lastname = $user['lastname'];
            $this->email = $user['email'];
            $this->email = $user['email'];
            $this->picture = $user['picture'];
            $this->statut = $user['statut'];
            $this->datecreated = $user['dateCreated'];
            $this->birthday = $user['birthday'];
            $this->locality = $user['locality'];
            $this->bio = $user['bio'];

            $_SESSION['user'] = [
                'id' => $this->id,
                'firstname' => $this->firstname,
                'lastname' => $this->lastname,
                'picture' => $this->picture,
                'statut' => $this->statut,
                'birthday' => $this->birthday,
                'bio' => $this->bio,
                'locality' => $this->locality,
                'email' => $this->email
            ];
            return $_SESSION['user'];
        }
    }

    /**
     * Recupere un utilisateur function
     *
     * @return array
     */
    public function getUser(): array
    {
        $connexion = $this->db->getConnect();
        $recipesStatment = $connexion->prepare('SELECT * FROM `users` ');
        $recipesStatment->execute();
        $user = $recipesStatment->fetchAll();
        return $user;
    }
}
