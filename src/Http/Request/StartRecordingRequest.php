<?php

namespace SquareetLabs\LaravelOpenVidu\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class StartRecordingRequest
 * @package SquareetLabs\LaravelOpenVidu\Http\Requests
 */
class StartRecordingRequest extends FormRequest
{


    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'hasAudio' => 'boolean',
            'hasVideo' => 'boolean',
            'name' => 'string',
            'outputMode' => 'string',
            'recordingLayout' => 'string',
            'customLayout' => 'string',
            'resolution' => 'string'
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'hasAudio.boolean' => __('validation.recording.hasAudio_boolean'),
            'hasVideo.boolean' => __('validation.recording.hasVideo_boolean'),
        ];
    }
}
