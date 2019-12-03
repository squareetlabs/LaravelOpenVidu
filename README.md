# Laravel client for controlling your videocalls from your Openvidu server.
## This is a Laravel package wrapping OpenVidu Server REST API ##

### Installation ###

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

You must also add the openvidu cache driver to your `config/services.php` file:
```php
return [   
    'stores' => [
            ...
            ...
            'openvidu' => [
                   'driver' => 'openvidu',
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
