# Laravel client for controlling your videocalls from your Openvidu server.

<p align="center">
<a href="https://scrutinizer-ci.com/g/squareetlabs/LaravelOpenVidu/"><img src="https://scrutinizer-ci.com/g/squareetlabs/LaravelOpenVidu/badges/quality-score.png?b=master" alt="Quality Score"></a>
<a href="https://scrutinizer-ci.com/g/squareetlabs/LaravelOpenVidu/"><img src="https://scrutinizer-ci.com/g/squareetlabs/LaravelOpenVidu/badges/build.png?b=master" alt="Build Status"></a>
<a href="https://scrutinizer-ci.com/g/squareetlabs/LaravelOpenVidu/"><img src="https://scrutinizer-ci.com/g/squareetlabs/LaravelOpenVidu/badges/code-intelligence.svg?b=master" alt="Code Intelligence"></a>
<a href="https://packagist.org/packages/squareetlabs/laravel-openvidu"><img class="latest_stable_version_img" src="https://poser.pugx.org/squareetlabs/laravel-openvidu/v/stable" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/squareetlabs/laravel-openvidu"><img class="total_img" src="https://poser.pugx.org/squareetlabs/laravel-openvidu/downloads" alt="Total Downloads"></a> 
<a href="https://packagist.org/packages/squareetlabs/laravel-openvidu"><img class="license_img" src="https://poser.pugx.org/squareetlabs/laravel-openvidu/license" alt="License"></a>
</p>

### This is a Laravel package wrapping OpenVidu Server REST API
## Installation

You can install this package via composer:
```bash
composer require squareetlabs/laravel-openvidu
```

### Add Service Provider & Facade
#### For Laravel 5.5+
Once the package is added, the service provider and facade will be autodiscovered.

#### For Older versions of Laravel
Add the ServiceProvider to the providers array in `config/app.php`:
```php
SquareetLabs\LaravelOpenVidu\Providers\OpenViduServiceProvider::class,
```

Add the Facade to the aliases array in `config/app.php`:
```php
'OpenVidu' => SquareetLabs\LaravelOpenVidu\Facades\LaravelOpenVidu::class,
```
### Run migrations
```bash
php artisan migrate
```

## Configuration
Add your OpenVidu Server configuration values to your `config/services.php` file:
```php
return [   
    ...
    ...
    'openvidu' => [
           'app' => env('OPENVIDU_APP'), //At the moment, always "OPENVIDUAPP"
           'domain' => env('OPENVIDU_DOMAIN'), //Your OpenVidu Server machine public IP
           'port' => env('OPENVIDU_PORT'), //Listening port of your OpenVidu server, default 4443
           'secret' => env('OPENVIDU_SECRET'), //The password used to secure your OpenVidu Server
           'debug' => env('OPENVIDU_DEBUG') // true or false
       ]
    ...
```
Set `debug` to `true` if you want to debug OpenVidu API consumptions from Guzzle Client

You must also add the openvidu cache driver to your `config/cache.php` file:
```php
return [   
    'stores' => [
            ...
            ...
            'openvidu' => [
                   'driver' => 'openvidu',
                   'table' => 'openvidu_cache'
               ]
    ]
    ...
```

## Usage

### Using endpoints

##### LaravelOpenVidu is very easy to use. By default it exposes 13 different endpoints.

###### 1- Create a token for a new session or an existing session

```bash

---------------------------------------------------------------------------------
Method:         POST
---------------------------------------------------------------------------------
Route name:     openvidu.token
---------------------------------------------------------------------------------
Uri:            openvidu/token 
---------------------------------------------------------------------------------
Body:           {
                    "session":{
                       "mediaMode":"MEDIA_MODE",
                       "recordingMode":"RECORDING_MODE",
                       "customSessionId":"CUSTOM_SESSION_ID",
                       "defaultOutputMode":"OUTPUT_MODE",
                       "defaultRecordingLayout":"RECORDING_LAYOUT",
                       "defaultCustomLayout":"CUSTOM_LAYOUT"
                    },
                    "tokenOptions":{
                       "role":"ROLE",
                       "data":"DATA"
                    }
                 }
---------------------------------------------------------------------------------
Sample return:
                 {
                    "token":{
                       "id":"wss://squareet.com:4443?sessionId=zfgmthb8jl9uellk&token=lnlrtnkwm4v8l7uc&role=PUBLISHER&turnUsername=FYYNRC&turnCredential=yfxxs3",
                       "session":"zfgmthb8jl9uellk",
                       "role":"PUBLISHER",
                       "data":"User Data",
                       "token":"wss://squareet.com:4443?sessionId=zfgmthb8jl9uellk&token=lnlrtnkwm4v8l7uc&role=PUBLISHER&turnUsername=FYYNRC&turnCredential=yfxxs3",
                       "kurentoOptions":{
                          "videoMaxSendBandwidth":700,
                          "allowedFilters":[
                             "GStreamerFilter",
                             "ZBarFilter"
                          ]
                       }
                    }
                }

```


###### 2- Get an existing session from array stored in memory

```bash

---------------------------------------------------------------------------------
Method:         GET|HEAD
---------------------------------------------------------------------------------
Route name:     openvidu.sessions.session
---------------------------------------------------------------------------------
Uri:            openvidu/session/{sessionId}
---------------------------------------------------------------------------------
Sample return:
                {
                   "session":{
                      "sessionId":"TestSession",
                      "createdAt":1538482606338,
                      "mediaMode":"ROUTED",
                      "recordingMode":"MANUAL",
                      "defaultOutputMode":"COMPOSED",
                      "defaultRecordingLayout":"BEST_FIT",
                      "customSessionId":"TestSession",
                      "connections":{
                         "numberOfElements":2,
                         "content":[
                            {
                               "connectionId":"vhdxz7abbfirh2lh",
                               "createdAt":1538482606412,
                               "location":"",
                               "platform":"Chrome 69.0.3497.100 on Linux 64-bit",
                               "token":"wss://localhost:4443?sessionId=TestSession&token=2ezkertrimk6nttk&role=PUBLISHER&turnUsername=H0EQLL&turnCredential=kjh48u",
                               "role":"PUBLISHER",
                               "serverData":"",
                               "clientData":"TestClient1",
                               "publishers":[
                                  {
                                     "createdAt":1538482606976,
                                     "streamId":"vhdxz7abbfirh2lh_CAMERA_CLVAU",
                                     "mediaOptions":{
                                        "hasAudio":true,
                                        "audioActive":true,
                                        "hasVideo":true,
                                        "videoActive":true,
                                        "typeOfVideo":"CAMERA",
                                        "frameRate":30,
                                        "videoDimensions":"{\"width\":640,\"height\":480}",
                                        "filter":{
                   
                                        }
                                     }
                                  }
                               ],
                               "subscribers":[
                   
                               ]
                            },
                            {
                               "connectionId":"maxawd3ysuj1rxvq",
                               "createdAt":1538482607659,
                               "location":"",
                               "platform":"Chrome 69.0.3497.100 on Linux 64-bit",
                               "token":"wss://localhost:4443?sessionId=TestSession&token=ovj1b4ysuqmcirti&role=PUBLISHER&turnUsername=INOAHN&turnCredential=oujrqd",
                               "role":"PUBLISHER",
                               "serverData":"",
                               "clientData":"TestClient2",
                               "publishers":[
                   
                               ],
                               "subscribers":[
                                  {
                                     "createdAt":1538482607799,
                                     "streamId":"vhdxz7abbfirh2lh_CAMERA_CLVAU",
                                     "publisher":"vhdxz7abbfirh2lh"
                                  }
                               ]
                            }
                         ]
                      },
                      "recording":false
                   }
               }
```


###### 3- Get an existing session from OpenVidu Server

```bash

---------------------------------------------------------------------------------
Method:         GET|HEAD
---------------------------------------------------------------------------------
Route name:     openvidu.sessions.session.fetch
---------------------------------------------------------------------------------
Uri:            openvidu/session/{sessionId}/fetch
---------------------------------------------------------------------------------
Sample return:
                {
                   "session":{
                      "sessionId":"TestSession",
                      "createdAt":1538482606338,
                      "mediaMode":"ROUTED",
                      "recordingMode":"MANUAL",
                      "defaultOutputMode":"COMPOSED",
                      "defaultRecordingLayout":"BEST_FIT",
                      "customSessionId":"TestSession",
                      "connections":{
                         "numberOfElements":2,
                         "content":[
                            {
                               "connectionId":"vhdxz7abbfirh2lh",
                               "createdAt":1538482606412,
                               "location":"",
                               "platform":"Chrome 69.0.3497.100 on Linux 64-bit",
                               "token":"wss://localhost:4443?sessionId=TestSession&token=2ezkertrimk6nttk&role=PUBLISHER&turnUsername=H0EQLL&turnCredential=kjh48u",
                               "role":"PUBLISHER",
                               "serverData":"",
                               "clientData":"TestClient1",
                               "publishers":[
                                  {
                                     "createdAt":1538482606976,
                                     "streamId":"vhdxz7abbfirh2lh_CAMERA_CLVAU",
                                     "mediaOptions":{
                                        "hasAudio":true,
                                        "audioActive":true,
                                        "hasVideo":true,
                                        "videoActive":true,
                                        "typeOfVideo":"CAMERA",
                                        "frameRate":30,
                                        "videoDimensions":"{\"width\":640,\"height\":480}",
                                        "filter":{
                   
                                        }
                                     }
                                  }
                               ],
                               "subscribers":[
                   
                               ]
                            },
                            {
                               "connectionId":"maxawd3ysuj1rxvq",
                               "createdAt":1538482607659,
                               "location":"",
                               "platform":"Chrome 69.0.3497.100 on Linux 64-bit",
                               "token":"wss://localhost:4443?sessionId=TestSession&token=ovj1b4ysuqmcirti&role=PUBLISHER&turnUsername=INOAHN&turnCredential=oujrqd",
                               "role":"PUBLISHER",
                               "serverData":"",
                               "clientData":"TestClient2",
                               "publishers":[
                   
                               ],
                               "subscribers":[
                                  {
                                     "createdAt":1538482607799,
                                     "streamId":"vhdxz7abbfirh2lh_CAMERA_CLVAU",
                                     "publisher":"vhdxz7abbfirh2lh"
                                  }
                               ]
                            }
                         ]
                      },
                      "recording":false
                   }
               }
```


###### 4- Returns the list of active sessions

```bash

---------------------------------------------------------------------------------
Method:         GET|HEAD
---------------------------------------------------------------------------------
Route name:     openvidu.sessions
---------------------------------------------------------------------------------
Uri:            openvidu/sessions
---------------------------------------------------------------------------------
Sample return:
                {
                    'sessions' : [
                      "sessionId":"TestSession",
                      "createdAt":1538482606338,
                      "mediaMode":"ROUTED",
                      "recordingMode":"MANUAL",
                      "defaultOutputMode":"COMPOSED",
                      "defaultRecordingLayout":"BEST_FIT",
                      "customSessionId":"TestSession",
                      "connections":{
                         "numberOfElements":2,
                         "content":[
                            {
                               "connectionId":"vhdxz7abbfirh2lh",
                               "createdAt":1538482606412,
                               "location":"",
                               "platform":"Chrome 69.0.3497.100 on Linux 64-bit",
                               "token":"wss://localhost:4443?sessionId=TestSession&token=2ezkertrimk6nttk&role=PUBLISHER&turnUsername=H0EQLL&turnCredential=kjh48u",
                               "role":"PUBLISHER",
                               "serverData":"",
                               "clientData":"TestClient1",
                               "publishers":[
                                  {
                                     "createdAt":1538482606976,
                                     "streamId":"vhdxz7abbfirh2lh_CAMERA_CLVAU",
                                     "mediaOptions":{
                                        "hasAudio":true,
                                        "audioActive":true,
                                        "hasVideo":true,
                                        "videoActive":true,
                                        "typeOfVideo":"CAMERA",
                                        "frameRate":30,
                                        "videoDimensions":"{\"width\":640,\"height\":480}",
                                        "filter":{
                   
                                        }
                                     }
                                  }
                               ],
                               "subscribers":[
                   
                               ]
                            },
                            {
                               "connectionId":"maxawd3ysuj1rxvq",
                               "createdAt":1538482607659,
                               "location":"",
                               "platform":"Chrome 69.0.3497.100 on Linux 64-bit",
                               "token":"wss://localhost:4443?sessionId=TestSession&token=ovj1b4ysuqmcirti&role=PUBLISHER&turnUsername=INOAHN&turnCredential=oujrqd",
                               "role":"PUBLISHER",
                               "serverData":"",
                               "clientData":"TestClient2",
                               "publishers":[
                   
                               ],
                               "subscribers":[
                                  {
                                     "createdAt":1538482607799,
                                     "streamId":"vhdxz7abbfirh2lh_CAMERA_CLVAU",
                                     "publisher":"vhdxz7abbfirh2lh"
                                  }
                               ]
                            }
                         ]
                      },
                      "recording":false
                   },
                    {
                      "sessionId":"TestSession2",
                      "createdAt":1538482606438,
                      "mediaMode":"ROUTED",
                      "recordingMode":"MANUAL",
                      "defaultOutputMode":"COMPOSED",
                      "defaultRecordingLayout":"BEST_FIT",
                      "customSessionId":"TestSession2",
                      "connections":{
                         "numberOfElements":2,
                         "content":[
                            {
                               "connectionId":"vhdxz7abbfirh2lh",
                               "createdAt":1538482606448,
                               "location":"",
                               "platform":"Chrome 69.0.3497.100 on Linux 64-bit",
                               "token":"wss://localhost:4443?sessionId=TestSession&token=2ezkertrimk6nttk&role=PUBLISHER&turnUsername=H0EQLL&turnCredential=kjh48u",
                               "role":"PUBLISHER",
                               "serverData":"",
                               "clientData":"TestClient2",
                               "publishers":[
                                  {
                                     "createdAt":1538482606976,
                                     "streamId":"vhdxz7abbfiras_CAMERA_VAU",
                                     "mediaOptions":{
                                        "hasAudio":true,
                                        "audioActive":true,
                                        "hasVideo":true,
                                        "videoActive":true,
                                        "typeOfVideo":"CAMERA",
                                        "frameRate":30,
                                        "videoDimensions":"{\"width\":640,\"height\":480}",
                                        "filter":{
                   
                                        }
                                     }
                                  }
                               ],
                               "subscribers":[
                   
                               ]
                            },
                            {
                               "connectionId":"ssaxlfaslmcklasdcas",
                               "createdAt":1538482432559,
                               "location":"",
                               "platform":"Chrome 69.0.3497.100 on Linux 64-bit",
                               "token":"wss://localhost:4443?sessionId=TestSession&token=ovj1b4ysuqmcirti&role=PUBLISHER&turnUsername=INOAHN&turnCredential=oujrqd",
                               "role":"PUBLISHER",
                               "serverData":"",
                               "clientData":"TestClient3",
                               "publishers":[
                   
                               ],
                               "subscribers":[
                                  {
                                     "createdAt":1538482607799,
                                     "streamId":"vhdxz7abbfirh2lh_CAMERA_CLVAU",
                                     "publisher":"vhdxz7abbfirh2lh"
                                  }
                               ]
                            }
                         ]
                      },
                      "recording":false
                   }
               }]
                 }
                    
```


###### 5- Returns the list of active connections to the session

```bash

---------------------------------------------------------------------------------
Method:         GET|HEAD
---------------------------------------------------------------------------------
Route name:     openvidu.sessions.session.connections
---------------------------------------------------------------------------------
Uri:            openvidu/session/{sessionId}/connections
---------------------------------------------------------------------------------
Sample return:
                [
                    {
                       "connectionId":"vhdxz7abbfirh2lh",
                       "createdAt":1538482606412,
                       "location":"",
                       "platform":"Chrome 69.0.3497.100 on Linux 64-bit",
                       "token":"wss://localhost:4443?sessionId=TestSession&token=2ezkertrimk6nttk&role=PUBLISHER&turnUsername=H0EQLL&turnCredential=kjh48u",
                       "role":"PUBLISHER",
                       "serverData":"",
                       "clientData":"TestClient1",
                       "publishers":[
                          {
                             "createdAt":1538482606976,
                             "streamId":"vhdxz7abbfirh2lh_CAMERA_CLVAU",
                             "mediaOptions":{
                                "hasAudio":true,
                                "audioActive":true,
                                "hasVideo":true,
                                "videoActive":true,
                                "typeOfVideo":"CAMERA",
                                "frameRate":30,
                                "videoDimensions":"{\"width\":640,\"height\":480}",
                                "filter":{
           
                                }
                             }
                          }
                       ],
                       "subscribers":[
           
                       ]
                    },
                    {
                       "connectionId":"maxawd3ysuj1rxvq",
                       "createdAt":1538482607659,
                       "location":"",
                       "platform":"Chrome 69.0.3497.100 on Linux 64-bit",
                       "token":"wss://localhost:4443?sessionId=TestSession&token=ovj1b4ysuqmcirti&role=PUBLISHER&turnUsername=INOAHN&turnCredential=oujrqd",
                       "role":"PUBLISHER",
                       "serverData":"",
                       "clientData":"TestClient2",
                       "publishers":[
           
                       ],
                       "subscribers":[
                          {
                             "createdAt":1538482607799,
                             "streamId":"vhdxz7abbfirh2lh_CAMERA_CLVAU",
                             "publisher":"vhdxz7abbfirh2lh"
                          }
                       ]
                    }
                 ]
                    
```


###### 6- Forces some user to unpublish a Stream.

```bash

---------------------------------------------------------------------------------
Method:         DELETE
---------------------------------------------------------------------------------
Route name:     openvidu.sessions.session.forceUnpublish
---------------------------------------------------------------------------------
Uri:            openvidu/session/{sessionId}/forceUnpublish/{streamId}
---------------------------------------------------------------------------------
Sample return:
                'unpublished': true
                    
```


###### 7- Forces the user with connectionId to leave the session

```bash

---------------------------------------------------------------------------------
Method:         DELETE
---------------------------------------------------------------------------------
Route name:     openvidu.sessions.session.forceDisconnect
---------------------------------------------------------------------------------
Uri:            openvidu/session/{sessionId}/forceDisconnect/{connectionId}
---------------------------------------------------------------------------------
Sample return:
                'disconnected': true
                    
```


###### 8-  Gracefully closes the Session: unpublishes all streams and evicts every

```bash

---------------------------------------------------------------------------------
Method:         PATCH
---------------------------------------------------------------------------------
Route name:     openvidu.sessions.session.close
---------------------------------------------------------------------------------
Uri:            openvidu/session/{sessionId}/close
---------------------------------------------------------------------------------
Sample return:
                'closed': true
                    
```


###### 9- Checks if a session is being recorded

```bash

---------------------------------------------------------------------------------
Method:         GET|HEAD
---------------------------------------------------------------------------------
Route name:     openvidu.sessions.session.isBeingRecording
---------------------------------------------------------------------------------
Uri:            openvidu/session/{sessionId}/isBeingRecording
---------------------------------------------------------------------------------
Sample return:
                'isBeingRecording': true
                    
```


###### 10- Start recording a session

```bash

---------------------------------------------------------------------------------
Method:         POST
---------------------------------------------------------------------------------
Route name:     openvidu.recording.start 
---------------------------------------------------------------------------------
Uri:            openvidu/recording
---------------------------------------------------------------------------------
Body:
                {
                   "session":"SESSION_ID",
                   "name":"NAME",
                   "outputMode":"OUTPUT_MODE",
                   "hasAudio":"HAS_AUDIO",
                   "hasVideo":"HAS_VIDEO",
                   "resolution":"RESOLUTION",
                   "recordingLayout":"RECORDING_LAYOUT",
                   "customLayout":"CUSTOM_LAYOUT"
                }
---------------------------------------------------------------------------------
Sample return:
                {
                    "recording":{
                      "id":"fds4e07mdug1ga3h",
                      "sessionId":"fds4e07mdug1ga3h",
                      "name":"MyRecording",
                      "outputMode":"COMPOSED",
                      "hasAudio":true,
                      "hasVideo":false,
                      "createdAt":1538483606521,
                      "size":3205004,
                      "duration":12.92,
                      "url":null,
                      "status":"started"
                    }
                }

```


###### 11- Stop recording a session

```bash

---------------------------------------------------------------------------------
Method:         POST
---------------------------------------------------------------------------------
Route name:     openvidu.recording.stop 
---------------------------------------------------------------------------------
Uri:            openvidu/recording/{recordingId}
---------------------------------------------------------------------------------
Sample return:
                {
                    "recording":{
                        "id":"fds4e07mdug1ga3h",
                        "sessionId":"fds4e07mdug1ga3h",
                        "name":"MyRecording",
                        "outputMode":"COMPOSED",
                        "hasAudio":true,
                        "hasVideo":false,
                        "createdAt":1538483606521,
                        "size":3205004,
                        "duration":12.92,
                        "url":null,
                        "status":"stopped"
                    }
                }

```


###### 12- Get the recording of a session

```bash

---------------------------------------------------------------------------------
Method:         GET|HEAD
---------------------------------------------------------------------------------
Route name:     openvidu.recording 
---------------------------------------------------------------------------------
Uri:            openvidu/recording/{recordingId}
---------------------------------------------------------------------------------
Sample return:
                {
                   "recording":{
                       "id":"fds4e07mdug1ga3h",
                       "sessionId":"fds4e07mdug1ga3h",
                       "name":"MyRecording",
                       "outputMode":"COMPOSED",
                       "hasAudio":true,
                       "hasVideo":false,
                       "createdAt":1538483606521,
                       "size":3205004,
                       "duration":12.92,
                       "url":"https://squareet/recordings/{recordingId}/{name}.extension,
                       "status":"available"
                   }
               }

```


###### 13- Delete the recording of a session

```bash

---------------------------------------------------------------------------------
Method:         DELETE
---------------------------------------------------------------------------------
Route name:     openvidu.recording.delete 
---------------------------------------------------------------------------------
Uri:            openvidu/recording/{recordingId}
---------------------------------------------------------------------------------
Returns nothing

```


### Using OpenVidu Facade

###### Create a token for a new session or an existing session
```php
use SquareetLabs\LaravelOpenVidu\Facades\OpenVidu;
use SquareetLabs\LaravelOpenVidu\SessionProperties;
use Illuminate\Support\Str;
...
/** var string */
$customSessionId = Str::random(20);

$sessionProperties = new SessionProperties(MediaMode::ROUTED, RecordingMode::MANUAL, OutputMode::COMPOSED, RecordingLayout::BEST_FIT, $customSessionId);
$session = OpenVidu::createSession($sessionProperties);

$tokenOptions = new TokenOptions(OpenViduRole::PUBLISHER);
$token = $session->generateToken($tokenOptions);

```

###### Get all active session

```php
use SquareetLabs\LaravelOpenVidu\Facades\OpenVidu;
...
$session = OpenVidu::getActiveSessions();
```


###### Get an existing session

```php
use SquareetLabs\LaravelOpenVidu\Facades\OpenVidu;
...
$session = OpenVidu::getSession($customSessionId);
```


###### Get all active connections from session

```php
use SquareetLabs\LaravelOpenVidu\Facades\OpenVidu;
...
$session = $session = OpenVidu::getSession($customSessionId);
$connections = $session->getActiveConnections();
```


###### Close a session

```php
use SquareetLabs\LaravelOpenVidu\Facades\OpenVidu;
...
$session = OpenVidu::getSession($customSessionId);
$closed = $session->close();
```


######  Forces some user to unpublish a Stream.

```php
use SquareetLabs\LaravelOpenVidu\Facades\OpenVidu;
...
$session = OpenVidu::getSession($customSessionId);
$unpublished = $session->forceUnpublish($streamId);
```


######  Forces the user with connectionId to leave the session.

```php
use SquareetLabs\LaravelOpenVidu\Facades\OpenVidu;
...
$session = OpenVidu::getSession($customSessionId);
$disconnect = $session->forceDisconnect($connectionId);
```


######  Checks if a session is being recorded

```php
use SquareetLabs\LaravelOpenVidu\Facades\OpenVidu;
...
$session = OpenVidu::getSession($customSessionId);
$isBeingRecording = $session->isBeingRecording($connectionId);
```


######  Start recording a session

```php
use SquareetLabs\LaravelOpenVidu\Facades\OpenVidu;
use SquareetLabs\LaravelOpenVidu\Enums\OutputMode;
...
/** @var string */
$recordingName = "Recording of my session";
$recordingProperties = new RecordingProperties($customSessionId, true,true, $recordingName, OutputMode::INDIVIDUAL)
$recording = OpenVidu::startRecording($customSessionId);
```


######  Stop recording a session

```php
use SquareetLabs\LaravelOpenVidu\Facades\OpenVidu;
use SquareetLabs\LaravelOpenVidu\Enums\OutputMode;
...
$recording = OpenVidu::stopRecording($recordingId);
```


######  Get the recording of a session

```php
use SquareetLabs\LaravelOpenVidu\Facades\OpenVidu;
use SquareetLabs\LaravelOpenVidu\Enums\OutputMode;
...
$recording = OpenVidu::getRecording($recordingId);
```

######  Delete the recording of a session

```php
use SquareetLabs\LaravelOpenVidu\Facades\OpenVidu;
use SquareetLabs\LaravelOpenVidu\Enums\OutputMode;
...
OpenVidu::deleteRecording($recordingId);
```


### Available Events
At the moment of raising the OpenVidu server we can indicate multiple [configuration options](https://openvidu.io/docs/reference-docs/openvidu-server-params/), one of them is if we want to use the webhook service to receive events in an endpoint. In our case the default endpoint is _'/openvidu/webhook'_ 

##### Event `ParticipantJoined` is launched when a user has connected to a session.  Example of use:

```php
use SquareetLabs\LaravelOpenVidu\Events\ParticipantJoined;

class ParticipantJoinedListener
{
    /**
     * Handle the event.
     *
     * @param  ParticipantJoined  $event
     * @return void
     */
    public function handle(ParticipantJoined $event)
    {
        $event->sessionId;      // Session for which the event was triggered, a string with the session unique identifier
        $event->timestamp;      // Time when the event was triggered, UTC milliseconds
        $event->participantId;  // Identifier of the participant, a string with the participant unique identifier
        $event->platform;       // Complete description of the platform used by the participant to connect to the session
    }
}
```

##### Event `ParticipantLeft` is launchedwhen a user has left a session.  Example of use:

```php
use SquareetLabs\LaravelOpenVidu\Events\ParticipantLeft;

class ParticipantLeftListener
{
    /**
     * Handle the event.
     *
     * @param  ParticipantLeft  $event
     * @return void
     */
    public function handle(ParticipantLeft $event)
    {
        $event->sessionId;      // Session for which the event was triggered
        $event->timestamp;      // Time when the event was triggered
        $event->participantId;  // Identifier of the participant
        $event->platform;       // Complete description of the platform used by the participant to connect to the session
        $event->startTime;      // Time when the participant joined the session
        $event->duration;       // Total duration of the participant's connection to the session
        $event->reason;         // How the participant left the session.
    }
}
```

##### Event `RecordingStatusChanged` is launched when the status of a recording has changed. The status may be: started, stopped, ready, failed.  Example of use:

```php
use SquareetLabs\LaravelOpenVidu\Events\RecordingStatusChanged;

class RecordingStatusChangedListener
{
    /**
     * Handle the event.
     *
     * @param  RecordingStatusChanged  $event
     * @return void
     */
    public function handle(RecordingStatusChanged $event)
    {
       $event->sessionId;	    // Session for which the event was triggered
       $event->timestamp;	    // Time when the event was triggered
       $event->startTime;	    // Time when the recording started
       $event->id;	            // Unique identifier of the recording
       $event->name;	        // Name given to the recording file
       $event->outputMode;	    // Output mode of the recording
       $event->hasAudio;	    // Wheter the recording file has audio or not
       $event->hasVideo;	    // Wheter the recording file has video or not
       $event->recordingLayout;	// The type of layout used in the recording. Only defined if outputMode is COMPOSED and hasVideo is true
       $event->resolution;	    // Resolution of the recorded file. Only defined if outputMode is COMPOSED and hasVideo is true	
       $event->size;            // The size of the video file. 0 until status is stopped
       $event->duration;	    //  Duration of the video file. 0 until status is stopped
       $event->status;	        // Status of the recording
       $event->reason;	        // Why the recording stopped. Only defined when status is stopped or ready
    }
}
```


##### Event `SessionCreated` is launched when a new session has been created.  Example of use:

```php
use SquareetLabs\LaravelOpenVidu\Events\SessionCreated;

class SessionCreatedListener
{
    /**
     * Handle the event.
     *
     * @param  SessionCreated  $event
     * @return void
     */
    public function handle(SessionCreated $event)
    {
        $event->sessionId; // Session for which the event was triggered
        $event->timestamp; // Time when the event was triggered
    }
}
```


##### Event `SessionDestroyed` is launched when when a session has finished.  Example of use:

```php
use SquareetLabs\LaravelOpenVidu\Events\SessionDestroyed;

class SessionDestroyedListener
{
    /**
     * Handle the event.
     *
     * @param  SessionCreated  $event
     * @return void
     */
    public function handle(SessionDestroyed $event)
    {
        $event->sessionId;      // Session for which the event was triggered
        $event->timestamp;      // Time when the event was triggered
        $event->startTime;	    // Time when the session started
        $event->duration;	    // Total duration of the session
        $event->reason;	        // Why the session was destroyed
    }
}
```

##### Event `WebRTCConnectionCreated` is launched hen a new media stream has been established. Can be an "INBOUND" connection (the user is receiving a stream from a publisher of the session) or an "OUTBOUND" connection (the user is a publishing a stream to the session).  Example of use:

```php
use SquareetLabs\LaravelOpenVidu\Events\WebRTCConnectionCreated;

class WebRTCConnectionCreatedListener
{
    /**
     * Handle the event.
     *
     * @param  WebRTCConnectionCreated  $event
     * @return void
     */
    public function handle(WebRTCConnectionCreated $event)
    {
       $event->sessionId;        // Session for which the event was triggered
       $event->timestamp;        // Time when the event was triggered	UTC milliseconds
       $event->participantId;    // Identifier of the participant	
       $event->connection;       // Whether the media connection is an inbound connection (the participant is receiving media from OpenVidu) or an outbound connection (the participant is sending media to OpenVidu)	["INBOUND","OUTBOUND"]
       $event->receivingFrom;    // If connection is "INBOUND", the participant from whom the media stream is being received	
       $event->audioEnabled;     // Whether the media connection has negotiated audio or not
       $event->videoEnabled;     // Whether the media connection has negotiated video or not
       $event->videoSource;      // If videoEnabled is true, the type of video that is being transmitted
       $event->videoFramerate;   // If videoEnabled is true, the framerate of the transmitted video
       $event->videoDimensions;  // If videoEnabled is true, the dimensions transmitted video
    }
}
```

##### Event `WebRTCConnectionCreated` is launched when  when any media stream connection is closed.  Example of use:

```php
use SquareetLabs\LaravelOpenVidu\Events\WebRTCConnectionDestroyed;

class WebRTCConnectionDestroyedListener
{
    /**
     * Handle the event.
     *
     * @param  WebRTCConnectionDestroyed  $event
     * @return void
     */
    public function handle(WebRTCConnectionDestroyed $event)
    {
       $event->sessionId;        // Session for which the event was triggered
       $event->timestamp;        // Time when the event was triggered	UTC milliseconds
       $event->participantId;    // Identifier of the participant	
       $event->connection;       // Whether the media connection is an inbound connection (the participant is receiving media from OpenVidu) or an outbound connection (the participant is sending media to OpenVidu)	["INBOUND","OUTBOUND"]
       $event->receivingFrom;    // If connection is "INBOUND", the participant from whom the media stream is being received	
       $event->audioEnabled;     // Whether the media connection has negotiated audio or not
       $event->videoEnabled;     // Whether the media connection has negotiated video or not
       $event->videoSource;      // If videoEnabled is true, the type of video that is being transmitted
       $event->videoFramerate;   // If videoEnabled is true, the framerate of the transmitted video
       $event->videoDimensions;  // If videoEnabled is true, the dimensions transmitted video
       $event->startTime;        // Time when the media connection was established	UTC milliseconds
       $event->duration;         // Total duration of the media connection	Seconds
       $event->reason;           // How the WebRTC connection was destroyed
    }
}
```

Finally remember to add them to your `EventServiceProvider`:
````php
protected $listen = [
        ...
        'SquareetLabs\LaravelOpenVidu\Events\ParticipantJoined' => [
            'App\Listeners\ParticipantJoinedListener',
        ],
        'SquareetLabs\LaravelOpenVidu\Events\ParticipantLeft' => [
            'App\Listeners\ParticipantLeftListener',
        ],
        'SquareetLabs\LaravelOpenVidu\Events\RecordingStatusChanged' => [
            'App\Listeners\RecordingStatusChangedListener',
        ],
        'SquareetLabs\LaravelOpenVidu\Events\SessionCreated' => [
            'App\Listeners\SessionCreatedListener',
        ],
        'SquareetLabs\LaravelOpenVidu\Events\SessionDestroyed' => [
            'App\Listeners\SessionDestroyedListener',
        ],
        'SquareetLabs\LaravelOpenVidu\Events\WebRTCConnectionCreated' => [
            'App\Listeners\WebRTCConnectionCreatedListener',
        ],
        'SquareetLabs\LaravelOpenVidu\Events\WebRTCConnectionDestroyed' => [
            'App\Listeners\WebRTCConnectionDestroyedListener',
        ],
        ...
    ];
````


## OpenVidu
Visit [OpenVidu Documentation](https://openvidu.io/docs/home/) for more information.

## Support
Feel free to post your issues in the issues section.

## Credits
- [Alberto Rial Barreiro](https://github.com/alberto-rial)
- [Jacobo Cantorna Cigarrán](https://github.com/jcancig)
- [SquareetLabs](https://www.squareet.com)
- [All Contributors](../../contributors)

## License
The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
