<?php

use Illuminate\Support\Facades\Broadcast;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

// Broadcast::channel('pesan.{percakapanId}', function ($guru, $percakapanId) {
//     $canAccess = [];

//     if ($guru->email == 'anarmdhn@gmail.com') {
//         $canAccess = [1,2,3,4,5];
//     } else {
//         $canAccess = [1];
//     }

//     return in_array($percakapanId, $canAccess);
//     // return (int) $user->id === (int) $id;
// });
