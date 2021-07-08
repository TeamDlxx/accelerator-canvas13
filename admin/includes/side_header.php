<ul class="navbar-nav flex-row ml-auto ">
    <li class="nav-item more-dropdown">
        <div class="dropdown  custom-dropdown-icon">
            <a class="dropdown-toggle btn" href="#" role="button" id="customDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span>Settings</span> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-down">
                    <polyline points="6 9 12 15 18 9"></polyline>
                </svg></a>

            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="customDropdown">
                <a class="dropdown-item" data-value="Logout" href="<?= $base_url ?>admin/modules/settings/change_email.php">Change Email</a>
                <a class="dropdown-item" data-value="Settings" href="<?= $base_url ?>admin/modules/settings/change_password.php">Change
                    password</a>
            </div>
        </div>
    </li>
</ul>