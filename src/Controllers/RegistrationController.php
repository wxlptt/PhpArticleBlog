<?php

namespace src\Controllers;

use core\Request;
use PDOException;
use src\Repositories\UserRepository;

class RegistrationController extends Controller
{

	/**
	 * @return void
	 */
	public function index(): void
	{
		$this->render('register');
	}

    /**
     * @param $password
     * The password input by user.
     * @return string|true
     */
    private function validatePassword($password): string|true
    {
        // Check the password, it should be more than 8 letters.
        if (strlen($password) <= 8) {
            return "Password must be longer than 8 letters";
        }

        // Check the password, it should have at lease one symbol.
        if (!preg_match('/[^a-zA-Z0-9]/', $password)) {
            return "Password must contain at least one symbol";
        }

        return true;
    }

    /**
     * @param $email
     * The email input by user.
     * @return string|true
     */
    private function validateEmail($email): string|true
    {
        // Verify email format.
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return "Email is invalid.";
        }
        else{
            return true;
        }
    }

    /**
     * TODO
     * Check if the user name is repetitive in database.
     * Check the length of user name.
     */
    private function validateName($name): string|true
    {
        $userRepository = new UserRepository();
        $user = $userRepository->getUserByName($name);

        // Verify name format.
        if (strlen($name) <= 5) {
            return "Name must be longer than 5 letters";
        }
        elseif ($user !== false) {
            return "The user name is repetitive.";
        }
        else{
            return true;
        }
    }

	public function register(Request $request): void
	{
        // Get request data.
		$name = $request->input('name');
        $email = $request->input('email');
        $password = $request->input('password');

        // Check name, email, and password.
        $checkName = $this->validateName($name);
        $checkEmail = $this->validateEmail($email);
        $checkPassword = $this->validatePassword($password);

        // If the format is invalid, redirect to register page with message.
        if ($checkEmail !== true) {
            $this->redirect("register?name=$name&email=$email&message=$checkEmail", true);
        }
        elseif ($checkName !== true) {
            $this->redirect("register?name=$name&email=$email&message=$checkName", true);
        }
        elseif ($checkPassword !== true) {
            $this->redirect("register?name=$name&email=$email&message=$checkPassword", true);
        }

        // Encrypt password.
        $bcryptPasswordDigest = password_hash($password, PASSWORD_BCRYPT, ['cost' => 10]);

        // Store new user to user repository.
        $userRepository = new UserRepository();
        $user = $userRepository->saveUser($name, $email, $bcryptPasswordDigest);

        // Store the relate information to session.
        $_SESSION['authentication'] = true;
        $_SESSION['userId'] = $user->id;
        $_SESSION['profilePicture'] = $user->profile_picture;
        $_SESSION['userEmail'] = $user->email;
        $_SESSION['userName'] = $user->name;

        // Go to index page.
        $this->render('index');
	}
}
