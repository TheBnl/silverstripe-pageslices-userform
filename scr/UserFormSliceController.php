<?php
/**
 * UserFormSlice.php
 *
 * @author Bram de Leeuw
 * Date: 03/10/16
 */

use Broarm\PageSlices\PageSliceController;
use SilverStripe\UserForms\Control\UserDefinedFormController;
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
        /*
        Requirements::add_i18n_javascript(USERFORMS_DIR . '/javascript/lang');
        Requirements::combine_files('userformslice.js', array(
            USERFORMS_DIR . '/thirdparty/jquery-validate/jquery.validate.min.js',
            USERFORMS_DIR . '/javascript/UserForm.js'
        ));
        */

        $userform = $this->UserForm();
        $page = $userform->data();

        $userformController = new UserDefinedFormController($userform);
        $userformController->init();

        /*
        // load the css
        if (!$page->config()->get('block_default_userforms_css')) {
            Requirements::css('silverstripe/userforms:client/dist/styles/userforms.css');
        }

        // load the jquery
        if (!$page->config()->get('block_default_userforms_js')) {
            Requirements::javascript('//code.jquery.com/jquery-3.3.1.min.js');
            Requirements::javascript(
                'silverstripe/userforms:client/thirdparty/jquery-validate/jquery.validate.min.js'
            );
            Requirements::javascript('silverstripe/admin:client/dist/js/i18n.js');
            Requirements::add_i18n_javascript('silverstripe/userforms:client/lang');
            Requirements::javascript('silverstripe/userforms:client/dist/js/userforms.js');

            $userform->addUserFormsValidatei18n();

            // Bind a confirmation message when navigating away from a partially completed form.
            if ($page::config()->get('enable_are_you_sure')) {
                Requirements::javascript(
                    'silverstripe/userforms:client/thirdparty/jquery.are-you-sure/jquery.are-you-sure.js'
                );
            }
        }
        */


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
                return $this->userFormController = new UserDefinedFormController($this->UserForm());
            }
        }

        return $this->userFormController = null;
    }
}
