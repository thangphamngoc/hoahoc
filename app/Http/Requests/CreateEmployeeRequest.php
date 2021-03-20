<?php

namespace App\Http\Requests;

use App\Http\Validations\CleanText;
use Illuminate\Foundation\Http\FormRequest;

class CreateEmployeeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;

        // $comment = Comment::find($this->route('comment'));

        // return $comment && $this->user()->can('update', $comment);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required|unique:posts|max:255',
            'body' => 'required',
            'publication_date' => 'date',
        ];
    }

    private function applicableValidations()
    {
        return collect([
            new CleanText(),
            // thêm các class Validator khác vào đây
        ]);
    }

    private function useCustomValidations($factory, $validations)
    {
        $validations->each(function ($validation) use ($factory) {
            $factory->extend($validation->name(), $validation->test(), $validation->errorMessage());
        });
    }
}
