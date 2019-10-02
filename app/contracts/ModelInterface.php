<?php


namespace App\contracts;

interface ModelInterface
{
    /**
     * Make a new item
     *
     * @return bool
     */
    public function make();

    /**
     * Get a specific item
     *
     * @return object
     */
    public function get();

    /**
     * Get all items
     *
     * @return array
     */
    public function getAll();

    /**
     * Update a specific item
     *
     * @return bool
     */
    public function update();

    /**
     * Soft delete a specific item
     *
     * @return bool
     */
    public function softDelete();
}