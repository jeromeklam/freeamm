<?php
namespace FreeFW;

/**
 * Constantes générales
 */
class Constants
{

    /**
     * Langues
     * @var string
     */
    const LANG_FR      = 'FR';
    const LANG_EN      = 'EN';
    const LANG_DE      = 'DE';
    const LANG_ES      = 'ES';
    const LANG_ID      = 'ID';
    const LANG_DEFAULT = 'FR';

    /**
     * Locales
     * @var string
     */
    const LOCALE_FR = 'FR_FR';
    const LOCALE_US = 'EN_US';

    /**
     * Monnaies
     * @var string
     */
    const CURRENCY_EURO   = 'EUR';
    const CURRENCY_DOLLAR = 'USD';

    /**
     * Routes events
     *
     * @var string
     */
    const EVENT_ROUTE_NOT_FOUND    = 'not-found';
    const EVENT_COMMAND_NOT_FOUND  = 'not-found';
    const EVENT_BEFORE_FINISH      = 'app-before-finish';
    const EVENT_AFTER_RENDER       = 'app-after-render';
    const EVENT_INCOMPLETE_REQUEST = 'app-inc-request';

    /**
     * Types d'objets
     * @var string
     */
    const TYPE_STRING             = 'STRING';
    const TYPE_MD5                = 'MD5';
    const TYPE_PASSWORD           = 'PASSWORD';
    const TYPE_TEXT               = 'TEXT';
    const TYPE_TEXT_HTML          = 'TEXT_HTML';
    const TYPE_BLOB               = 'BLOB';
    const TYPE_JSON               = 'JSON';
    const TYPE_DATE               = 'DATE';
    const TYPE_DATETIME           = 'DATETIME';
    const TYPE_BIGINT             = 'BIGINT';
    const TYPE_BOOLEAN            = 'BOOLEAN';
    const TYPE_INTEGER            = 'INTEGER';
    const TYPE_DECIMAL            = 'DECIMAL';
    const TYPE_MONETARY           = 'MONETARY';
    const TYPE_TABLE              = 'TABLE';
    const TYPE_SELECT             = 'SELECT';
    const TYPE_LIST               = 'SELECT2';
    const TYPE_RESULTSET          = 'RESULTSET';
    const TYPE_FILE               = 'FILE';
    const TYPE_HTML               = 'HTML';

    /**
     * Options
     * @var string
     */
    const OPTION_REQUIRED         = 'REQUIRED';
    const OPTION_PK               = 'PK';
    const OPTION_JSONIGNORE       = 'NOJSON';
    const OPTION_LOCAL            = 'LOCAL';
    const OPTION_UNIQ             = 'UNIQ';
}
