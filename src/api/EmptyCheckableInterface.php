<?php

namespace tonyaxo\yii2typeform\api;

/**
 * Interface provide method isEmpty to check whether or not objct is empty.
 * @author Sergey Bogatyrev <sergey@bogatyrev.me>
 */
interface EmptyCheckableInterface
{
    /**
     * @return bool
     */
    public function isEmpty(): bool;

    /**
     * @param bool $isEmpty
     */
    public function setEmpty(bool $isEmpty = true): void;
}
