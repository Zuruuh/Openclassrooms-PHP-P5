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
    // ! USER LENGTH CONSTANTS

    public static $MAX_NAME_LENGTH = 64;
    public static $MAX_USERNAME_LENGTH = 32;
    public static $MIN_USERNAME_LENGTH = 3;
    public static $MAX_EMAIL_LENGTH = 64;
    public static $MAX_DESC_LENGTH = 255;
    public static $MAX_LOCATION_LENGTH = 48;
    public static $MAX_IMAGE_SIZE = 2048000;
    public static $MAX_MESSAGE_SIZE = 2048;

        // * USER ERROR MESSAGES

    public static $FIRST_NAME_TOO_LONG = "Votre prénom est trop long !";
    public static $FIRST_NAME_SPECIAL_CHARS = "Vous ne devez pas utiliser de charactères spéciaux dans votre prénom !";
    public static $FIRST_NAME_REQUIRED = "Vous devez entrer votre prénom";
    
    public static $LAST_NAME_TOO_LONG = "Votre nom est trop long !";
    public static $LAST_NAME_SPECIAL_CHARS = "Vous ne devez pas utiliser de charactères spéciaux dans votre nom !";
    public static $LAST_NAME_REQUIRED = "Vous devez entrer votre nom de famille !";

    public static $NAME_TOO_LONG = "Votre nom est trop long !";

    public static $USERNAME_TOO_SHORT = "Votre pseudonyme est trop court !";
    public static $USERNAME_TOO_LONG = "Votre pseudonyme est trop long !";
    public static $USERNAME_SPECIAL_CHARS = "Vous ne devez pas utiliser de charactères spéciaux dans votre pseudonyme !";
    public static $USERNAME_ALREADY_TAKEN = "Ce pseudonyme est déjà utilisé !";
    public static $USERNAME_REQUIRED = "Vous devez choisir un pseudonyme !";
    public static $OWN_USERNAME = "Vous devez choisir un nouveau pseudonyme..";
    public static $USERNAME_UPDATE_SUCCESS = "Pseudonyme mis à jour avec succès !";
    public static $USERNAME_SPACES = "Vous ne devez pas utiliser d'espaces dans votre pseudonyme !";
    
    public static $PASSWORD_CHARS = "Vous ne devez pas utiliser de charactères spéciaux dans votre mot de passe (<,>) !";
    public static $PASSWORD_DO_NOT_MATCH = "Vos 2 mots de passes ne correspondent pas !";
    public static $PASSWORD_REQUIRED = "Vous devez entrer un mot de passe et le confirmer !";
    public static $SINGLE_PASSWORD_REQUIRED = "Vous devez entrer votre mot de passe !";
    public static $OLD_PASSWORD_INCORRECT = "Votre ancien mot de passe n'est pas correct !";
    public static $PASSWORD_INCORRECT = "Votre mot de passe n'est pas correct !";

    public static $EMAIL_TOO_LONG = "Votre adresse mail est trop longue !";
    public static $EMAIL_INVALID = "Veuillez utiliser une adresse mail valide.";
    public static $EMAIL_ALREADY_IN_USE = "Cette adresse email est déjà liée à un compte";
    public static $EMAIL_REQUIRED = "Vous devez entrer une adresse mail valide !";
    
    public static $BIRTHDAY_REQUIRED = "Vous devez entrer une date de naissance valide !";
    
    public static $DESC_TOO_LONG = "Votre description est trop longue !";
    public static $DESC_SPECIAL_CHARS = "Vous ne devez pas utiliser de charactères spéciaux dans votre description !";
    
    public static $LOCATION_TOO_LONG = "Votre location est trop longue !";
    public static $LOCATION_SPECIAL_CHARS = "Vous ne devez pas utiliser de charactères spéciaux dans votre location !";
  
    public static $IMAGE_TYPE = "Votre image doit être au format JPEG ou PNG !";
    public static $IMAGE_TOO_HEAVY = "Votre image est trop lourde (Max 2Mo).";
    public static $DEFAULT_IMAGE = "assets/default.png";

    public static $USER_DO_NOT_EXIST = "Cet utilisateur n'existe pas !";
    public static $ALREADY_LOGGED_IN = "Vous êtes déjà connecté !";
    
    public static $REGISTER_SUCCESS = "Votre compte a été correctement crée !";
    public static $LOGIN_SUCCESS = "Vous vous êtes correctement connecté !";
    public static $LOGOUT_SUCCESS = "Vous vous êtes correctement déconnecté !";
    public static $USER_UPDATE_SUCCESS = "Compte mis à jour avec succès !";

    public static $EMAIL_NOT_USED = "Cette adresse mail ne correspond à aucun utilisateur !";
    public static $INVALID_CREDENTIALS = "Informations d’identification incorrectes";
    public static $INVALID_TOKEN = "Jeton d'authentification invalide, veuillez réessayer";
    public static $PASSWORD_CHANGE_SUCCESS = "Mot de passe modifié avec succès !"; 
    
    // ! POST CONSTANTS
    
    public static $MAX_POST_TITLE_LENGTH = 96;
    public static $MAX_POST_OVERVIEW_LENGTH = 255;
    public static $MAX_POST_TAGS_LENGTH = 128;
    public static $MAX_POST_CONTENT_LENGTH = 2048;

    // * POST ERROR MESSAGES
    
    public static $POST_TITLE_TOO_LONG = "Votre titre est trop long !";
    public static $POST_TITLE_SPECIAL_CHARS = "Votre titre ne doit pas contenir de charactères spéciaux (<,>) !";
    public static $POST_TITLE_REQUIRED = "Vous devez entrer un titre !";
    
    public static $POST_OVERVIEW_TOO_LONG = "Votre description est trop longue !";
    public static $POST_OVERVIEW_SPECIAL_CHARS = "Votre description ne doit pas contenir de charactères spéciaux (<,>) !";
    public static $POST_OVERVIEW_REQUIRED = "Vous devez entrer une description !";

    public static $POST_CONTENT_TOO_LONG = "Votre post est trop long !";
    public static $POST_CONTENT_SPECIAL_CHARS = "Votre contenu ne doit pas contenir de charactères spéciaux (<,>) !";
    public static $POST_CONTENT_REQUIRED = "Vous devez entrer un contenu pour votre post !";
    
    public static $POST_TAGS_TOO_LONG = "Vous utilisez trop de tags !";
    public static $POST_TAGS_SPECIAL_CHARS = "Vos tags ne doivent pas contenir de charactères spéciaux (<,>) !";
    
    public static $POST_DELETE_SUCCESS = "Post supprimé avec succès !";
    public static $POST_UPDATE_SUCCESS = "Post mis à jour avec succès !";
    public static $POST_SUCCESS = "Post crée avec succès !";
    public static $POST_DO_NOT_EXIST = "Ce post n'existe pas !";
    public static $POST_OWNER = "Ce post n'est pas le vôtre !";
    
    // ! COMMENTS CONSTANTS

    public static $MAX_COMMENT_LENGTH = 512;
    
    // * COMMENTS ERROR MESSAGES

    public static $COMMENT_UPDATE_SUCCESS = "Commentaire mis à jour !";
    public static $COMMENT_DELETE_SUCCESS = "Commentaire supprimé !";
    public static $COMMENT_DO_NOT_EXIST = "Ce commentaire n'existe pas !";
    public static $COMMENT_ALREADY_VERIFIED = "Ce commentaire a déjà été vérifié";
    public static $COMMENT_CONTENT_TOO_LONG = "Votre commentaire est trop long ! (512 charactères max)";
    public static $COMMENT_CONTENT_REQUIRED = "Vous devez inclure un contenu pour poster un commentaire..";
    public static $COMMENT_POSTED = "Votre commentaire a été correctement posté !";
    public static $COMMENT_POSTED_NOT_VERIFIED = "Votre commentaire a été correctement posté ! Il est désormais en attente de vérification manuelle.";
    public static $COMMENT_OWNER = "Ce commentaire n'est pas le vôtre !";
    
    // ! CONTACT CONSTANTS

    public static $SUBJECT_TOO_LONG = "Votre object est trop long !";
    
    public static $MESSAGE_TOO_LONG = "Votre message est trop long !";
    public static $CONTACT_SUCCESS = "Votre message à été correctement envoyé !";


    // ! BAN CONSTANTS
    
    public static $ACCOUNT_BANNED = "Compte Banni";
    public static $ACCOUNT_BANNED_ERROR = "Désolé, ce compte a été banni !";
    public static $REMOVED_ACCOUNT = "[removed]";
    public static $BAN_SUCCESS = "Ce compte a été correctement banni.";
    public static $SELF_BAN = "Vous ne pouvez pas vous bannir vous-même...";
    
    // ! PAGES CONSTANTS

    public static $USER_IS_NOT_ADMIN = "Désolé, cette page est réservée aux administrateurs.";
    public static $INVALID_SESSION = "Votre session est invalide ! Déconnectez-vous et reconnectez-vous, puis réessayez.";
    public static $MUST_BE_CONNECTED = "Vous devez être connecté pour accéder à cette page !";
    public static $EMAIL_SENT = "Un email vous a été envoyé !";

    // ! PARAMS CONSTANTS

    public static $MISSING_FIELD = "Vous devez remplir tous les champs !";
    public static $MISSING_USER_URL_PARAM = "Vous devez spécifier un utilisateur dans l'url pour accéder à cette page !";
    public static $MISSING_POST_URL_PARAM = "Vous devez spécifier un post dans l'url pour accéder à cette page !";
    public static $MISSING_COMMENT_URL_PARAM = "Vous devez spécifier un commentaire dans l'url pour accéder à cette page !";
    
}