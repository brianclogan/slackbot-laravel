<?php

namespace App\Http\Controllers\Slack;

use Mpociot\SlackBot\Conversation;

class PizzaConversation extends Conversation
{
    protected $size;

    public function askSize()
    {
        $this->ask('What pizza size do you want?', function(Answer $answer) {

            // Save size for next question
            $this->size = $answer->getText();

            $this->say('Got it. Your pizza will be '.$answer->getText());

        });
    }

    public function run()
    {
        // This will be called immediately
        $this->askSize();
    }
}
