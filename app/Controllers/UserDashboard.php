<?php

namespace App\Controllers;

use App\Models\SocialMediaLinkModel;
use CodeIgniter\HTTP\ResponseInterface;

class UserDashboard extends BaseController
{
    /** This function returns the ID of the currently logged in user. We don't check their role here.
     * @return int The ID of the currently logged in user.
     */
    private function getLoggedInUserId(): int
    {
        $session = session();
        return $session->get('user_id');
    }
}
