<?php
namespace SM\Blog\Model;
require_once __DIR__ . '/../model/Manager.php';
class UserManager extends Manager
{

    // Create
    // Création d'un utilisateur :
    public function insertUser($username, $pass, $email)
    {

        // Récupération des valeurs saisies dans le formulaire :
        $errors    = array();
        $messages  = array();
        $username  = !empty($_POST['username']) ? trim($_POST['username']) : null;
        $avatar    = 'default.png';
        $firstname = '';
        $name      = '';
        $pass      = !empty($_POST['pass']) ? trim($_POST['pass']) : null;
        $email     = !empty($_POST['email']) ? trim($_POST['email']) : null;

        // On vérifie d'abord si l'identifiant choisi existe déjà ou non :

        // Préparation de la reqûete SQL et déclaration de la requête :
        $sql  = 'SELECT COUNT(id_user) AS num FROM users WHERE username = :username';
        $stmt = $this->dbConnect($sql, array(':username' => $username));


        // Associer le username fourni avec la déclaration :
        // $stmt->bindValue(':username', $username);

        // Execution :
        // $stmt->execute();
        $row = $stmt->fetch(\PDO::FETCH_ASSOC);

        // Si l'identifiant est déjà pris, on affiche une erreur.
        // Si row est supérieur à 0 cela veut dire que l'identifiant se trouve déjà en bdd :
        if ($row['num'] > 0) {
            $errors['username'] = 'Désolé, cet identifiant est déjà pris.<br>';
        }

        // Ensuite on vérifie si l'adresse mail possède un format valide :
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) { // L'adresse e-mail a-t-elle une forme valide ? Regex ou non ?
            $errors['email'] = 'Désolé, cette adresse e-mail n\'est pas valide.<br>';
        }

        if (empty($username) OR empty($pass) OR empty($email)) {
            $errors['field'] = 'Tous les champs ne sont pas renseignés !';
        }

        // Ensuite on vérifie si les 2 mots de passe sont identiques :
        if ($_POST['pass'] != $_POST['passcheck']) // Les deux mots de passe saisis sont-ils identiques ?
            {
            $errors['passdifferent'] = 'Désolé, les mots de passe ne correspondent pas !<br>';
        }

        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            die(header('Location: index.php?action=adduser'));
            exit;
        }

        // Maintenant, on hasshe le mot de passe, car on ne veut pas enregistrer
        // le vrai mot de passe dans la basse de données :
        $passwordHash = password_hash($pass, PASSWORD_BCRYPT, array(
            "cost" => 12
        ));

        // OK, le formulaire est OK, on peut alors insérer le nouveau membre :
        $sql2 = 'INSERT INTO users (status, username, firstname, name, avatar, pass, email, date_birth, date_register)
          VALUES (:status, :username, :firstname, :name, :avatar, :pass, :email, :date_birth, NOW())';
        $userLines                  = $this->dbConnect($sql2, array(
            ':status' => htmlspecialchars(0),
            ':username' => htmlspecialchars($username),
            ':firstname' => htmlspecialchars($firstname),
            ':name' => htmlspecialchars($name),
            ':avatar' => htmlspecialchars($avatar),
            ':pass' => htmlspecialchars($passwordHash),
            ':email' => htmlspecialchars($email),
            ':date_birth' => htmlspecialchars('1950-01-01 00:00:00')
        ));

        // Ici on affiche le message de confirmation :
        $messages['usercreated'] = 'Votre compte a bien été créé !';
        header('Location: index.php?action=adduser');
        if (!empty($messages)) {
            $_SESSION['messages'] = $messages;
            header('Location: index.php?action=adduser');
            exit;
        }

    }

    // Read

    // Affichage d'un utilisateur
    public function getUser($userId)
    {
        $sql   = 'SELECT id_user, username, firstname, name, avatar, pass, email, DATE_FORMAT(date_birth, \'%Y-%m-%d \')
      AS date_naissance FROM users WHERE id_user = :id_user';
        $query = $this->dbConnect($sql, array(':id_user' => $_SESSION['id_user']));
        $user = $query->fetch(\PDO::FETCH_ASSOC);
        return $user;
    }

    // Update
    // Modification d'un utilisateur :
    public function changeUser($username, $pass, $email, $firstname, $name, $date_naissance)
    {
        $errors         = array();
        $errorsmail     = array();
        $messages       = array();
        $identification = $_SESSION['id_user'];
        $username       = !empty($_POST['username']) ? trim($_POST['username']) : null;
        $pass           = !empty($_POST['pass']) ? trim($_POST['pass']) : null;
        $email          = !empty($_POST['email']) ? trim($_POST['email']) : null;
        $firstname      = !empty($_POST['firstname']) ? trim($_POST['firstname']) : null;
        $name           = !empty($_POST['name']) ? trim($_POST['name']) : null;
        $date_birth     = !empty($_POST['date_birth']) ? trim($_POST['date_birth']) : null;

        // Ensuite on vérifie si l'adresse mail possède un format valide :
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) { // L'adresse e-mail a-t-elle une forme valide ? Regex ou non ?
            $errorsmail['email'] = 'Désolé, cette adresse e-mail n\'est pas valide.<br>';
        }

        // Ensuite on vérifie si les 2 mots de passe sont identiques :
        if ($_POST['pass'] != $_POST['passcheck']) // Les deux mots de passe saisis sont-ils identiques ?
            {
            $errors['passdifferent'] = 'Désolé, les mots de passe ne correspondent pas !<br>';
        }
        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            die(header('Location: ?action=modifyuser'));
            exit;
        }
        if (!empty($errorsmail)) {
            $_SESSION['errorsmail'] = $errorsmail;
            die(header('Location: ?action=modifyuser'));
            exit;
        }
        // Maintenant, on hashe le mot de passe, car on ne veut pas enregistrer
        // le vrai mot de passe dans la basse de données :
        $passwordHash = password_hash($pass, PASSWORD_BCRYPT, array(
            "cost" => 12
        ));

        $sql     = 'UPDATE users
          SET pass = :pass, email= :email, firstname= :firstname, name= :name, date_birth= :date_birth
          WHERE id_user= :id_user';
        $newUser                   = $this->dbConnect($sql, array(
            ':id_user' => htmlspecialchars($identification),
            ':pass' => htmlspecialchars($passwordHash),
            ':email' => htmlspecialchars($email),
            ':firstname' => htmlspecialchars($firstname),
            ':name' => htmlspecialchars($name),
            ':date_birth' => htmlspecialchars($date_birth)
        ));

        // Ici on affiche le message de confirmation :
        $messages['userupdated'] = 'Votre compte a bien été mis à jour !';
        if (!empty($messages)) {
            $_SESSION['messages'] = $messages;
            header('Location: ?action=readuser');
            exit;
        }
    }

    // Modification d'un identifiant :
    public function changeUsername($username)
    {
        $errorsuser     = array();
        $messages       = array();
        $identification = $_SESSION['id_user'];
        $username       = !empty($_POST['username']) ? trim($_POST['username']) : null;
        $sql            = 'SELECT COUNT(id_user) AS num FROM users WHERE username = :username';
        $stmt           = $this->dbConnect($sql, array(
            ':username' => $username
        ));

        // On vérifie d'abord si l'identifiant choisi existe déjà ou non :

        // Associer le username fourni avec la déclaration :
        // $stmt->bindValue(':username', $username);

        // Execution :
        // $stmt->execute();
        $row = $stmt->fetch(\PDO::FETCH_ASSOC);
        // Si l'identifiant est déjà pris, on affiche une erreur.
        // Si row est supérieur à 0 cela veut dire que l'identifiant se trouve déjà en bdd :
        if ($row['num'] > 0) {
            $errorsuser['username'] = 'Désolé, cet identifiant est déjà pris.<br>';
        }

        if (!empty($errorsuser)) {
            $_SESSION['errorsuser'] = $errorsuser;
            die(header('Location: ?action=modifyusername'));
            exit;
        }
        $sql2 = 'UPDATE users
        SET username= :username
        WHERE id_user= :id_user';
        $userupdate = $this->dbConnect($sql2, array(
            ':id_user' => htmlspecialchars($identification),
            ':username' => htmlspecialchars($username)
        ));

        // Ici on affiche le message de confirmation :
        $messages['usernameupdated'] = 'Votre identifiant a bien été modifié !';
        if (!empty($messages)) {
            $_SESSION['messages'] = $messages;
            header('Location: ?action=modifyusername');
            exit;
        }
    }

    // Modification d'un avatar :
    public function changeAvatar($avatarname)
    {
        $user_id        = $_SESSION['id_user'];
        $sql            = 'UPDATE users
          SET avatar = :avatar
          WHERE id_user = :id_user';
        $avatarCreation = $this->dbConnect($sql, array(
            ':avatar' => htmlspecialchars($avatarname),
            ':id_user' => htmlspecialchars($user_id)
        ));
        $messages['avatarupdated'] = 'Votre avatar a bien été modifié !';
        if (!empty($messages)) {
            $_SESSION['messages'] = $messages;
            header('Location: ?action=readuser');
            exit;
        }
    }


    // Connexion et Déconnexion
    // Connexion d'un user :
    public function logInUser($username, $passwordAttempt)
    {
        // On vérifie que l'utilisateur a bien cliqué sur le bouton submit (nommé login) :

        if (isset($_POST['login'])) {

            // On récupère les valeurs saisies dans le formulaire de login :
            $username        = !empty($_POST['username']) ? trim($_POST['username']) : null;
            $passwordAttempt = !empty($_POST['pass']) ? trim($_POST['pass']) : null;

            // On prépare une requête pour aller chercher le username dans la BBD :
            $sql ='SELECT id_user, username, pass FROM users WHERE username = :username';
            $req = $this->dbConnect($sql, array('username' => $username));
            $resultat = $req->fetch();

            // On vérifie si le username existe : .
            if (!$resultat) { // si le resultat est False

                // on indique à l'utilisateur qu'il s'est trompé de username ou de mot de passe.
                // on ne précise pas qu'il s'agit du username qui est faux, pour raison de sécurité :
                $_SESSION['errMsg'] = "Identifiant ou Mot de passe incorrect!";
                header('Location: index.php');
            } else {

                // Sinon, si le username a bien été trouvé, il faut vérifier que le mot de passe est correct.
                // On récupère le mot de passe hashé dans la base, et on le déchiffre pour le comparer :

                $validPassword = password_verify($passwordAttempt, $resultat['pass']);


                // Si $validPassword est True (donc correct), alors la connexion est réussie :
                if ($validPassword) {

                    // On déclenche alors l'ouverture d'une session :
                    $_SESSION['id_user'] = $resultat['id_user'];
                    if (!empty($_POST['rememberme'])) {

                        setcookie("username", $_POST['username'], time() + 365 * 24 * 3600, null, null, false, true);
                        setcookie("pass", $_POST['pass'], time() + 365 * 24 * 3600, null, null, false, true);
                    } else {
                        if (ISSET($_COOKIE['username'])) {
                            setcookie("username", "");
                        }
                        if (ISSET($_COOKIE['pass'])) {
                            setcookie("pass", "");
                        }
                    }

                    // On redirige l'utilisateur vers la page protégée :
                    header('Location: ../user/index.php?action=readuser');
                    exit;

                } else {
                    // Dans le cas où le mot de passe est faux, on envoie un message :
                    $_SESSION['errMsg'] = "Identifiant ou Mot de passe incorrect !";
                    header('Location: index.php');
                }
            }
        }
    } // fin de logInUser


    // Connexion d'un Admin :

    public function logInUserAdmin($username, $passwordAttempt)
    {

        if(isset($_POST['login'])){

        // On récupère les valeurs saisies dans le formulaire de login :
        $username= !empty($_POST['username']) ? trim($_POST['username']) : null;
        $passwordAttempt = !empty($_POST['pass']) ? trim($_POST['pass']) : null;

        // On prépare une rquête pour aller chercher le username dans la BBD :
        $sql                     = 'SELECT id_user, status, username, pass FROM users WHERE username = :username';
        $req = $this->dbConnect($sql, array(
              'username' => $username));
        $resultat = $req->fetch();

        // On vérifie si le username existe : .
        if (!$resultat) {          // si le resultat est False

            // on indique à l'utilisateur qu'il s'est trompé de username ou de mot de passe.
            // on ne préciser pas qu'il s'agit du username qui est faux, pour raison de sécurité :
        $_SESSION['errMsg'] = "Identifiant ou Mot de passe incorrect !";
        header('Location: index.php');
        } else {

            // Sinon, si le username a bien été trouvé, il faut vérifier que le mot de passe est correct.
            // On récupère le mot de passe hashé dans la base, et on le déchiffre pour le comparer :

            $validPassword = password_verify($passwordAttempt, $resultat['pass']);
            $validAdmin = $resultat['status']==5 ;

            // Si $validPassword est True (donc correct), alors la connexion est réussie :
            if($validPassword && $validAdmin){

                // On déclenche alors l'ouverture d'une session :
                $_SESSION['id_user_admin'] = $resultat['id_user'];
                if(!empty($_POST['rememberme'])){

                  setcookie("username", $_POST['username'], time() + 365 * 24 *3600, null, null, false, true);
                  setcookie("pass", $_POST['pass'], time()+ 365 * 24 * 3600, null, null, false, true);
                }else{
                  if(ISSET($_COOKIE['username'])){
                    setcookie("username", "");
                  }
                  if(ISSET($_COOKIE['pass'])){
                    setcookie("pass", "");
                  }
                }

                // On redirige l'utilisateur vers la page protégée :
                header('Location: ../writeradmin/index.php?action=listitems');
                exit;

            } else{
                // Dans le cas où le mot de passe est faux, on envoie un message :
                $_SESSION['errMsg'] = "Vous n'êtes pas autorisés à accéder à l'administration !";
                header('Location: index.php');
            }
        }
    }
}


}
