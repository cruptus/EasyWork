<?php

namespace App;


class Config
{
    /* Application en mode debug */
    public static $DEBUG = false;

    /* Application en mode maintenance */
    public static $MAINTENANCE = false;


    /* Sociaux */
    /**
     * Lien Facebook
     * @var string
     */
    public static $FACEBOOK = "";
    /**
     * Lien Linkedin
     * @var string
     */
    public static $LINKEDIN = "";
    /**
     * Lien GitHub
     * @var string
     */
    public static $GITHUB = "";



    /* Google reCaptcha */
    /**
     * Clé du site
     * @var string
     */
    public static $CAPTCHA_WEBSITE = "";
    /**
     * Clé secrète
     * @var string
     */
    public static $CAPTCHA_PRIVATE = "";

    /* Mail */
    /**
     * Nom de domaine
     * @var string
     */
    public static $DOMAIN = '';
    /**
     * Mail de l'expéditeur
     * @var string
     */
    public static $FROM = '';

    /**
     * Nom de l'expéditeur
     * @var string
     */
    public static $FROM_NAME = '';

    /**
     * Mail de l'administrateur
     * @var string
     */
    public static $MAIL_ADMIN = '';

    /* Database */
    /**
     * Nom de la base
     * @var string
     */
    public static $DB_NAME = '';
    /**
     * Nom de l'utilisateur
     * @var string
     */
    public static $DB_USER = '';
    /**
     * Mot de passe
     * @var string
     */
    public static $DB_PASSWORD = '';
    /**
     * Host
     * @var string
     */
    public static $DB_HOST = '';

    /* Path de l'api REST */
    /**
     * Path de l'API REST
     * @var string
     */
    public static $PATH_REST = "";

}