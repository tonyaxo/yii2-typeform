<?php

namespace tonyaxo\yii2typeform\api;

/**
 * Interface TypeInterface
 * @author Sergey Bogatyrev <sergey@bogatyrev.me>
 */
interface TypeInterface
{
    const TYPE_DATE = 'date';
    const TYPE_DROPDOWN = 'dropdown';
    const TYPE_EMAIL = 'email';
    const TYPE_FILE_UPLOAD = 'file_upload';
    const TYPE_GROUP = 'group';
    const TYPE_LEGAL = 'legal';
    const TYPE_LONG_TEXT = 'long_text';
    const TYPE_MULTIPLE_CHOICE = 'multiple_choice';
    const TYPE_NUMBER = 'number';
    const TYPE_OPINION_SCALE = 'opinion_scale';
    const TYPE_PAYMENT = 'payment';
    const TYPE_PICTURE_CHOICE = 'picture_choice';
    const TYPE_RATING = 'rating';
    const TYPE_SHORT_TEXT = 'short_text';
    const TYPE_STATEMENT = 'statement';
    const TYPE_WEBSITE = 'website';
    const TYPE_YES_NO = 'yes_no';
}
