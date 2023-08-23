<?php

class Config
{

    //CONSTANTE INIT BDD
    const HOST = "host.docker.internal";
    const USER_NAME = "root";
    const PASSWORD = "";
    const DB_NAME_CITY = "france";
    const DB_NAME_APP = "mycomunnitylib";


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
