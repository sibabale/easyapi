<?php
// app/Http/Controllers/FieldValueController.php

namespace App\Http\Controllers;

use App\Models\FieldValue;
use Illuminate\Http\Request;
use App\Models\EndpointField;
use App\Rules\ValidFieldValueTypeRule;

class FieldValueController extends Controller
{

    private function findAndAuthorizeValue($valueId)
    {
        // Find the FieldValue by ID
        $value = FieldValue::findOrFail($valueId);

        // Authorize the user (you may customize the policy and ability)
        $this->authorize('update', $value);

        return $value;
    }

    public function store(Request $request)
    {

        $this->authorize('create', FieldValue::class,  $request->input('value'));

        $request->validate([
            'project_id' => 'required|int',
            'endpoint_id' => 'required|int',
            'field_id' => 'required|int',
            'value' => [
                'required',
                new ValidFieldValueTypeRule($request->input('field_id'), $request->input('value'))
            ],
        ]);

        // Fetch the field type based on the field_id from the database;
        $field = EndpointField::find($request->input('field_id'));

        if (!$field) {
            return response()->json(['error' => 'Field not found'], 404);
        }

        $fieldAttributes = $field->field_attributes;

        // Assuming 'type' is a property under the 'field_attributes' JSON column
        $fieldType = $fieldAttributes['type'];

        $valueModel = new FieldValue();
        $castedValue = $valueModel->castValue($request->input('value'), $fieldType);

        $value = FieldValue::create([
            'field_id' => $request->input('field_id'),
            'value' => $castedValue,
        ]);

        return response()->json(['value' => $value, 'message' => 'Value stored successfully'], 201);

    }


    public function update(Request $request)
    {
        $request->validate([
            'project_id' => 'required|integer',
            'endpoint_id' => 'required|integer',
            'field_id' => 'required|integer',
            'value_id' => 'required|integer',
            'value' => ['required', new ValidFieldValueTypeRule($request->input('field_id'))],
        ]);


        $valueId = $request->input('value_id');

        // Find the FieldValue by ID
        $value = FieldValue::findOrFail($valueId);

        // Authorize the user to update the FieldValue
        $this->authorize('update', $value);

        // Fetch the field type based on the field_id from the database;
        $field = EndpointField::find($request->input('field_id'));

        if (!$field) {
            return response()->json(['error' => 'Field not found'], 404);
        }

        $fieldAttributes = $field->field_attributes;

        // Assuming 'type' is a property under the 'field_attributes' JSON column
        $fieldType = $fieldAttributes['type'];

        $castedValue = FieldValue::castValue($request->input('value'), $fieldType);

        $value = FieldValue::findOrFail($request->input('value_id'));

        // Update the value
        $value->update([
            'field_id' => $field->id,
            'value' => $castedValue,
        ]);


        return response()->json(['value' => $value, 'message' => 'Value updated successfully'], 200);
    }

    public function destroy(Request $request)
    {

        $request->validate([
            'value_id' => 'required|integer',
        ]);

        $valueId = $request->input('value_id');

        // Find the FieldValue by ID
        $value = FieldValue::findOrFail($valueId);

        // Authorize the user to delete the FieldValue
        $this->authorize('update', $value);

        $value = FieldValue::findOrFail($request->input('value_id'));

        $value->delete();

        return response()->json(['message' => 'Value deleted successfully'], 200);
    }

    public function show(Request $request)
    {

        $request->validate([
            'value_id' => 'required|integer',
        ]);

        $valueId = $request->input('value_id');

        // Find the FieldValue by ID
        $value = FieldValue::findOrFail($valueId);

        // Authorize the user to delete the FieldValue
        $this->authorize('update', $value);

        $value = FieldValue::findOrFail($request->input('value_id'));

        return response()->json(['value' => $value], 200);
    }
}
