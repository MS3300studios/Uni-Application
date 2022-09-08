<?php
/**
 *
 * AdminServiceInterface,
 *
 */
namespace App\Service;

use App\Entity\Admin;

/**
 *
 * Interface AdminServiceInterface.
 *
 */
interface AdminServiceInterface
{
    /**
     * Save.
     *
     * @param Admin $admin
     * @return void
     *
     */
    public function save(Admin $Comment): void;
}