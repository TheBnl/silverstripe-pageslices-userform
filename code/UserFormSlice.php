<?php
/**
 * UserFormSlice.php
 *
 * @author Bram de Leeuw
 * Date: 03/10/16
 */


/**
 * UserFormSlice
 */
class UserFormSlice extends PageSlice
{

    private static $db = array(
        'Content' => 'HTMLText'
    );

    private static $has_one = array(
        'UserForm' => 'UserDefinedForm'
    );

    private static $slice_image = 'pageslices_userform/images/UserFormSlice.png';

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();

        if ($this->UserForm()->exists()) {
            $editFormButton = new LiteralField('EditForm', "<a href='{$this->UserForm()->CMSEditLink()}'>Edit form</a>");
            $fields->addFieldToTab('Root.Main', $editFormButton);
        }

        return $fields;
    }

    public function onBeforeWrite()
    {
        $this->setupUserForm();
        parent::onBeforeWrite();
    }

    public function onBeforeDelete()
    {
        $this->cleanupUserForm();
        parent::onBeforeDelete();
    }


    /**
     * Set up the user form for this slice
     */
    private function setupUserForm() {
        if (!$this->UserForm()->exists() && $userForm = UserDefinedForm::create()) {
            $userForm->setField('Title', "Form for {$this->getField('Title')} slice");
            $userForm->setField('ShowInMenus', 0);
            $userForm->setField('ShowInSearch', 0);
            $userForm->doPublish();
            $this->setField('UserFormID', $userForm->ID);
        }
    }


    /**
     * Clean up the user form when this slice is deleted
     */
    private function cleanupUserForm() {
        if ($this->UserForm()->exists()) {
            $this->UserForm()->doArchive();
        }
    }
}


class UserFormSlice_Controller extends PageSliceController
{

    private static $allowed_actions = array();

    /**
     * @var UserDefinedForm_Controller
     */
    protected $userFormController;


    /**
     * Return the user form
     *
     * @return Forms
     */
    public function getUserDefinedForm() {
        if ($userFormsController = $this->getUserFormController()) {
            return $userFormsController->Form();
        }

        return null;
    }


    /**
     * Get the user forms controller
     *
     * @return UserDefinedForm_Controller
     */
    private function getUserFormController() {
        if ($this->userFormController) {
            return $this->userFormController;
        } else if ($this->UserForm()->exists()) {
            return $this->userFormController = new UserDefinedForm_Controller($this->UserForm());
        }

        return $this->userFormController = null;
    }
}