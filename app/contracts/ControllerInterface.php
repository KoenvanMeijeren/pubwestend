<?php

namespace App\contracts;

interface ControllerInterface
{
    /**
     * Overview of all the items.
     *
     * @return mixed
     */
    public function index();

    /**
     * Show the form to create a new item.
     *
     * @return mixed
     */
    public function create();

    /**
     * Proceed the user call from the method create and store it in the database.
     *
     * @return mixed
     */
    public function store();

    /**
     * Show a specific item.
     *
     * @return mixed
     */
    public function show();

    /**
     * Show the form to edit a specific item.
     *
     * @return mixed
     */
    public function edit();

    /**
     * Update a specific item.
     *
     * @return mixed
     */
    public function update();

    /**
     * Soft delete a specific item.
     *
     * @return mixed
     */
    public function destroy();
}
