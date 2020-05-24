<?php

class Faqs
{
    public function _before(\FunctionalTester $I)
    {
        $I->amOnRoute('site/faqs');
    }

    public function openLoginPage(\FunctionalTester $I)
    {
        $I->see('FAQs', 'h1');

    }
    public function contentPage(\FunctionalTester $I)
    {
        $I->see('¿El registro es obligatorio?', 'a');

    }


    // demonstrates `amLoggedInAs` method
    // public function internalLoginById(\FunctionalTester $I)
    // {
    //     $I->amLoggedInAs(1);
    //     $I->amOnPage('/');
    //     $I->see('Logout (admin)');
    // }

    // demonstrates `amLoggedInAs` method
   
}
