<?php

namespace App\Exception;


/**
 * Typage de l'exception possible pour pouvoir catch ou non dans un outil de tracking comme Sentry par exemple, ou de simplement pouvoir trier (ex: criticité, fonctionnelle/technique, etc)
 */
class PromotionValidationRuleException extends \Exception
{

}