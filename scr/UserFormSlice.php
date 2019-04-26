<?php

namespace Broarm\PageSlices;

use SilverStripe\Forms\DropdownField;
use SilverStripe\UserForms\Model\UserDefinedForm;

/**
 * UserFormSlice
 *
 * @method UserDefinedForm UserForm
 */
class UserFormSlice extends PageSlice
{
    private static $table_name = 'UserFormSlice';

    private static $has_one = array(
        'UserForm' => UserDefinedForm::class
    );

    private static $slice_image = 'bramdeleeuw/silverstripe-pageslices-userform:images/UserFormSlice.png';

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
