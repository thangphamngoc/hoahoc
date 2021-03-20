<?php

namespace App\Http\Validations;

use CustomValidation;

class CleanText implements CustomValidation
{
    public function name()
    {
        return 'is_clean_text';
    }

    public function errorMessage()
    {
        return 'Nội dung không được chứa các từ ngữ vi phạm thuần phong mỹ tục.';
    }
}