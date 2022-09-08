<?php

/**
 * Admin service.
 */

namespace App\Service;

use App\Entity\Admin;
use App\Repository\AdminRepository;

/**
 * Class AdminService.
 */
class AdminService implements AdminServiceInterface
{
    /**
     * Admin repository.
     */
    private AdminRepository $adminRepository;

    /**
     * Constructor.
     *
     * @param AdminRepository     $adminRepository Admin repository
     */
    public function __construct(AdminRepository $adminRepository)
    {
        $this->adminRepository = $adminRepository;
    }

    /**
     * Save admin.
     *
     * @param Admin $admin
     *
     * @return void
     */
    public function save(Admin $admin): void
    {
        $this->adminRepository->add($admin);
    }
}