<?php

namespace src\Controllers;

class LogoutController extends Controller
{

	public function logout(): void
    {
        // Destroy session, back.
		$this->destroySession();
        $this->redirect('/',);
	}
}
