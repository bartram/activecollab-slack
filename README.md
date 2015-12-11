# activecollab-slack

Slack integration for Active Collab 4. Following events are pushed to pre-defined channels:

- new task
- new comments
- completed tasks


## Requirements

- Active Collab 4.2.x
- Project's custom field 1 is not yet in use (if you want to use more than one channel).
- Project's custom field 2 is not yet in use (for multiple teams).


## Installation

1. [Download sources](https://github.com/bartram/activecollab-slack/archive/master.zip) and extract them to `custom/modules/slack` within your Active Collab.
2. Go to [slack.com](https://api.slack.com/web) and issue an auth token.
3. Open your `config/config.php` and enter your token and/or teams (see [Configuration](#configuration)). 
4. Login as admin and install module via "Administration → Modules".
5. Go to "Administration → Project Settings" and enable the first custom field. A good name for the field might be "Slack channel". If you're using more than one team, also enable the second custom field (you might name it "Slack team").
6. The custom field(s) will now appear under project settings. Enter the name of the channel where messages will be posted to (f.e. "#general" or "privategroup") and also set the team (f.e. "teamone").


## Configuration

### Options

All options are set in your Active Collab config: `config/config.php`

#### API Token (required)

If you only have one team, set the API token via `define('SLACK_API_TOKEN', 'xoxp-YOUR-TOKEN-HERE');`.

Multiple teams require multiple tokens, so we define them by adding a name to the constant above:

    define('SLACK_API_TOKEN_TEAMONE', 'xoxp-YOUR-FIRST-TOKEN-HERE');
    define('SLACK_API_TOKEN_TEAMTWO', 'xoxp-YOUR-SECOND-TOKEN-HERE');

Team names must be uppercase and be prefixed with an underscore.

#### Default Channel (optional)

The default channel is set to #general. You can set a custom one by changing the `SLACK_DEFAULT_CHANNEL`:  
`define('SLACK_DEFAULT_CHANNEL', '#example');`


## License

Open source licensed under the MIT license (see LICENSE file for details).
