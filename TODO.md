These can go into the issue tracker if they aren't resolved at the time of first release

1. The rabbit broker address/port and user/password should be from a config file
1. Does this service make a mess of the broker? Queries that get no reply hang forever, need to make them timeout (for the UI, also to cleanup the php AMQP client instance)
1. How do I programatically populate the sender_info (ideally including username from cookie etc.)
