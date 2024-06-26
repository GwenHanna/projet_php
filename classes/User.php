<?php
require_once './init/init.php';
require_once './classes/Config.php';
require_once './classes/Utils.php';
require_once './classes/File.php';

class EmailInvalidInsertionExeption extends Exception
{
}
class User
{
    private int|null $id;
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
    private $role;
    private Db $dbInstance;

    /**
     * Undocumented function
     *
     * @param Db $dbInstance
     */
    public function __construct(Db $dbInstance)
    {
        $this->dbInstance = $dbInstance;
    }



    /******************************************* REQUETE INSERTION ****************************************************************/

    /**
     * Insert les detail utilisateur (form 2) Non obligatoir a l'inscription
     *
     * @param string|null $bio
     * @param boolean $newsletter
     * @param string|null $address
     * @param string|null $locality
     * @param string|null $zipcode
     * @param [type] $birthday
     * @throws  EmailInvalidInsertionExeption
     * @return void
     */
    public function insertContactDetails(
        string $address,
        string $locality,
        string $zipcode,
        $birthday,
        string $bio = null,
        bool $newsletter = false,
    ): void {

        try {

            $lastIdUserBdd = $this->getLatestDbId();

            $query = 'UPDATE users
                SET   address = :address, locality = :locality, zipcode = :zipcode, birthday = :birthday, bio = :bio,newsletter = :newsletter
                WHERE id = :idUser';

            $r = $this->dbInstance->getConnect()->prepare($query);

            $r->bindValue(':newsletter', $newsletter, PDO::PARAM_BOOL);
            $r->bindValue(':address', $address, PDO::PARAM_STR);
            $r->bindValue(':locality', $locality, PDO::PARAM_STR);
            $r->bindValue(':zipcode', $zipcode, PDO::PARAM_STR);
            $r->bindValue(':birthday', $birthday, PDO::PARAM_STR);
            $r->bindValue(':bio', $bio, PDO::PARAM_STR);
            $r->bindValue(':idUser', $lastIdUserBdd, PDO::PARAM_INT);

            $r->execute();
        } catch (PDOException $th) {
            var_dump($th->getMessage());
            throw new EmailInvalidInsertionExeption(Errors::getCodes(Config::ERR_INSERT_USER));
        }
    }

    /**
     * Insertions des coordonnée obligatoire (form 1) function
     *
     * @param string $firstname
     * @param string $lastname
     * @param string $email
     * @param string $password
     * @throws EmailInvalidInsertionExeption Exeption en cas d'erreur a l'insertion des données utilisateur
     * @return void
     */
    public function insertContact(
        string $firstname,
        string $lastname,
        string $email,
        string $password
    ): void {
        $newDate = date("Y-m-d H:i:s");
        $statut = 'actif';
        $passHashed = password_hash($password, PASSWORD_DEFAULT);
        try {
            $query = 'INSERT INTO users (firstname, lastname, email, passWord, dateCreated ,statut) VALUES (:firstname, :lastname, :email, :password, :datecreated, :statut)';
            $r = $this->dbInstance->getConnect()->prepare($query);

            $r->bindValue(':firstname', $firstname, PDO::PARAM_STR);
            $r->bindValue(':lastname', $lastname, PDO::PARAM_STR);
            $r->bindValue(':email', $email, PDO::PARAM_STR);
            $r->bindValue(':password', $passHashed, PDO::PARAM_STR);
            $r->bindValue(':datecreated', $newDate);
            $r->bindValue(':statut', $statut);

            $r->execute();
        } catch (PDOException $e) {
            throw new EmailInvalidInsertionExeption(Errors::getCodes(Config::ERR_INSERT_USER));
        }
    }


    /******************************************* REQUETE SELECTION ****************************************************************/

    /**
     * Récupere le chemin de la photo de profile
     *
     * 
     */
    private function getProfilePicturePath()
    {
        $query = 'SELECT files.name FROM `users_has_files` INNER JOIN files ON files.id = users_has_files.Files_id INNER JOIN users ON users.id = users_has_files.Users_id WHERE users.id = :userId';


        $r = $this->dbInstance->getConnect()->prepare($query);
        $r->bindValue(':userId', $this->id, PDO::PARAM_INT);
        $r->execute();
        $pathFile = $r->fetch(PDO::FETCH_ASSOC);
        var_dump($pathFile);
        return $pathFile;
    }

    /**
     * Récupere le dernier id de l'utilisateur pour update le deuxième formulaire
     *
     * @return integer
     */
    private function getLatestDbId(): int
    {

        $query = 'SELECT MAX(id) FROM users';

        $r = $this->dbInstance->getConnect()->prepare($query);


        if ($r->execute()) {
            $result = $r->fetch(PDO::FETCH_ASSOC);
            $lastId = (int)$result['MAX(id)'];
            return $lastId;
        } else {
            var_dump('Erreur de co');
        }
    }


    /**
     * Recupere un utilisateur function
     *
     * @return array
     */
    public function getUser(): array
    {
        $query = 'SELECT * FROM `users` ';
        $r = $this->dbInstance->getConnect()->prepare($query);
        $r->execute();
        $user = $r->fetchAll();
        return $user;
    }

    /**
     * Connection Utilisateur function
     *
     * @param string $email
     * @param string $pass
     * @return array
     */
    public function connect(string $email, string $pass)
    {
        $connexion = $this->dbInstance->getConnect();

        $recipesStatment = $connexion->prepare('SELECT * FROM `users` WHERE `email` = :email');

        $recipesStatment->bindValue(':email', $email, PDO::PARAM_STR);
        $recipesStatment->execute();

        $user = $recipesStatment->fetch();


        if ($user === false) {
            Utils::redirect('conection.php?error=' . Config::ERR_CONNECT_EMAIL);
        } else if (!password_verify($pass, $user['passWord'])) {
            Utils::redirect('conection.php?error=' . Config::ERR_CONNECT_PASS);
        } else {
            session_start();
            echo "Vous êtes connecter";

            $this->id = $user['id'];
            $this->firstname = $user['firstname'];
            $this->lastname = $user['lastname'];
            $this->email = $user['email'];
            $this->statut = $user['statut'];
            $this->datecreated = $user['dateCreated'];
            $this->birthday = $user['birthday'];
            $this->locality = $user['locality'];
            $this->bio = $user['bio'];
            $this->role = $user['role'];

            try {
                $pathFilePictureProfile = $this->getProfilePicturePath();
            } catch (PDOException $e) {
                $errorMessageConnect =  $e->getMessage();
                var_dump($errorMessageConnect);
                exit;
            }
            //Récupération du chemin de la photo de profile

            $_SESSION['user'] = [
                'id' => $this->id,
                'firstname' => $this->firstname,
                'lastname' => $this->lastname,
                'picture' => $pathFilePictureProfile,
                'statut' => $this->statut,
                'birthday' => $this->birthday,
                'bio' => $this->bio,
                'locality' => $this->locality,
                'email' => $this->email,
                'role' => $this->role
            ];
            return $_SESSION['user'];
        }
    }
}
