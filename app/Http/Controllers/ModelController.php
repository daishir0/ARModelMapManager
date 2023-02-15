<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateModelRequest;
use App\Http\Requests\UpdateModelRequest;
use App\Http\Controllers\AppBaseController;
use App\Repositories\ModelRepository;
use Illuminate\Http\Request;
use Flash;

class ModelController extends AppBaseController
{
    /** @var ModelRepository $modelRepository*/
    private $modelRepository;

    public function __construct(ModelRepository $modelRepo)
    {
        $this->modelRepository = $modelRepo;
    }

    /**
     * Display a listing of the Model.
     */
    public function index(Request $request)
    {
        $models = $this->modelRepository->paginate(10);

        return view('models.index')
            ->with('models', $models);
    }

    /**
     * Show the form for creating a new Model.
     */
    public function create()
    {
        return view('models.create');
    }

    /**
     * Store a newly created Model in storage.
     */
    public function store(CreateModelRequest $request)
    {
        $input = $request->all();

        $model = $this->modelRepository->create($input);

        Flash::success('Model saved successfully.');

        return redirect(route('models.index'));
    }

    /**
     * Display the specified Model.
     */
    public function show($id)
    {
        $model = $this->modelRepository->find($id);

        if (empty($model)) {
            Flash::error('Model not found');

            return redirect(route('models.index'));
        }

        return view('models.show')->with('model', $model);
    }

    /**
     * Show the form for editing the specified Model.
     */
    public function edit($id)
    {
        $model = $this->modelRepository->find($id);

        if (empty($model)) {
            Flash::error('Model not found');

            return redirect(route('models.index'));
        }

        return view('models.edit')->with('model', $model);
    }

    /**
     * Update the specified Model in storage.
     */
    public function update($id, UpdateModelRequest $request)
    {
        $model = $this->modelRepository->find($id);

        if (empty($model)) {
            Flash::error('Model not found');

            return redirect(route('models.index'));
        }

        $model = $this->modelRepository->update($request->all(), $id);

        Flash::success('Model updated successfully.');

        return redirect(route('models.index'));
    }

    /**
     * Remove the specified Model from storage.
     *
     * @throws \Exception
     */
    public function destroy($id)
    {
        $model = $this->modelRepository->find($id);

        if (empty($model)) {
            Flash::error('Model not found');

            return redirect(route('models.index'));
        }

        $this->modelRepository->delete($id);

        Flash::success('Model deleted successfully.');

        return redirect(route('models.index'));
    }
}
