<?php

namespace tonyaxo\yii2typeform;

use tonyaxo\yii2typeform\api\forms\BaseForm;

/**
 * Interface Creatable
 * @author Sergey Bogatyrev <sergey@bogatyrev.me>
 */
interface Creatable
{
    /**
     * Create new form.
     *
     * @param BaseForm $form to create.
     * @return string created Form ID
     */
    public function createForm(BaseForm $form): ?string;

    /**
     * Retrieves a form by the given $formId. Includes any theme and images attached to the form as references.
     *
     * @param string $formId to retrieve.
     * @return null|BaseForm
     */
    public function retrieveForm(string $formId): ?BaseForm;

    /**
     * Retrieves forms.
     *
     * @param string $search Returns items that contain the specified string.
     * @param int $page The page of results to retrieve. Default `1` is the first page of results.
     * @param int $pageSize Number of results to retrieve per page. Default is `10`. Maximum is `200`.
     * @param string $workspace Retrieve typeforms for the specified workspace.
     * @return array
     */
    public function retrieveForms(?string $search = null, ?int $page = null, ?int $pageSize = null, ?string $workspace = null): array;

    /**
     * Deletes the form with the given $formId and all of the form's responses.
     *
     * @param string $formId to delete.
     * @return bool
     */
    public function deleteForm(string $formId): bool;
}
