<?php

namespace App\Http\Livewire\Forms;

use App\Models\Permission;
use Tanthammar\TallForms\Input;
use Tanthammar\TallForms\TallFormComponent;

class PermissionForm extends TallFormComponent
{
    public function mount(?Permission $permission)
    {
        //Gate::authorize();
        $this->mount_form($permission); // $permission from hereon, called $this->model
    }

    protected function formAttr(): array
    {
        $permission = $this->model;

        return [
            'formTitle' => 'Create & Edit Permission',
            'wrapWithView' => true, //see https://github.com/tanthammar/tall-forms/wiki/installation/Wrapper-Layout
            'showSave' => true,
            'showReset' => true,
            'showDelete' => $permission->exists ? true : false, //see https://github.com/tanthammar/tall-forms/wiki/Form-Methods#delete
            'showGoBack' => true,
        ];
    }

    // REQUIRED, if you are creating a model with this form
    protected function onCreateModel($validated_data)
    {
        $this->model = Permission::create($validated_data);
        $permission = $this->model;
        $this->showDelete = true;
    }

    // OPTIONAL, method exists in tall-form component
    protected function onUpdateModel($validated_data)
    {
        $this->model = Permission::create($validated_data);
        $permission = $this->model;
        $this->showDelete = true;
    }

    // OPTIONAL, method exists in tall-form component
    protected function onDeleteModel()
    {
        $permission = $this->model;
        $this->model->delete();

        return redirect()->route('permission.index');
    }

    protected function fields(): array
    {
        return [
            Input::make('Name')
                ->rules(['required', 'string']),

            Input::make('Guard name')
                ->rules(['required', 'string']),
        ];
    }
}
