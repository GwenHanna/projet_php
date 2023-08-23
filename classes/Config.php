<?php

class Config
{

    //CONSTANTE ERROR
    public const ERR_CONNECT_EMAIL = 1;
    public const ERR_CONNECT_PASS = 2;
    public const ERR_VALIDATION_EMAIL = 3;
    public const ERR_SPAM_EMAIL = 4;
    public const ERR_ALREADY_EMAIL = 5;
    public const ERR_VALIDATE_PASS = 6;
    public const ERR_CONFIRMED_PASS = 7;
    public const ERR_FORMAT_PICTURE = 8;
    public const ERR_INSERT_USER = 9;



    //CONSTANTE SUCCESS
    public const SUCC_INSERT_USER = 100;


    const SPAM_DOMAIN = [
        'fake.com',
        'spam.com'
    ];

    const FORMAT_PICTURE =
    [
        'jpg',
        'jpeg',
        'png'
    ];
}
