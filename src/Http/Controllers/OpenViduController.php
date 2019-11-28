<?php

namespace SquareetLabs\LaravelOpenVidu\Http\Controllers;

use Illuminate\Routing\Controller;
use SquareetLabs\LaravelOpenVidu\Builders\RecordingPropertiesBuilder;
use SquareetLabs\LaravelOpenVidu\Builders\SessionPropertiesBuilder;
use SquareetLabs\LaravelOpenVidu\Builders\TokenOptionsBuilder;
use SquareetLabs\LaravelOpenVidu\Facades\OpenVidu;
use SquareetLabs\LaravelOpenVidu\Http\Requests\GenerateTokenRequest;
use SquareetLabs\LaravelOpenVidu\Http\Requests\StartRecordingRequest;

/**
 * Class SmsUpReportController
 * @package SquareetLabs\LaravelOpenVidu\Http\Controllers
 */
class OpenViduController extends Controller
{
    /**
     * @param GenerateTokenRequest $request
     * @return string
     */
    public function token(GenerateTokenRequest $request)
    {
        $session = OpenVidu::createSession(SessionPropertiesBuilder::build($request->get('session')));
        $token = $session->generateToken(TokenOptionsBuilder::build($request->get('tokenOptions')));
        return response()->json(['token' => $token], 200);
    }

    /**
     * @param string $sessionId
     * @return string
     */
    public function session(string $sessionId)
    {
        $session = OpenVidu::getSession($sessionId);
        return response()->json(['session' => $session], 200);
    }

    /**

     * @return string
     */
    public function sessions()
    {
        $sessions = OpenVidu::getActiveSessions();
        return response()->json(['sessions' => $sessions], 200);
    }

    /**
     * @param StartRecordingRequest $request
     * @return string
     */
    public function startRecording(StartRecordingRequest $request)
    {
        $recording = OpenVidu::startRecording(RecordingPropertiesBuilder::build($request->all()));
        return response()->json(['recording' => $recording], 200);
    }


    /**
     * @param string $recordingId
     * @return string
     */
    public function stopRecording(string $recordingId)
    {
        $recording = OpenVidu::stopRecording($recordingId);
        return response()->json(['recording' => $recording], 200);
    }

    /**
     * @param string $recordingId
     * @return string
     */
    public function recording(string $recordingId)
    {
        $recording = OpenVidu::getRecording($recordingId);
        return response()->json(['recording' => $recording], 200);
    }


    /**
     * @param string $recordingId
     * @return string
     */
    public function deleteRecording(string $recordingId)
    {
        $recording = OpenVidu::deleteRecording($recordingId);
        return response()->json(['recording' => $recording], 200);
    }
}
