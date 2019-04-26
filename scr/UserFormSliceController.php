<?php

namespace Broarm\PageSlices;

use SilverStripe\Forms\Form;
use SilverStripe\UserForms\Control\UserDefinedFormController;

/**
 * Class UserFormSliceController
 *
 * @mixin UserFormSlice
 */
class UserFormSliceController extends PageSliceController
{
    /**
     * @var UserDefinedFormController
     */
    protected $userFormController;

    /**
     * Set up the requirements
     */
    public function init()
    {
        parent::init();
        $userform = $this->UserForm();
        $userformController = new UserDefinedFormController($userform);
        $userformController->init();
    }

    /**
     * Return the user form
     *
     * @return false|Form|null
     */
    public function getUserDefinedForm()
    {
        if ($userFormsController = $this->getUserFormController()) {
            return $userFormsController->Form();
        }

        return null;
    }

    /**
     * Get the user forms controller
     *
     * @return UserDefinedFormController
     */
    private function getUserFormController()
    {
        if ($this->userFormController) {
            return $this->userFormController;
        } else {
            if ($this->UserForm()->exists()) {
                return $this->userFormController = new UserDefinedFormController($this->UserForm());
            }
        }

        return $this->userFormController = null;
    }
}
