<?php
require_once './classes/Db.php';
require_once './classes/Config.php';
require_once './classes/Utils.php';

class EmailInvalidInsertionExeption extends Exception
{
}
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



    /******************************************* REQUETE INSERTION ****************************************************************/

    public function InsertCoordannateDetails(
        string $bio = null,
        bool $newsletter = false,
        string $address = null,
        string $locality = null,
        string $zipcode = null,
        $birthday = null
    ): void {

        try {
            var_dump($bio);
            var_dump($newsletter);
            var_dump($address);
            var_dump($locality);
            var_dump($zipcode);
            var_dump($this->getLastIdBDD());

            $lastIdUserBdd = $this->getLastIdBDD();

            $query = 'UPDATE users
                SET bio = :bio, newsletter = :newsletter, address = :address, locality = :locality, zipcode = :zipcode, birthday = :birthday
                WHERE id = :idUser';

            echo "Values to insert:<br>";
            echo "bio: $bio<br>";
            echo "newsletter: $newsletter<br>";
            echo "address: $address<br>";
            echo "locality: $locality<br>";
            echo "zipcode: $zipcode<br>";
            echo "birthday: $birthday<br>";
            echo "idUser: $lastIdUserBdd<br>";

            $r = $this->db->conn->prepare($query);


            $r->bindParam(':bio', $bio, PDO::PARAM_STR);
            $r->bindParam(':newsletter', $newsletter, PDO::PARAM_BOOL);
            $r->bindParam(':address', $address, PDO::PARAM_STR);
            $r->bindParam(':locality', $locality, PDO::PARAM_STR);
            $r->bindParam(':zipcode', $zipcode, PDO::PARAM_STR);
            $r->bindParam(':birthday', $birthday, PDO::PARAM_STR);
            $r->bindParam(':idUser', $lastIdUserBdd, PDO::PARAM_INT);


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
    public function InsertCoordannat(
        string $firstname,
        string $lastname,
        string $email,
        string $password
    ): void {
        $newDate = date("Y-m-d H:i:s");
        $statut = 'actif';
        $passHashed = password_hash($password, PASSWORD_DEFAULT);
        try {
            $query = 'INSERT INTO users (firstname, lastname, email, passWord, dateCreated ,statut) VALUES (:firstname, :lastname, :email, :password, :datecreated,:statut)';
            $r = $this->db->prepare($query);

            $r->bindParam(':firstname', $firstname, PDO::PARAM_STR);
            $r->bindParam(':lastname', $lastname, PDO::PARAM_STR);
            $r->bindParam(':email', $email, PDO::PARAM_STR);
            $r->bindParam(':password', $passHashed, PDO::PARAM_STR);
            $r->bindParam(':datecreated', $newDate);
            $r->bindParam(':statut', $statut);

            $r->execute();
        } catch (PDOException $e) {
            print_r($r->errorInfo());
            throw new EmailInvalidInsertionExeption(Errors::getCodes(Config::ERR_INSERT_USER));
        }
    }




    /******************************************* REQUETE SELECTION ****************************************************************/

    private function getPictureUser(int $Files_id)
    {
        $querry = 'SELECT Files_id FROM users JOIN users_has_files ON Users_id = users_has_files.Users_id JOIN files ON Files_id = users_has_files.Files_id WHERE :Files_id = Users_id';

        $r = $this->db->conn->prepare($querry);
        $r->bindParam(':Files_id', $Files_id);
        //test verrification
        try {
            $r->execute();
            $result = $r->fetch();
            $picture = array_column($result, 'picture_profil');
            return $picture;
        } catch (PDOException $e) {
            $errorMessageConnect =  $e->getMessage();
            var_dump($errorMessageConnect);
        }
    }


    private function getLastIdBDD(): int
    {

        $querry = 'SELECT MAX(id) AS last_id FROM users';

        $connexion = $this->db->getConnect();

        $r = $connexion->prepare($querry);

        if ($r->execute()) {
            $result = $r->fetch();
            $lastId = (int)$result['last_id'];
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
        $connexion = $this->db->getConnect();
        $recipesStatment = $connexion->prepare('SELECT * FROM `users` ');
        $recipesStatment->execute();
        $user = $recipesStatment->fetchAll();
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
        $connexion = $this->db->getConnect();

        $recipesStatment = $connexion->prepare('SELECT * FROM `users` WHERE `email` = :email');

        $recipesStatment->bindParam(':email', $email, PDO::PARAM_STR);
        $recipesStatment->execute();

        $user = $recipesStatment->fetch();


        if ($user === false) {
            Utils::redirect('connexion.php?error=' . Config::ERR_CONNECT_EMAIL);
        } else if (!password_verify($pass, $user['passWord'])) {
            Utils::redirect('connexion.php?error=' . Config::ERR_CONNECT_PASS);
        } else {
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

            $_SESSION['user'] = [
                'id' => $this->id,
                'firstname' => $this->firstname,
                'lastname' => $this->lastname,
                'picture' => $this->getPictureUser($this->id),
                'statut' => $this->statut,
                'birthday' => $this->birthday,
                'bio' => $this->bio,
                'locality' => $this->locality,
                'email' => $this->email
            ];
            var_dump($this->getPictureUser($this->id));

            return $_SESSION['user'];
        }
    }
}
