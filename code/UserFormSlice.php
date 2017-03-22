<?php
/**
 * UserFormSlice.php
 *
 * @author Bram de Leeuw
 * Date: 03/10/16
 */

use Broarm\Silverstripe\PageSlices\PageSlice;
use Broarm\Silverstripe\PageSlices\PageSliceController;

/**
 * UserFormSlice
 * @method UserForm UserForm
 */
class UserFormSlice extends PageSlice
{
    private static $has_one = array(
        'UserForm' => 'UserDefinedForm'
    );

    private static $slice_image = 'pageslices_userform/images/UserFormSlice.png';

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();

        $selectUserForm = new DropdownField(
            'UserFormID',
            _t('UserFormSlice.SELECT', 'Select Userform'),
            $this->availableUserForms()
        );
        $selectUserForm->setEmptyString(_t('UserFormSlice.SELECT', 'Select Userform'));

        $selectUserForm->setDescription(_t(
            'UserFormSlice.DESCRIPTION',
            'Select a form that you want to use in this slice'
        ));

        $fields->addFieldToTab('Root.Main', $selectUserForm);
        return $fields;
    }

    /**
     * Get the available user forms
     *
     * @return array
     */
    private function availableUserForms()
    {
        return UserDefinedForm::get()->map()->toArray();
    }
}

/**
 * Class UserFormSlice_Controller
 *
 * @mixin UserFormSlice
 */
class UserFormSlice_Controller extends PageSliceController
{
    /**
     * @var UserDefinedForm_Controller
     */
    protected $userFormController;

    /**
     * Set up the requirements
     */
    public function init()
    {
        parent::init();
        Requirements::add_i18n_javascript(USERFORMS_DIR . '/javascript/lang');
        Requirements::combine_files('userformslice.js', array(
            USERFORMS_DIR . '/thirdparty/jquery-validate/jquery.validate.min.js',
            USERFORMS_DIR . '/javascript/UserForm.js'
        ));
    }

    /**
     * Return the user form
     *
     * @return Form|Forms
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
     * @return UserDefinedForm_Controller
     */
    private function getUserFormController()
    {
        if ($this->userFormController) {
            return $this->userFormController;
        } else {
            if ($this->UserForm()->exists()) {
                return $this->userFormController = new UserDefinedForm_Controller($this->UserForm());
            }
        }

        return $this->userFormController = null;
    }
}