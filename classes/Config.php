<?php

class Config
{

    //CONSTANTE DE DIR
    public  const DIR_FILE_PICTURE = './uploads/picture_profile/';

    //CONSTANTE ERROR
    public const ERR_CONNECT_EMAIL = 1;
    public const ERR_SPAM_EMAIL = 2;
    public const ERR_VALIDATION_EMAIL = 3;
    public const ERR_ALREADY_EMAIL = 4;

    public const ERR_CONNECT_PASS = 51;
    public const ERR_VALIDATE_PASS = 52;
    public const ERR_CONFIRMED_PASS = 53;


    public const ERR_FORMAT_PICTURE = 101;
    public const ERR_INSERT_USER = 102;
    public const ERR_NOT_SIGN_IN = 103;

    public const ERR_DOUBLE_FILE = 151;


    //CONSTANTE SUCCESS
    public const SUCC_INSERT_USER = 200;
    public const SUCC_INSERT_PUBLICATION = 201;

    //Constante spam
    const SPAM_DOMAIN = [
        'fake.com',
        'spam.com'
    ];

    //constante format picture
    const FORMAT_PICTURE =
    [
        'jpg',
        'jpeg',
        'png'
    ];
}
