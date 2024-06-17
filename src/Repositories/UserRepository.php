<?php

namespace src\Repositories;

use src\Models\User;

class UserRepository extends Repository {

	/**
	 * @param string $id
	 * @return User|false
	 */
	public function getUserById(string $id): User|false {
        $sqlStatement = $this->pdo->prepare('SELECT * FROM users WHERE id=?;');
        $result = $sqlStatement->execute([$id]);
        $resultSet = $sqlStatement->fetch();
        if ($resultSet) {
            return new User($resultSet);
        }
		return false;
	}

    /**
     * @param string $name
     * @return User|false
     */
    public function getUserByName(string $name): User|false {
        $sqlStatement = $this->pdo->prepare('SELECT * FROM users WHERE name=?;');
        $result = $sqlStatement->execute([$name]);
        $resultSet = $sqlStatement->fetch();
        if ($resultSet) {
            return new User($resultSet);
        }
        return false;
    }

	/**
	 * @param string $email
	 * @return User|false
	 */
	public function getUserByEmail(string $email): User|false {
        $sqlStatement = $this->pdo->prepare('SELECT * FROM users WHERE email=?;');
        $result = $sqlStatement->execute([$email]);
        $resultSet = $sqlStatement->fetch();
        if ($resultSet) {
            return new User($resultSet);
        }
        return false;
	}

	/**
	 * @param string $passwordDigest
	 * @param string $email
	 * @param string $name
	 * @return User|false
	 */
	public function saveUser(string $name, string $email, string $passwordDigest): User|false {
        $defaultPicture = 'default.png';
        $sqlStatement = $this->pdo->prepare("INSERT INTO users (id, password_digest, email, name, description, profile_picture) VALUES(NULL, ?, ?, ?, NULL,?);");
        try {
            $success = $sqlStatement->execute([$passwordDigest, $email,  $name, $defaultPicture]);
            if ($success) {
                $userID = $this->pdo->lastInsertId();
                return $this->getUserById($userID);
            }
            else{
                return false;
            }
        }
        catch (PDOException) {
            return false;
        }
	}

	/**
	 * @param int $id
	 * @param string $name
	 * @param string|null $profilePicture
	 * @return bool
	 */
	public function updateUser(int $id, string $name, ?string $profilePicture = null): bool {
		$sqlStatement =$this->pdo->prepare("UPDATE users SET name = ?, profile_picture = ? WHERE id = ?;");
        return $sqlStatement->execute([$name, $profilePicture, $id]);
	}
}
