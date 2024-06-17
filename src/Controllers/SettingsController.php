<?php

namespace src\Controllers;

use core\Request;
use src\Repositories\UserRepository;

class SettingsController extends Controller
{
	/**
	 * @param Request $request
	 * @return void
	 */
	public function index(Request $request): void
	{
		$this->render('settings', [
			'user' => $_SESSION['userName']
		]);
	}

	/**
	 * @param Request $request
	 * @return void
	 */
	public function update(Request $request): void
	{
        // Get request data.
        $name = $request->input('name');

        // Create user repository instance.
        $userRepository = new UserRepository();

        // Check if the user update the profile picture.
        if (isset($_FILES['file'])) {
            $file = $_FILES['file'];
            $fileName = $file['name'];

            // Store the picture to server.
            $uploadPath= "images/$fileName";
            move_uploaded_file($file['tmp_name'], $uploadPath);

            // Update database.
            $userRepository->updateUser($_SESSION['userId'], $name, $fileName);

            // Update session data.
            $_SESSION['profilePicture'] = $fileName;
        }
        else{
            // Only update the user name.
            $userRepository->updateUser($_SESSION['userId'], $name, $_SESSION['profilePicture']);
        }
        $_SESSION['userName'] = $name;
        // Back to setting page.
        $this->render('settings');
	}
}
