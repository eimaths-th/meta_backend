<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class LineController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }
    public function testView()
    {
        //
        return view('line_test_view');
    }

    public function generateTTS(Request $request)
    {
        $ssmlText = $request->input('ssml');
    }


    public function sendMessage(Request $request)
    {
        $ref = $request->input('ref'); // Capture the ref parameter from the URL
        $url = $request->input('url'); // Get the URL passed from the Blade template

        $lineUserId = 'U25fc5496e631e0cab0923f8f3cfc6db0'; // Replace this with the Line user ID (you'll need to collect this via webhook)

        $httpClient = new Client();
        $response = $httpClient->post('https://api.line.me/v2/bot/message/push', [
            'headers' => [
                'Authorization' => 'Bearer ' . env('LINE_ACCESS_TOKEN'), // Line Access Token from .env
                'Content-Type' => 'application/json',
            ],
            'json' => [
                'to' => $lineUserId,
                'messages' => [
                    [
                        'type' => 'template',
                        'altText' => 'Contact Admin',
                        'template' => [
                            'type' => 'buttons',
                            'thumbnailImageUrl' => 'https://form.metaknowledge.co.th/images/infinite-c.png', // Thumbnail image URL
                            // 'thumbnailImageUrl' => asset('images/infinite-c.png'), // Thumbnail image URL
                            'title' => 'Contact Admin', // Title of the message
                            'text' => 'your ref : ' . $ref, // Text in the message
                            'actions' => [
                                [
                                    'type' => 'uri', // Link to a website
                                    'label' => 'URL for your order',
                                    'uri' => $url // Use the captured URL from the request
                                ],
                            ]
                        ]
                    ]
                ]
            ]
        ]);

        // return response()->json(['status' => 'Message sent']); // i want return back or $url
        $addLineUrl = 'https://line.me/R/ti/p/@352vgbrf?ref=' . $ref;
        return redirect($addLineUrl);
    }

    public function webhook(Request $request)
    {
        $events = $request->input('events');

        // Extract the referral code from query parameters
        $ref = $request->query('ref'); // Capture referral from the URL parameter
        Log::info('Referral code from query:', ['ref' => $ref]);

        foreach ($events as $event) {
            if ($event['type'] === 'follow') {
                $userId = $event['source']['userId'];

                // Check if referral code exists
                if ($ref) {
                    $this->sendReferralMessage($userId, $ref, $request);
                } else {
                    $ref_error = 'null';
                    $this->sendReferralMessage($userId, $ref_error, $request);
                }
            }
        }

        return response()->json(['status' => 'Webhook received']);
    }

    public function sendReferralMessage($lineUserId, $ref,$request)
    {
        $httpClient = new Client();
        $response = $httpClient->post('https://api.line.me/v2/bot/message/push', [
            'headers' => [
                'Authorization' => 'Bearer ' . env('LINE_ACCESS_TOKEN'),
                'Content-Type' => 'application/json',
            ],

            'json' => [
                'to' => $lineUserId, // The user's Line ID
                'messages' => [
                    [
                        'type' => 'text',
                        'text' => 'Thank you for following us! Your referral code is: ' . $ref . "\n".
                        'Request : ' . $request,
                    ],
                ],
            ]
        ]);

        return response()->json(['status' => 'Referral message sent']);
    }
    // 'json' => [
    //     'to' => $lineUserId,
    //     'messages' => [
    //         [
    //             'type' => 'template',
    //             'altText' => 'Contact Admin',
    //             'template' => [
    //                 'type' => 'buttons',
    //                 'thumbnailImageUrl' => 'https://form.metaknowledge.co.th/images/infinite-c.png', // Thumbnail image URL
    //                 // 'thumbnailImageUrl' => asset('images/infinite-c.png'), // Thumbnail image URL
    //                 'title' => 'Contact Admin', // Title of the message
    //                 'text' => 'your ref : ' . $ref, // Text in the message
    //                 'actions' => [
    //                     [
    //                         'type' => 'uri', // Link to a website
    //                         'label' => 'URL for your order',
    //                         // 'uri' => $url // Use the captured URL from the request
    //                     ],
    //                 ]
    //             ]
    //         ]
    //     ]
    // ],
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
