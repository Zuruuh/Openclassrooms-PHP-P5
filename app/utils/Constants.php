<?php
/**
 * Form Validator Class File
 * Class for field validation
 * PHP version 8.0.9
 *
 * @category Utils
 * @package  Utils
 * @author   Younès Ziadi <ziadi.mail.pro@gmail.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     https://younes-ziadi.com/blog/
 */

namespace Utils;

/**
 * Form Validator Class
 * Class for field validation
 * PHP version 8.0.9
 *
 * @category Utils
 * @package  Utils
 * @author   Younès Ziadi <ziadi.mail.pro@gmail.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     https://younes-ziadi.com/blog/
 */
abstract class Constants
{

    public static $USER_EXIST = "User does not exist"; 
    public static $ENTITY_EXIST = "Entity does not exist"; 
    public static $DELETED_SUCCESS = "Entity was successfully deleted"; 
    public static $MISSING_PERMISSIONS = "You cannot do that !"; 

    // ! USER LENGTH CONSTANTS

    public static $MAX_NAME_LENGTH = 32;
    public static $MAX_USERNAME_LENGTH = 32;
    public static $MIN_USERNAME_LENGTH = 3;
    public static $MAX_EMAIL_LENGTH = 64;
    public static $MAX_DESC_LENGTH = 255;
    public static $MAX_LOCATION_LENGTH = 48;
    
        // * USER ERROR MESSAGES

    public static $FIRST_NAME_TOO_LONG = "Votre prénom est trop long !";
    public static $FIRST_NAME_SPECIAL_CHARS = "Vous ne devez pas utiliser de charactères spéciaux dans votre prénom (<,>,@) !";
    public static $FIRST_NAME_REQUIRED = "Vous devez entrer votre prénom";
    
    public static $LAST_NAME_TOO_LONG = "Votre nom est trop long !";
    public static $LAST_NAME_SPECIAL_CHARS = "Vous ne devez pas utiliser de charactères spéciaux dans votre nom (<,>,@) !";
    public static $LAST_NAME_REQUIRED = "Vous devez entrer votre nom de famille !";

    public static $USERNAME_TOO_SHORT = "Votre pseudonyme est trop court !";
    public static $USERNAME_TOO_LONG = "Votre pseudonyme est trop long !";
    public static $USERNAME_SPECIAL_CHARS = "Vous ne devez pas utiliser de charactères spéciaux dans votre pseudonyme (<,>,@) !";
    public static $USERNAME_ALREADY_TAKEN = "Ce pseudonyme est déjà utilisé !";
    public static $USERNAME_REQUIRED = "Vous devez choisir un pseudonyme !";
    
    public static $PASSWORD_CHARS = "Vous ne devez pas utiliser de charactères spéciaux dans votre mot de passe (<,>) !";
    public static $PASSWORD_DO_NOT_MATCH = "Vos 2 mots de passes ne correspondent pas !";
    public static $PASSWORD_REQUIRED = "Vous devez entrer un mot de passe et le confirmer !";
    public static $SINGLE_PASSWORD_REQUIRED = "Vous devez entrer votre mot de passe !";

    public static $EMAIL_TOO_LONG = "Votre adresse mail est trop longue !";
    public static $EMAIL_SPECIAL_CHARS = "Vous ne devez pas utiliser de charactères spéciaux dans votre adresse mail (<,>) !";
    public static $EMAIL_ALREADY_IN_USE = "Cette adresse email est déjà liée à un compte";
    public static $EMAIL_REQUIRED = "Vous devez entrer une adresse mail valide !";
    
    public static $BIRTHDAY_REQUIRED = "Vous devez entrer une date de naissance valide !";
    
    public static $DESC_TOO_LONG = "Votre description est trop longue !";
    public static $DESC_SPECIAL_CHARS = "Vous ne devez pas utiliser de charactères spéciaux dans votre description (<,>,@) !";
    
    public static $LOCATION_TOO_LONG = "Votre location est trop longue !";
    public static $LOCATION_SPECIAL_CHARS = "Vous ne devez pas utiliser de charactères spéciaux dans votre location (<,>,@) !";
    
    public static $INVALID_CREDENTIALS = "Informations d’identification incorrectes";
    // ! POST CONSTANTS

    public static $MAX_POST_TITLE_LENGTH = 96;
    public static $MAX_POST_OVERVIEW_LENGTH = 255;
    public static $MAX_POST_TAGS_LENGTH = 128;

        // * POST ERROR MESSAGES

    public static $POST_TITLE_TOO_LONG = "Votre titre est trop long !";
    public static $POST_TITLE_SPECIAL_CHARS = "Votre titre ne doit pas contenir de charactères spéciaux (<,>) !";
    public static $POST_TITLE_REQUIRED = "Vous devez entrer un titre !";

    public static $POST_OVERVIEW_TOO_LONG = "Votre description est trop longue !";
    public static $POST_OVERVIEW_SPECIAL_CHARS = "Votre description ne doit pas contenir de charactères spéciaux (<,>) !";
    public static $POST_OVERVIEW_REQUIRED = "Vous devez entrer une description !";

    public static $POST_CONTENT_SPECIAL_CHARS = "Votre contenu ne doit pas contenir de charactères spéciaux (<,>) !";
    public static $POST_CONTENT_REQUIRED = "Vous devez entrer un contenu pour votre post !";

    public static $POST_TAGS_TOO_LONG = "Vous utilisez trop de tags !";
    public static $POST_TAGS_SPECIAL_CHARS = "Vos tags ne doivent pas contenir de charactères spéciaux (<,>) !";
    

    // ! COMMENTS CONSTANTS

    public static $MAX_COMMENT_LENGTH = 512;

        // * COMMENTS ERROR MESSAGES

    public static $COMMENT_CONTENT_TOO_LONG = "Votre commentaire est trop long ! (512 charactères max)";
}