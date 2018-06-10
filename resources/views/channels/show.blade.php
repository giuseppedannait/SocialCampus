@extends('layouts.app')

@section('content')
    <div class="container">
        @if(session()->has('status'))
            <p class="alert alert-info">
                {{	session()->get('status') }}
            </p>
        @endif
        <div class="col-sm-6 col-sm-offset-3">
            <div class="panel panel-default">
                <div class="panel-heading">
                    User Details
                </div>
                <div class="panel-body">
                    {
                      "id": "1671924956177115",
                      "name": "SocialCampus",
                      "posts": {
                        "data": [
                          {
                            "comments": {
                              "data": [
                                {
                                  "created_time": "2018-05-18T14:43:37+0000",
                                  "from": {
                                    "name": "Mario Rossi",
                                    "id": "1751422808285475"
                                  },
                                  "message": "bello",
                                  "id": "1671933449509599_1691055210930756"
                                }
                              ],
                              "paging": {
                                "cursors": {
                                  "before": "WTI5dGJXVnVkRjlqZAFhKemIzSTZANVFk1TVRBMU5USXhNRGt6TURjMU5qb3hOVEkyTmpVME5qRTMZD",
                                  "after": "WTI5dGJXVnVkRjlqZAFhKemIzSTZANVFk1TVRBMU5USXhNRGt6TURjMU5qb3hOVEkyTmpVME5qRTMZD"
                                }
                              }
                            },
                            "id": "1671924956177115_1671933449509599"
                          },
                          {
                            "id": "1671924956177115_1671929489509995"
                          }
                        ],
                        "paging": {
                          "cursors": {
                            "before": "Q2c4U1pXNTBYM0YxWlhKNVgzTjBiM0o1WDJsa0R5VXhOamN4T1RJME9UVTJNVGMzTVRFMU9pMDJNRGM0TkRRM09URTROamN3TlRVNE16RTVEd3hoY0dsZAmMzUnZAjbmxmYVdRUElURTJOekU1TWpRNU5UWXhOemN4TVRWZAk1UWTNNVGt6TXpRME9UVXdPVFU1T1E4RWRHbHRaUVphOUdUcEFRPT0ZD",
                            "after": "Q2c4U1pXNTBYM0YxWlhKNVgzTjBiM0o1WDJsa0R5VXhOamN4T1RJME9UVTJNVGMzTVRFMU9pMDBOemMzTmpFNE1URXhPVGcyTmpVMk16RXpEd3hoY0dsZAmMzUnZAjbmxmYVdRUElURTJOekU1TWpRNU5UWXhOemN4TVRWZAk1UWTNNVGt5T1RRNE9UVXdPVGs1TlE4RWRHbHRaUVphOUdQbEFRPT0ZD"
                          }
                        }
                      }
                    }
                </div>
            </div>
        </div>
            <div class="col-sm-6 col-sm-offset-3">
                <a href="{{ route('channels.show', 1) }}" class="btn btn-success btn-xs">Aggiorna i dati</a>
            </div>
    </div>
@endsection