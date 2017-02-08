These can go into the issue tracker if they aren't resolved at the time of first release

1. The rabbit broker address/port and user/password should be from a config file
1. Does this service make a mess of the broker? Queries that get no reply hang forever, need to make them timeout (for the UI, also to cleanup the php AMQP client instance)?... not if there is a clean reply, if the php object doesn't get a reply it will hang around forever waiting for one, should figure out a way to time it out.
1. How do I programatically populate the sender_info (ideally including username from cookie etc.)
1. Can I generate a lockout_key and store it in my session cookie (and apply it to my commands automatically or with a check box?)
1. Can I define a generic way that callbacks will work for dripline_rpc_interface.js? I'm not even entirely certain what I need.
    - check if the return code is 0, 1-99, >=100 and do various things based on that
    - allow the HTML call to the js to provide arbitrary arguments for the callback (to pass it object references to update for example)
    - if no callback is provided, should something happen? maybe a popup saying a reply was received?
    - simplest-case success callback that lets the interface get the value out of the ReplyMessage
