<?php

namespace App\Http\Livewire\Forms;

use App\Actions\Fortify\CreateNewUser;
use App\Actions\Fortify\ResetUserPassword;
use App\Models\User;
use Illuminate\Support\Arr;
use Tanthammar\TallForms\Input;
use Tanthammar\TallForms\TallFormComponent;

class UserForm extends TallFormComponent
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
            'wrapWithView' => true,
            'showDelete' => true,
        ];
    }

    // OPTIONAL methods, they already exist
    protected function onCreateModel($validated_data)
    {
        $this->model = (new CreateNewUser)->create($validated_data);
    }

    protected function onUpdateModel($validated_data)
    {
        if (
            $validated_data['password'] !== '' &&
            $validated_data['password'] !== null &&
            $validated_data['password'] !== ' ' &&
            $validated_data['password'] !== $this->model->password
        ) {
    
            (new ResetUserPassword)->reset($this->model, ['password' => $validated_data['password'], 'password_confirmation' => $validated_data['password']]);
        }

        $dataWithoutPassword = Arr::except($validated_data, ['password', 'password_confirmation']);

        $this->model->update($dataWithoutPassword);
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
            isset($this->model->id) ?
                Input::make('Password')->type('password')->rules('nullable') :
                Input::make('Password')->type('password')->rules('required|confirmed'),
            isset($this->model->id) ?
                null :
                Input::make('Password Confirmation')->type('password')->rules('required'),
        ];
    }
}
