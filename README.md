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
Add your OpenVidu API key to your `config/services.php` file:
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

## Usage

### Using endpoints

##### LaravelOpenVidu is very easy to use. By default it exposes six different endpoints.

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


###### 2- Get an existing session

```bash

---------------------------------------------------------------------------------
Method:         GET|HEAD
---------------------------------------------------------------------------------
Route name:     openvidu.session
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

###### 3- Start recording a session

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

###### 4- Stop recording a session

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


###### 5- Get the recording of a session

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

###### 6- Delete the recording of a session

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

###### Get an existing session

```php
use SquareetLabs\LaravelOpenVidu\Facades\OpenVidu;
...
$session = OpenVidu::getSession($customSessionId);
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
