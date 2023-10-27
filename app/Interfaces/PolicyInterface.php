<?php

namespace App\Interfaces;

/**
 * The PolicyInterface defines a contract for authorization policies.
 */
interface PolicyInterface
{

    /**
     * Determine whether the user can view any models.
     *
     * @return bool
     */
    public function findAllMatches();

    /**
     * Determine whether the user can view any models.
     *
     * @return bool
     */
    public function findAll();

    /**
     * Determine whether the user can view any models.
     *
     * @return bool
     */
    public function findOne();

    /**
     * Determine whether the user can create models.
     *
     * @return bool
     */
    public function create();

    /**
     * Determine whether the user can update models.
     *
     * @return bool
     */
    public function update();

    /**
     * Determine whether the user can delete the model.
     *
     * @return bool
     */
    public function delete();
}
