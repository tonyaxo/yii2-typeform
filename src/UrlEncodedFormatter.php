<?php

namespace tonyaxo\yii2typeform;

use yii\httpclient\Request;

/**
 * Typeform return error if Content-type have charset.
 * @author Sergey Bogatyrev <sergey@bogatyrev.me>
 */
class UrlEncodedFormatter extends \yii\httpclient\UrlEncodedFormatter
{
    /**
     * Set content type without charset.
     * @param Request $request
     * @return Request
     */
    public function format(Request $request)
    {
        $request = parent::format($request);
        $request->getHeaders()->set('Content-Type', 'application/x-www-form-urlencoded');

        return $request;
    }
}
