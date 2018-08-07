<?php

namespace tonyaxo\yii2typeform;


use tonyaxo\yii2typeform\api\forms\BaseForm;

interface CreateApiInterface
{
    public function createForm(BaseForm $form): string;
    public function retrieveForm(string $formId): BaseForm;
    /**
     * @param string $search Returns items that contain the specified string.
     * @param int $page The page of results to retrieve. Default `1` is the first page of results.
     * @param int $pageSize Number of results to retrieve per page. Default is `10`. Maximum is `200`.
     * @param string $workspace Retrieve typeforms for the specified workspace.
     * @return array
     */
    public function forms(?string $search = null, ?int $page = null, ?int $pageSize = null, ?string $workspace = null): array;
}
