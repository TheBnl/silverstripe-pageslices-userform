<?php
/**
 * UserFormSlice.php
 *
 * @author Bram de Leeuw
 * Date: 03/10/16
 */

use Broarm\PageSlices\PageSliceController;
use SilverStripe\View\Requirements;

/**
 * Class UserFormSliceController
 *
 * @mixin UserFormSlice
 */
class UserFormSliceController extends PageSliceController
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