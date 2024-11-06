<?php

class ContactFormCest 
{
    public function _before(\FunctionalTester $I)
    {
        $I->amOnRoute('site/contact');
    }

    public function openContactPage(\FunctionalTester $I)
    {
        $I->see('Связаться с нами', 'h1');        
    }

    public function submitEmptyForm(\FunctionalTester $I)
    {
        $I->submitForm('#contact-form', []);
        $I->expectTo('see validations errors');
        $I->see('Связаться с нами', 'h1');
        $I->see('Имя не может быть пустым');
        $I->see('Email не может быть пустым');
        $I->see('Тема не может быть пустой');
        $I->see('Сообщение не может быть пустым');
        $I->see('Код проверки введен неправильно');
    }

    public function submitFormWithIncorrectEmail(\FunctionalTester $I)
    {
        $I->submitForm('#contact-form', [
            'ContactForm[name]' => 'tester',
            'ContactForm[email]' => 'tester.email',
            'ContactForm[subject]' => 'тестовая тема',
            'ContactForm[body]' => 'тестовое содержание',
            'ContactForm[verifyCode]' => 'testme',
        ]);
        $I->expectTo('see that email address is wrong');
        $I->dontSee('Имя не может быть пустым', '.help-inline');
        $I->see('Email должен быть корректным адресом.');
        $I->dontSee('Тема не может быть пустой', '.help-inline');
        $I->dontSee('Сообщение не может быть пустым', '.help-inline');
        $I->dontSee('Код проверки введен неправильно', '.help-inline');        
    }

    public function submitFormSuccessfully(\FunctionalTester $I)
    {
        $I->submitForm('#contact-form', [
            'ContactForm[name]' => 'тестер',
            'ContactForm[email]' => 'tester@example.com',
            'ContactForm[subject]' => 'тестовая тема',
            'ContactForm[body]' => 'тестовое содержание',
            'ContactForm[verifyCode]' => 'testme',
        ]);
        $I->seeEmailIsSent();
        $I->dontSeeElement('#contact-form');
        $I->see('Спасибо за ваше сообщение. Мы ответим вам как можно скорее.');        
    }
}
