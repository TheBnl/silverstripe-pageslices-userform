<?php
/**
 * UserFormSlice.php
 *
 * @author Bram de Leeuw
 * Date: 03/10/16
 */

use Broarm\PageSlices\PageSlice;
use SilverStripe\Forms\DropdownField;

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

        $selectUserForm = DropdownField::create(
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