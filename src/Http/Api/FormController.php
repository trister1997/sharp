<?php

namespace Code16\Sharp\Http\Api;

class FormController extends ApiController
{

    /**
     * @param string $entityKey
     * @param string $instanceId
     * @return \Illuminate\Http\JsonResponse
     * @throws \Code16\Sharp\Exceptions\Auth\SharpAuthorizationException
     * @throws \Code16\Sharp\Exceptions\SharpInvalidEntityKeyException
     */
    public function edit($entityKey, $instanceId)
    {
        sharp_check_ability("view", $entityKey, $instanceId);

        $form = $this->getFormInstance($entityKey);

        return response()->json([
            "fields" => $form->fields(),
            "layout" => $form->formLayout(),
            "data" => $form->instance($instanceId),
            "redirect" => $form->redirect,
            "deletable" => $form->deletable
        ]);
    }

    /**
     * @param string $entityKey
     * @return \Illuminate\Http\JsonResponse
     * @throws \Code16\Sharp\Exceptions\Auth\SharpAuthorizationException
     * @throws \Code16\Sharp\Exceptions\SharpInvalidEntityKeyException
     */
    public function create($entityKey)
    {
        sharp_check_ability("create", $entityKey);

        $form = $this->getFormInstance($entityKey);

        return response()->json([
            "fields" => $form->fields(),
            "layout" => $form->formLayout(),
            "data" => $form->newInstance()
        ]);
    }

    /**
     * @param string $entityKey
     * @param string $instanceId
     * @return \Illuminate\Http\JsonResponse
     * @throws \Code16\Sharp\Exceptions\Auth\SharpAuthorizationException
     * @throws \Code16\Sharp\Exceptions\Form\SharpFormUpdateException
     * @throws \Code16\Sharp\Exceptions\SharpInvalidEntityKeyException
     */
    public function update($entityKey, $instanceId)
    {
        sharp_check_ability("update", $entityKey, $instanceId);

        $this->validateRequest($entityKey);

        $form = $this->getFormInstance($entityKey);

        $form->updateInstance($instanceId, request()->all());

        return response()->json(["ok" => true]);
    }

    /**
     * @param string $entityKey
     * @return \Illuminate\Http\JsonResponse
     * @throws \Code16\Sharp\Exceptions\Auth\SharpAuthorizationException
     * @throws \Code16\Sharp\Exceptions\SharpInvalidEntityKeyException
     */
    public function store($entityKey)
    {
        sharp_check_ability("create", $entityKey);

        $this->validateRequest($entityKey);

        $form = $this->getFormInstance($entityKey);

        $form->storeInstance(request()->all());

        return response()->json(["ok" => true]);
    }

    /**
     * @param string $entityKey
     * @param string $instanceId
     * @return \Illuminate\Http\JsonResponse
     * @throws \Code16\Sharp\Exceptions\Auth\SharpAuthorizationException
     * @throws \Code16\Sharp\Exceptions\SharpInvalidEntityKeyException
     */
    public function delete($entityKey, $instanceId)
    {
        sharp_check_ability("delete", $entityKey, $instanceId);

        $form = $this->getFormInstance($entityKey);

        $form->delete($instanceId);

        return response()->json(["ok" => true]);
    }

    /**
     * @param string $entityKey
     */
    protected function validateRequest(string $entityKey)
    {
        if($this->isSubEntity($entityKey)) {
            list($entityKey, $subEntityKey) = explode(':', $entityKey);
            $validatorClass = config("sharp.entities.{$entityKey}.forms.{$subEntityKey}.validator");

        } else {
            $validatorClass = config("sharp.entities.{$entityKey}.validator");
        }

        if(class_exists($validatorClass)) {
            // Validation is automatically called (FormRequest)
            app($validatorClass);
        }
    }
}