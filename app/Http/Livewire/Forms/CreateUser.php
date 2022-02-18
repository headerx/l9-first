<?php

namespace App\Http\Livewire\Forms;

use App\Actions\Fortify\CreateNewUser;
use App\Models\User;
use Hash;
use Psalm\Internal\PhpTraverser\CustomTraverser;
use Tanthammar\TallForms\Input;
use Tanthammar\TallForms\TallFormComponent;

class CreateUser extends TallFormComponent
{

    public function mount(?User $user)
    {
        //Gate::authorize()
        $this->mount_form($user); // $user from hereon, called $this->model
    }

    protected function formAttr(): array
    {
        return [
            'formTitle' => $this->transTitle(model: 'User'),
            'wrapWithView' => false,
            'showDelete' => false,
        ];
    }

    // OPTIONAL methods, they already exist
    protected function onCreateModel($validated_data)
    {
        $this->model = (new CreateNewUser)->create($validated_data);
    }

    protected function onUpdateModel($validated_data)
    {

        $this->model->update($validated_data);
    }

    protected function onDeleteModel()
    {
        $this->defaultDelete();
    }

    protected function fields(): array
    {
        return [
            Input::make('Name')->rules('required'),
            Input::make('Email')->rules('required'),
            Input::make('Password')->rules('required|confirmed'),
            Input::make('Password Confirmation')->rules('required'),
        ];
    }
}
