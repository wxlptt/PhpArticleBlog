<?php

namespace src\Controllers;

use core\Request;
use src\Repositories\UserRepository;

class LoginController extends Controller
{

	/**
	 * Show the login page.
	 * @return void
	 */
	public function index(): void
	{
		$this->render('login');
	}

	/**
	 * Process the login attempt.
	 * @param Request $request
	 * @return void
	 */
	public function login(Request $request): void
	{
        // Get request data.
		$email = $request->input('email');
        $password = $request->input('password');

        // Create instance of user repository.
        $userRepository = new UserRepository();

        // Get user.
        $user = $userRepository->getUserByEmail($email);
        if ($user === false) {
            $this->redirect("login?message=Email is invalid.", true);
        }

        // Verify password.
        if (password_verify($password, $user->password_digest)) {

            // After authentication, set session data.
            $_SESSION['authentication'] = true;
            $_SESSION['userId'] = $user->id;
            $_SESSION['profilePicture'] = $user->profile_picture;
            $_SESSION['userEmail'] = $user->email;
            $_SESSION['userName'] = $user->name;

            // Back to index page.
            $this->render("index");
        }
        else {
            $this->redirect("login?message=Password is invalid.", true);
        }
	}
}
