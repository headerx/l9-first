<?php

namespace App\Http\Livewire\Forms;

use App\Models\Role;
use Tanthammar\TallForms\Input;
use Tanthammar\TallForms\TallFormComponent;

class RoleForm extends TallFormComponent
{
    public function mount(?Role $role)
    {
        //Gate::authorize();
        $this->mount_form($role); // $role from hereon, called $this->model
    }

    protected function formAttr(): array
    {
        $role = $this->model;

        return [
            'formTitle' => 'Create & Edit Role',
            'wrapWithView' => true, //see https://github.com/tanthammar/tall-forms/wiki/installation/Wrapper-Layout
            'showSave' => true,
            'showReset' => true,
            'showDelete' => $role->exists ? true : false, //see https://github.com/tanthammar/tall-forms/wiki/Form-Methods#delete
            'showGoBack' => true,
        ];
    }

    // REQUIRED, if you are creating a model with this form
    protected function onCreateModel($validated_data)
    {
        $this->model = Role::create($validated_data);
        $role = $this->model;
        $this->showDelete = true;
    }

    // OPTIONAL, method exists in tall-form component
    protected function onUpdateModel($validated_data)
    {
        $this->model = Role::create($validated_data);
        $role = $this->model;
        $this->showDelete = true;
    }

    // OPTIONAL, method exists in tall-form component
    protected function onDeleteModel()
    {
        $role = $this->model;
        $this->model->delete();

        return redirect()->route('role.index');
    }

    protected function fields(): array
    {
        return [

            Input::make('Name')
                ->rules(['required', 'string']),
        ];
    }
}
