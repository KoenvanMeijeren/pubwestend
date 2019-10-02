<?php


namespace App\controllers\admin;


use App\contracts\ControllerInterface;
use App\model\admin\AdminDeveloper;
use App\services\core\Request;
use App\services\core\URL;

class AdminDeveloperController extends AdminDeveloper implements ControllerInterface
{
    /**
     * Overview of all the items.
     *
     * @return mixed
     */
    public function index()
    {
        $title = "Bestanden overzicht";
        $files = $this->getFiles();

        return view('admin/developer/index', compact('title', 'files'));
    }

    /**
     * Show the form to create a new item.
     *
     * @return mixed
     */
    public function create()
    {
        $title = "Developer modus";

        return view('admin/developer/create', compact('title'));
    }

    /**
     * Proceed the user call from the method create and store it in the database.
     *
     * @return mixed
     */
    public function store()
    {
        $request = new Request();
        $this->makeFile($request->file('file'));

        URL::redirect('/admin/developer');
        exit();
    }

    /**
     * Show a specific item.
     *
     * @return mixed
     */
    public function show()
    {
        // TODO: Implement show() method.
    }

    /**
     * Show the form to edit a specific item.
     *
     * @return mixed
     */
    public function edit()
    {
        // TODO: Implement edit() method.
    }

    /**
     * Update a specific item.
     *
     * @return mixed
     */
    public function update()
    {
        // TODO: Implement update() method.
    }

    /**
     * Soft delete a specific item.
     *
     * @return mixed
     */
    public function destroy()
    {
        // TODO: Implement destroy() method.
    }
}