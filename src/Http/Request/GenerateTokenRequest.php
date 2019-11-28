<?php

namespace SquareetLabs\LaravelOpenVidu\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use SquareetLabs\LaravelOpenVidu\Enums\MediaMode;
use SquareetLabs\LaravelOpenVidu\Enums\OpenViduRole;
use SquareetLabs\LaravelOpenVidu\Enums\OutputMode;
use SquareetLabs\LaravelOpenVidu\Enums\RecordingLayout;
use SquareetLabs\LaravelOpenVidu\Enums\RecordingMode;

/**
 * Class GenerateTokenRequest
 * @package SquareetLabs\LaravelOpenVidu\Http\Requests
 */
class GenerateTokenRequest extends FormRequest
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
            'session.mediaMode' => ['string', Rule::in([MediaMode::ROUTED, MediaMode::RELAYED])],
            'session.recordingMode' => ['string', Rule::in([RecordingMode::MANUAL, RecordingMode::ALWAYS])],
            'session.defaultOutputMode' => ['string', Rule::in([OutputMode::COMPOSED, OutputMode::INDIVIDUAL])],
            'session.defaultRecordingLayout' => ['string', Rule::in([RecordingLayout::CUSTOM, RecordingLayout::BEST_FIT])],
            'session.defaultCustomLayout' => 'string',
            'session.customSessionId' => 'string',
            'tokenOptions.data' => 'string',
            'tokenOptions.role' => ['string', Rule::in([OpenViduRole::MODERATOR, OpenViduRole::PUBLISHER, OpenViduRole::SUBSCRIBER])],
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
            'session.mediaMode.in' => __('validation.session.mediaMode_in'),
            'session.recordingMode.in' => __('validation.session.recordingMode_in'),
            'session.defaultOutputMode.in' => __('validation.session.defaultOutputMode_in'),
            'session.defaultRecordingLayout.in' => __('validation.session.defaultRecordingLayout_in'),
            'session.defaultCustomLayout.in' => __('validation.session.defaultCustomLayout_in'),
            'tokenOptions.role.in' => __('validation.session.defaultCustomLayout_in'),
        ];
    }
}
