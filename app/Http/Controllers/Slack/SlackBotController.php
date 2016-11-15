<?php

namespace App\Http\Controllers\Slack;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Mpociot\SlackBot\Button;
use Mpociot\SlackBot\Question;
use Mpociot\SlackBot\SlackBot;

class SlackBotController extends Controller
{
    /**
     * @param Request $request
     */
    public function handleEventRequest(Request $request)
    {
        $payload = $request->json();
        if ($payload->get('type') === 'url_verification') {
            return $payload->get('challenge');
        }

        $slackBot = app('slackbot');

        if (!$slackBot->isBot()) {

            $slackBot->hears('ping', function (SlackBot $bot) use ($request) {
                $bot->reply('Pong');
            });

            $slackBot->hears('buttons', function (SlackBot $bot) use ($request) {
                $bot->reply(Question::create('Here are some buttons!')->addButton(Button::create('Hello World')->value('hello world'))->callbackId("helloWorldButton"));
            });

            $slackBot->hears('start convo', function (SlackBot $bot, $message) use ($request) {
                $bot->startConversation(new PizzaConversation());
            });

            $slackBot->listen();

        } else {
            return null;
        }
    }
}
